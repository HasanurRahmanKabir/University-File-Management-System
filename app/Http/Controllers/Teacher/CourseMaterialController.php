<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use App\Models\CourseFolder;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    private const ALLOWED_EXTENSIONS = [
        'pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'csv',
        'zip', 'rar', '7z', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'txt',
    ];

    /** Extensions that may contain executable scripts — never inline-preview */
    private const UNSAFE_PREVIEW_EXTENSIONS = ['svg', 'html', 'htm', 'xml', 'js'];

    private function fileValidationRule(bool $required): array
    {
        $rule = [
            $required ? 'required' : 'nullable',
            'file',
            'max:20480',
            'mimes:' . implode(',', self::ALLOWED_EXTENSIONS),
        ];

        return $rule;
    }

    private function assertAllowedExtension(\Illuminate\Http\UploadedFile $file): void
    {
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, self::ALLOWED_EXTENSIONS, true)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'file' => 'File type ".' . $ext . '" is not allowed. Allowed: PDF, DOC/DOCX, PPT/PPTX, XLS, ZIP, images (JPG/PNG/GIF/WEBP), TXT. SVG is blocked for security.',
            ]);
        }
    }

    public function index(Request $request)
    {
        $teacherDepartmentId = Auth::user()->department_id;
        $activeSemesterIds = \App\Models\Semester::running($teacherDepartmentId)->pluck('id')->toArray();

        $coursesQuery = Course::where('teacher_id', Auth::id())
            ->where('is_active', true)
            ->whereIn('semester_id', $activeSemesterIds)
            ->withCount(['materials', 'folders']);

        $courses = (clone $coursesQuery)->orderBy('course_code')->get();
        $courseIds = $courses->pluck('id');

        $allFoldersFlat = CourseFolder::whereIn('course_id', $courseIds)
            ->withCount(['materials', 'children'])
            ->orderBy('name')
            ->get();

        $foldersById = $allFoldersFlat->keyBy('id');
        $allFoldersFlat->each(function ($folder) use ($foldersById) {
            $parts = [$folder->name];
            $current = $folder;
            $guard = 0;
            while ($current->parent_id && isset($foldersById[$current->parent_id]) && $guard < 20) {
                $current = $foldersById[$current->parent_id];
                array_unshift($parts, $current->name);
                $guard++;
            }
            $folder->path_label = implode(' / ', $parts);
        });

        $allFolders = $allFoldersFlat->groupBy('course_id');

        $activeCourse = null;
        $activeFolder = null;
        $folderBreadcrumbs = collect();
        $browserFolders = collect();
        $materials = null;
        $courseLibrary = null;
        $viewMode = 'library';

        if ($request->filled('folder_id')) {
            $activeFolder = CourseFolder::with(['course', 'parent'])->find($request->folder_id);
            if ($activeFolder && $courseIds->contains($activeFolder->course_id)) {
                $activeCourse = $courses->firstWhere('id', $activeFolder->course_id)
                    ?? Course::withCount(['materials', 'folders'])->find($activeFolder->course_id);

                // Build breadcrumb chain root → … → current
                $chain = collect();
                $node = $activeFolder;
                $guard = 0;
                while ($node && $guard < 20) {
                    $chain->prepend($node);
                    $node = $node->parent_id ? ($foldersById[$node->parent_id] ?? CourseFolder::find($node->parent_id)) : null;
                    $guard++;
                }
                $folderBreadcrumbs = $chain;
            } else {
                $activeFolder = null;
            }
        } elseif ($request->filled('course_id')) {
            if ($courseIds->contains((int) $request->course_id)) {
                $activeCourse = $courses->firstWhere('id', (int) $request->course_id)
                    ?? Course::withCount(['materials', 'folders'])->find($request->course_id);
            }
        }

        $totalFiles = CourseMaterial::whereIn('course_id', $courseIds)->count();
        $folderCount = $allFoldersFlat->count();

        if ($activeCourse) {
            $viewMode = 'browser';

            $parentScope = $activeFolder ? $activeFolder->id : null;
            $browserFolders = CourseFolder::where('course_id', $activeCourse->id)
                ->where('parent_id', $parentScope)
                ->withCount(['materials', 'children'])
                ->orderBy('name')
                ->get();

            $materialsQuery = CourseMaterial::with(['course', 'folder'])
                ->where('course_id', $activeCourse->id);

            if ($activeFolder) {
                $materialsQuery->where('folder_id', $activeFolder->id);
            } else {
                $materialsQuery->whereNull('folder_id');
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $materialsQuery->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('file_type', 'like', "%{$search}%");
                });
            }

            $materials = $materialsQuery->latest()->paginate(20)->appends($request->all());
        } else {
            $libraryQuery = Course::where('teacher_id', Auth::id())
                ->where('is_active', true)
                ->whereIn('semester_id', $activeSemesterIds)
                ->withCount(['materials', 'folders']);

            if ($request->filled('search')) {
                $search = $request->search;
                $libraryQuery->where(function ($q) use ($search) {
                    $q->where('course_code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('subtitle', 'like', "%{$search}%");
                });
            }

            $courseLibrary = $libraryQuery->orderBy('course_code')->paginate(15)->appends($request->all());
        }

        $folders = $allFolders;

        return view('teacher.uploadmaterials', compact(
            'materials',
            'courses',
            'folders',
            'allFolders',
            'activeFolder',
            'activeCourse',
            'browserFolders',
            'folderBreadcrumbs',
            'courseLibrary',
            'viewMode',
            'totalFiles',
            'folderCount'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'folder_id' => 'nullable|exists:course_folders,id',
            'title'     => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'file'      => $this->fileValidationRule(true),
        ]);

        $course = Course::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        if (!empty($validated['folder_id'])) {
            $folder = CourseFolder::findOrFail($validated['folder_id']);
            if ($folder->course_id !== (int) $validated['course_id']) {
                return back()->with('error', 'Invalid folder selected for this course.');
            }
        }

        if ($request->hasFile('file')) {
            $this->assertAllowedExtension($request->file('file'));
            $path = $request->file('file')->store('course_materials', 'local');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }

        $validated['uploaded_by'] = Auth::id();
        $validated['folder_id'] = $validated['folder_id'] ?? null;

        CourseMaterial::create($validated);

        $redirect = ['course_id' => $validated['course_id']];
        if (!empty($validated['folder_id'])) {
            $redirect = ['folder_id' => $validated['folder_id']];
        }

        return redirect()
            ->route('teacher.course-materials.index', $redirect)
            ->with('success', 'Material uploaded successfully.');
    }

    public function destroy(CourseMaterial $course_material)
    {
        if ($course_material->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        if ($course_material->file_path && Storage::disk('local')->exists($course_material->file_path)) {
            Storage::disk('local')->delete($course_material->file_path);
        }
        $course_material->delete();

        return back()->with('success', 'Material deleted successfully.');
    }

    public function update(Request $request, CourseMaterial $course_material)
    {
        if ($course_material->course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'folder_id' => 'nullable|exists:course_folders,id',
            'title'     => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'file'      => $this->fileValidationRule(false),
        ]);

        $course = Course::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        if (!empty($validated['folder_id'])) {
            $folder = CourseFolder::findOrFail($validated['folder_id']);
            if ($folder->course_id !== (int) $validated['course_id']) {
                return back()->with('error', 'Invalid folder selected for this course.');
            }
        }

        if ($request->hasFile('file')) {
            $this->assertAllowedExtension($request->file('file'));
            if ($course_material->file_path && Storage::disk('local')->exists($course_material->file_path)) {
                Storage::disk('local')->delete($course_material->file_path);
            }
            $path = $request->file('file')->store('course_materials', 'local');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }

        $validated['folder_id'] = $validated['folder_id'] ?? null;
        $course_material->update($validated);

        return back()->with('success', 'Material updated successfully.');
    }

    public function download(\App\Models\CourseMaterial $material)
    {
        if ($material->course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if (!$material->file_path || !Storage::disk('local')->exists($material->file_path)) {
            abort(404, 'File not found on the server.');
        }

        $ext = strtolower($material->file_type ?? pathinfo($material->file_path, PATHINFO_EXTENSION));
        $base = pathinfo($material->title ?: 'material', PATHINFO_FILENAME);
        $safeName = preg_replace('/[^\w\s.\-()]+/u', '_', $base) ?: 'material';
        $downloadName = $ext ? ($safeName . '.' . $ext) : $safeName;

        return response()->download(storage_path('app/' . $material->file_path), $downloadName);
    }

    public function preview(\App\Models\CourseMaterial $material)
    {
        if ($material->course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if (!$material->file_path || !Storage::disk('local')->exists($material->file_path)) {
            abort(404, 'File not found on the server.');
        }

        $ext = strtolower($material->file_type ?? pathinfo($material->file_path, PATHINFO_EXTENSION));
        if (in_array($ext, self::UNSAFE_PREVIEW_EXTENSIONS, true)) {
            abort(403, 'This file type cannot be previewed inline for security reasons. Please download it instead.');
        }

        return response()->file(storage_path('app/' . $material->file_path), [
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
