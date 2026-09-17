<?php

namespace App\Services;

use App\Models\CourseFolder;
use App\Models\CourseMaterial;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class CourseFolderZipService
{
    /**
     * Build and stream a ZIP of a folder (including nested subfolders).
     *
     * @param  bool  $studentVisibleOnly  When true, skip private folders/files.
     */
    public function download(CourseFolder $folder, bool $studentVisibleOnly = false): BinaryFileResponse
    {
        if (!class_exists(ZipArchive::class)) {
            abort(500, 'ZIP support is not available on this server.');
        }

        if ($studentVisibleOnly && !$folder->isVisibleToStudents()) {
            abort(403, 'This folder is private and not available to students.');
        }

        $folderIds = $this->descendantFolderIds($folder, $studentVisibleOnly);
        $materialsQuery = CourseMaterial::whereIn('folder_id', $folderIds);

        if ($studentVisibleOnly) {
            $materialsQuery->where('is_active', true);
        }

        $materials = $materialsQuery->orderBy('title')->get();
        $pathsById = $this->relativePathsByFolderId($folder, $folderIds);
        $tmpPath = storage_path('app/tmp/folder_' . $folder->id . '_' . uniqid('', true) . '.zip');
        if (!is_dir(dirname($tmpPath))) {
            mkdir(dirname($tmpPath), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($tmpPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Could not create ZIP archive.');
        }

        // Always keep folder structure (empty folders download as empty ZIP dirs)
        foreach ($pathsById as $relPath) {
            $dir = trim($relPath, '/');
            if ($dir !== '') {
                $zip->addEmptyDir($dir);
            }
        }

        $usedNames = [];

        foreach ($materials as $material) {
            if (!$material->file_path || !Storage::disk('local')->exists($material->file_path)) {
                continue;
            }

            $ext = strtolower((string) ($material->file_type ?: pathinfo($material->file_path, PATHINFO_EXTENSION)));
            $base = pathinfo($material->title ?: 'material', PATHINFO_FILENAME);
            $safeBase = preg_replace('/[^\w\s.\-()]+/u', '_', $base) ?: 'material';
            $fileName = $ext ? ($safeBase . '.' . $ext) : $safeBase;

            $dir = trim($pathsById[$material->folder_id] ?? $folder->name, '/');
            $entry = $dir === '' ? $fileName : ($dir . '/' . $fileName);

            // Avoid collisions inside the archive
            $unique = $entry;
            $i = 2;
            while (isset($usedNames[$unique])) {
                $unique = $dir === ''
                    ? ($safeBase . '_' . $i . ($ext ? '.' . $ext : ''))
                    : ($dir . '/' . $safeBase . '_' . $i . ($ext ? '.' . $ext : ''));
                $i++;
            }
            $usedNames[$unique] = true;

            $zip->addFile(storage_path('app/' . $material->file_path), $unique);
        }

        $zip->close();

        if (!is_file($tmpPath)) {
            abort(500, 'Could not create ZIP archive.');
        }

        $zipName = preg_replace('/[^\w\s.\-()]+/u', '_', $folder->name) ?: 'folder';
        $zipName = trim($zipName) . '.zip';

        return response()->download($tmpPath, $zipName)->deleteFileAfterSend(true);
    }

    /**
     * @return array<int, int>
     */
    private function descendantFolderIds(CourseFolder $root, bool $studentVisibleOnly): array
    {
        $all = CourseFolder::where('course_id', $root->course_id)->get()->groupBy('parent_id');
        $ids = [];
        $queue = [$root];

        while ($queue) {
            /** @var CourseFolder $node */
            $node = array_shift($queue);
            if ($studentVisibleOnly && !$node->is_active) {
                continue;
            }
            $ids[] = (int) $node->id;
            foreach ($all[$node->id] ?? [] as $child) {
                $queue[] = $child;
            }
        }

        return $ids;
    }

    /**
     * Map folder_id => relative path from the downloaded root (inclusive).
     *
     * @param  array<int, int>  $folderIds
     * @return array<int, string>
     */
    private function relativePathsByFolderId(CourseFolder $root, array $folderIds): array
    {
        $folders = CourseFolder::whereIn('id', $folderIds)->get()->keyBy('id');
        $paths = [];

        foreach ($folders as $id => $folder) {
            $parts = [];
            $node = $folder;
            $guard = 0;
            while ($node && $guard < 30) {
                array_unshift($parts, $node->name);
                if ((int) $node->id === (int) $root->id) {
                    break;
                }
                $node = $node->parent_id ? ($folders[$node->parent_id] ?? null) : null;
                $guard++;
            }
            $safeParts = array_map(
                fn ($p) => preg_replace('/[^\w\s.\-()]+/u', '_', $p) ?: 'folder',
                $parts
            );
            $paths[(int) $id] = implode('/', $safeParts);
        }

        return $paths;
    }
}
