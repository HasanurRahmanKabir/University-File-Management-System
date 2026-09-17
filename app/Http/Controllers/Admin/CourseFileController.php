<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use App\Models\CourseFolder;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseFileController extends Controller
{
    private const ALLOWED_EXTENSIONS = [
        'pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'csv',
        'zip', 'rar', '7z', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'txt',
    ];

    /** Extensions that may contain executable scripts — never inline-preview */
    private const UNSAFE_PREVIEW_EXTENSIONS = ['svg', 'html', 'htm', 'xml', 'js'];

    private function fileValidationRule(bool $required): array
    {
        return [
            $required ? 'required' : 'nullable',
            'file',
            'max:20480',
            'mimes:' . implode(',', self::ALLOWED_EXTENSIONS),
        ];
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
        $teachers = User::where('role', 'teacher')->where('is_active', true)->orderBy('name')->get();
        $courses = Course::where('is_active', true)
            ->with('teacher:id,name')
            ->orderBy('course_code')
            ->get(['id', 'course_code', 'title', 'teacher_id', 'department_id']);

        // Stats
        $totalFiles = CourseMaterial::count();
        $weeklyFiles = CourseMaterial::where('created_at', '>=', now()->subDays(7))->count();
        $pdfCount = CourseMaterial::where('file_type', 'like', 'pdf')->count();
        $pdfPercentage = $totalFiles > 0 ? round(($pdfCount / $totalFiles) * 100) : 0;

        $totalSizeBytes = (int) CourseMaterial::sum('file_size');
        $totalSizeGB = round($totalSizeBytes / 1073741824, 2);
        if ($totalSizeGB < 0.1) {
            $storageUsed = round($totalSizeBytes / 1048576, 2) . ' MB';
        } else {
            $storageUsed = $totalSizeGB . ' GB';
        }

        $allFoldersFlat = CourseFolder::orderBy('name')->get();
        $foldersById = $allFoldersFlat->keyBy('id');
        $allFolders = $allFoldersFlat->groupBy('course_id')->map(function ($folders) use ($foldersById) {
            return $folders->map(function ($folder) use ($foldersById) {
                $parts = collect([$folder->name]);
                $node = $folder;
                $guard = 0;
                while ($node->parent_id && $guard < 20) {
                    $node = $foldersById[$node->parent_id] ?? null;
                    if (!$node) {
                        break;
                    }
                    $parts->prepend($node->name);
                    $guard++;
                }

                return [
                    'id' => $folder->id,
                    'name' => $folder->name,
                    'parent_id' => $folder->parent_id,
                    'is_active' => (bool) $folder->is_active,
                    'label' => $parts->implode(' / '),
                ];
            })->values();
        });

        $activeCourse = null;
        $activeFolder = null;
        $folderBreadcrumbs = collect();
        $browserFolders = collect();
        $materials = null;
        $courseLibrary = null;
        $viewMode = 'library'; // library | browser | all_files

        // Resolve active folder / course context
        if ($request->filled('folder_id')) {
            $activeFolder = CourseFolder::with(['course.teacher', 'course.department', 'parent'])->find($request->folder_id);
            if ($activeFolder) {
                $activeCourse = $activeFolder->course;
                $chain = collect();
                $node = $activeFolder;
                $guard = 0;
                while ($node && $guard < 20) {
                    $chain->prepend($node);
                    $node = $node->parent_id ? ($foldersById[$node->parent_id] ?? CourseFolder::find($node->parent_id)) : null;
                    $guard++;
                }
                $folderBreadcrumbs = $chain;
            }
        } elseif ($request->filled('course_id')) {
            $activeCourse = Course::with(['teacher', 'department'])->find($request->course_id);
        }

        if ($request->get('view') === 'all') {
            $viewMode = 'all_files';
            $materials = $this->buildMaterialsQuery($request)->paginate(15)->appends($request->all());
        } elseif ($activeCourse) {
            $viewMode = 'browser';
            $parentScope = $activeFolder ? $activeFolder->id : null;

            $foldersQuery = CourseFolder::where('course_id', $activeCourse->id)
                ->where('parent_id', $parentScope)
                ->with('creator:id,name')
                ->withCount(['materials', 'children']);

            $materialsQuery = CourseMaterial::with(['uploader', 'folder', 'course'])
                ->where('course_id', $activeCourse->id);

            if ($activeFolder) {
                $materialsQuery->where('folder_id', $activeFolder->id);
            } else {
                $materialsQuery->whereNull('folder_id');
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $foldersQuery->where('name', 'like', "%{$search}%");
                $materialsQuery->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('file_type', 'like', "%{$search}%")
                        ->orWhereHas('uploader', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            }

            $browserFolders = $foldersQuery->orderBy('name')->get();
            $materials = $materialsQuery->latest()->paginate(20)->appends($request->all());
        } else {
            // Course library — pick a course to manage files
            $libraryQuery = Course::where('is_active', true)
                ->with(['teacher:id,name', 'department:id,name,code'])
                ->withCount(['materials', 'folders']);

            if ($request->filled('search')) {
                $search = $request->search;
                $libraryQuery->where(function ($q) use ($search) {
                    $q->where('course_code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('subtitle', 'like', "%{$search}%")
                        ->orWhereHas('teacher', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('department', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('code', 'like', "%{$search}%");
                        });
                });
            }

            if ($request->filled('department_id')) {
                $libraryQuery->where('department_id', $request->department_id);
            }

            $courseLibrary = $libraryQuery->orderBy('course_code')->paginate(15)->appends($request->all());
        }

        $departments = \App\Models\Department::orderBy('name')->get(['id', 'name', 'code']);

        // Courses JSON for cascading teacher → course in modals
        $coursesForJs = $courses->map(fn ($c) => [
            'id' => $c->id,
            'course_code' => $c->course_code,
            'title' => $c->title,
            'teacher_id' => $c->teacher_id,
            'label' => $c->course_code . ' — ' . $c->title,
        ]);

        return view('admin.course-files', compact(
            'materials',
            'courses',
            'coursesForJs',
            'totalFiles',
            'weeklyFiles',
            'pdfCount',
            'pdfPercentage',
            'storageUsed',
            'teachers',
            'allFolders',
            'activeFolder',
            'activeCourse',
            'folderBreadcrumbs',
            'browserFolders',
            'courseLibrary',
            'viewMode',
            'departments'
        ));
    }

    protected function buildMaterialsQuery(Request $request)
    {
        $query = CourseMaterial::with(['course', 'uploader', 'folder']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('file_type', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('course_code', 'like', "%{$search}%")
                            ->orWhere('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('uploader', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        return $query->latest();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'folder_id'   => 'nullable|exists:course_folders,id',
            'uploaded_by' => 'nullable|exists:users,id',
            'title'       => 'required|string|max:255',
            'file'        => $this->fileValidationRule(true),
        ]);

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

        $course = Course::find($validated['course_id']);
        $validated['uploaded_by'] = $request->uploaded_by
            ?? $course?->teacher_id
            ?? auth()->id();
        $validated['folder_id'] = $validated['folder_id'] ?? null;

        CourseMaterial::create($validated);

        \App\Models\ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'uploaded_material',
            'description' => 'Uploaded new material <strong>' . e($validated['title']) . '</strong>',
        ]);

        $redirectParams = ['course_id' => $validated['course_id']];
        if (!empty($validated['folder_id'])) {
            $redirectParams = ['folder_id' => $validated['folder_id']];
        }

        return redirect()
            ->route('admin.course-files.index', $redirectParams)
            ->with('success', 'Material uploaded successfully.');
    }

    public function update(Request $request, CourseMaterial $courseMaterial)
    {
        $validated = $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'folder_id'   => 'nullable|exists:course_folders,id',
            'uploaded_by' => 'nullable|exists:users,id',
            'title'       => 'required|string|max:255',
            'file'        => $this->fileValidationRule(false),
        ]);

        if (!empty($validated['folder_id'])) {
            $folder = CourseFolder::findOrFail($validated['folder_id']);
            if ($folder->course_id !== (int) $validated['course_id']) {
                return back()->with('error', 'Invalid folder selected for this course.');
            }
        }

        if ($request->hasFile('file')) {
            $this->assertAllowedExtension($request->file('file'));
            if ($courseMaterial->file_path && Storage::disk('local')->exists($courseMaterial->file_path)) {
                Storage::disk('local')->delete($courseMaterial->file_path);
            }
            $path = $request->file('file')->store('course_materials', 'local');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }

        $validated['folder_id'] = $validated['folder_id'] ?? null;
        $courseMaterial->update($validated);

        \App\Models\ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'updated_material',
            'description' => 'Updated material <strong>' . e($validated['title']) . '</strong>',
        ]);

        return back()->with('success', 'Material updated successfully.');
    }

    public function destroy(CourseMaterial $courseMaterial)
    {
        $title = $courseMaterial->title;
        if ($courseMaterial->file_path && Storage::disk('local')->exists($courseMaterial->file_path)) {
            Storage::disk('local')->delete($courseMaterial->file_path);
        }
        $courseMaterial->delete();

        \App\Models\ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'deleted_material',
            'description' => 'Deleted material <strong>' . e($title) . '</strong>',
        ]);

        return back()->with('success', 'Material deleted successfully.');
    }

    public function download(\App\Models\CourseMaterial $courseMaterial)
    {
        if (!$courseMaterial->file_path || !Storage::disk('local')->exists($courseMaterial->file_path)) {
            abort(404, 'File not found on the server.');
        }

        return response()->download(storage_path('app/' . $courseMaterial->file_path), $courseMaterial->title . '.' . $courseMaterial->file_type, [
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function preview(\App\Models\CourseMaterial $courseMaterial)
    {
        if (!$courseMaterial->file_path || !Storage::disk('local')->exists($courseMaterial->file_path)) {
            abort(404, 'File not found on the server.');
        }

        $ext = strtolower($courseMaterial->file_type ?? pathinfo($courseMaterial->file_path, PATHINFO_EXTENSION));
        if (in_array($ext, self::UNSAFE_PREVIEW_EXTENSIONS, true)) {
            abort(403, 'This file type cannot be previewed inline for security reasons. Please download it instead.');
        }

        return response()->file(storage_path('app/' . $courseMaterial->file_path), [
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function downloadFolder(CourseFolder $folder, \App\Services\CourseFolderZipService $zipService)
    {
        return $zipService->download($folder, false);
    }
}
