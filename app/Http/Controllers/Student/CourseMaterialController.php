<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseFolder;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    private const UNSAFE_PREVIEW_EXTENSIONS = ['svg', 'html', 'htm', 'xml', 'js'];

    public function index(Request $request)
    {
        $user = Auth::user();
        $enrolledIds = $user->enrolledCourses()
            ->wherePivot('status', 'active')
            ->pluck('courses.id');

        $courses = Course::whereIn('id', $enrolledIds)
            ->where('is_active', true)
            ->withCount([
                'materials as public_files_count' => fn ($q) => $q->where('is_active', true),
                'folders as folders_count' => fn ($q) => $q->where('is_active', true),
            ])
            ->with('teacher:id,name')
            ->orderBy('course_code')
            ->get();

        // Refine file counts: exclude files inside private folder trees
        $courses->each(function ($course) {
            $visibleFolderIds = CourseFolder::studentVisibleIdsForCourse($course->id);
            $course->public_files_count = CourseMaterial::where('course_id', $course->id)
                ->where('is_active', true)
                ->where(function ($q) use ($visibleFolderIds) {
                    $q->whereNull('folder_id');
                    if ($visibleFolderIds->isNotEmpty()) {
                        $q->orWhereIn('folder_id', $visibleFolderIds);
                    }
                })
                ->count();
            $course->folders_count = $visibleFolderIds->count();
        });

        $courseIds = $courses->pluck('id');
        $totalFiles = $courses->sum('public_files_count');
        $folderCount = $courses->sum('folders_count');

        $activeCourse = null;
        $activeFolder = null;
        $folderBreadcrumbs = collect();
        $browserFolders = collect();
        $materials = null;
        $courseLibrary = null;
        $viewMode = 'library';

        $foldersById = CourseFolder::whereIn('course_id', $courseIds)
            ->orderBy('name')
            ->get()
            ->keyBy('id');

        if ($request->filled('folder_id')) {
            $activeFolder = CourseFolder::with(['course', 'parent'])->find($request->folder_id);
            if (
                $activeFolder
                && $courseIds->contains($activeFolder->course_id)
                && $activeFolder->isVisibleToStudents()
            ) {
                $activeCourse = $courses->firstWhere('id', $activeFolder->course_id)
                    ?? Course::find($activeFolder->course_id);

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
                if ($activeFolder && $courseIds->contains($activeFolder->course_id) && !$activeFolder->isVisibleToStudents()) {
                    abort(403, 'This folder is private and not available to students.');
                }
                $activeFolder = null;
            }
        } elseif ($request->filled('course_id')) {
            if ($courseIds->contains((int) $request->course_id)) {
                $activeCourse = $courses->firstWhere('id', (int) $request->course_id);
            }
        }

        if ($activeCourse) {
            $viewMode = 'browser';
            $parentScope = $activeFolder ? $activeFolder->id : null;
            $visibleFolderIds = CourseFolder::studentVisibleIdsForCourse($activeCourse->id);

            $foldersQuery = CourseFolder::where('course_id', $activeCourse->id)
                ->where('parent_id', $parentScope)
                ->where('is_active', true)
                ->whereIn('id', $visibleFolderIds->isEmpty() ? [-1] : $visibleFolderIds)
                ->withCount([
                    'materials as public_files_count' => function ($q) {
                        $q->where('is_active', true);
                    },
                    'children as children_count' => fn ($q) => $q->where('is_active', true),
                ]);

            $materialsQuery = CourseMaterial::with(['course', 'folder'])
                ->where('course_id', $activeCourse->id)
                ->where('is_active', true);

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
                        ->orWhere('file_type', 'like', "%{$search}%");
                });
            }

            $browserFolders = $foldersQuery->orderBy('name')->get();

            $materials = $materialsQuery->latest()->paginate(20)->appends($request->all());
        } else {
            $libraryQuery = Course::whereIn('id', $enrolledIds)
                ->where('is_active', true)
                ->with('teacher:id,name');

            if ($request->filled('search')) {
                $search = $request->search;
                $libraryQuery->where(function ($q) use ($search) {
                    $q->where('course_code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('subtitle', 'like', "%{$search}%");
                });
            }

            // 3-column card grid → 9/page = 3 full rows (matches teacher/admin 3-row library pattern)
            $courseLibrary = $libraryQuery->orderBy('course_code')->paginate(9)->appends($request->all());

            // Attach refined counts for paginated library cards
            $courseLibrary->getCollection()->transform(function ($course) use ($courses) {
                $fromList = $courses->firstWhere('id', $course->id);
                if ($fromList) {
                    $course->public_files_count = $fromList->public_files_count;
                    $course->folders_count = $fromList->folders_count;
                } else {
                    $visibleFolderIds = CourseFolder::studentVisibleIdsForCourse($course->id);
                    $course->folders_count = $visibleFolderIds->count();
                    $course->public_files_count = CourseMaterial::where('course_id', $course->id)
                        ->where('is_active', true)
                        ->where(function ($q) use ($visibleFolderIds) {
                            $q->whereNull('folder_id');
                            if ($visibleFolderIds->isNotEmpty()) {
                                $q->orWhereIn('folder_id', $visibleFolderIds);
                            }
                        })
                        ->count();
                }
                return $course;
            });
        }

        return view('student.course-materials.index', compact(
            'courses',
            'courseLibrary',
            'viewMode',
            'activeCourse',
            'activeFolder',
            'folderBreadcrumbs',
            'browserFolders',
            'materials',
            'totalFiles',
            'folderCount'
        ));
    }

    public function download(CourseMaterial $material)
    {
        $user = Auth::user();
        $enrolledIds = $user->enrolledCourses()
            ->wherePivot('status', 'active')
            ->pluck('courses.id')
            ->toArray();

        if (!in_array($material->course_id, $enrolledIds)) {
            abort(403, 'Unauthorized access. You are not enrolled in this course.');
        }

        if (!$material->is_active) {
            abort(403, 'This material is private and not available for download.');
        }

        if ($material->folder_id) {
            $folder = CourseFolder::find($material->folder_id);
            if (!$folder || !$folder->isVisibleToStudents()) {
                abort(403, 'This material is inside a private folder and not available to students.');
            }
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

    public function preview(CourseMaterial $material)
    {
        $user = Auth::user();
        $enrolledIds = $user->enrolledCourses()
            ->wherePivot('status', 'active')
            ->pluck('courses.id')
            ->toArray();

        if (!in_array($material->course_id, $enrolledIds)) {
            abort(403, 'Unauthorized access. You are not enrolled in this course.');
        }

        if (!$material->is_active) {
            abort(403, 'This material is private and not available for preview.');
        }

        if ($material->folder_id) {
            $folder = CourseFolder::find($material->folder_id);
            if (!$folder || !$folder->isVisibleToStudents()) {
                abort(403, 'This material is inside a private folder and not available to students.');
            }
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

    public function downloadFolder(CourseFolder $folder, \App\Services\CourseFolderZipService $zipService)
    {
        $user = Auth::user();
        $enrolledIds = $user->enrolledCourses()
            ->wherePivot('status', 'active')
            ->pluck('courses.id')
            ->toArray();

        if (!in_array($folder->course_id, $enrolledIds)) {
            abort(403, 'Unauthorized access. You are not enrolled in this course.');
        }

        return $zipService->download($folder, true);
    }
}
