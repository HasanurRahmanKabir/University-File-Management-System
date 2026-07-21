<?php
function replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

// RESTORE course-file.blade.php
$sourcePath = 'C:/Users/Hasanur Rahman Kabir/Documents/SUB File Management System/Admin Dashboard/coursefileinfo.html';
$content = file_get_contents($sourcePath);
$startStr = '<div class="main-content">';
$startPos = strpos($content, $startStr);
$endStr = '<script>';
$endPos = strrpos($content, $endStr);
$extracted = substr($content, $startPos, $endPos - $startPos);
$extracted = preg_replace('/<div class="main-content">/i', '', $extracted, 1);
$lastDivPos = strrpos($extracted, '</div>');
if ($lastDivPos !== false) $extracted = substr_replace($extracted, '', $lastDivPos, 6);
$bladeContent = "@extends('layouts.admin')\n\n@section('content')\n" . $extracted . "\n@endsection\n";
file_put_contents('resources/views/admin/course-file.blade.php', $bladeContent);

// FIX course-file.blade.php forms
$file = 'resources/views/admin/course-file.blade.php';
$content = file_get_contents($file);

// Add form
$content = replace_first('<form>', '<form action="{{ route(\'admin.course-materials.store\') }}" method="POST" enctype="multipart/form-data">' . "\n" . '                    @csrf', $content);
// Teacher select (Not needed in backend, controller doesn't need teacher_id for material if it's admin, wait. Controller just takes course_id)
// We will just let them select course.
$content = replace_first('<select class="form-select">', '<select class="form-select">', $content); // Teacher
$content = preg_replace('/<select class="form-select">.*?<\/select>/s', '<select name="course_id" class="form-select" required>' . "\n" . '                            @foreach($courses as $c)<option value="{{ $c->id }}">{{ $c->title }}</option>@endforeach</select>', $content, 1); // Course
$content = replace_first('<input type="text" class="form-control" placeholder="Enter title">', '<input type="text" name="title" class="form-control" placeholder="Enter title" required>', $content);
$content = replace_first('<input type="file" class="form-control">', '<input type="file" name="file_path" class="form-control" required>', $content);

// Edit form
$content = replace_first('<div class="modal fade" id="adminEditFileModal" tabindex="-1">', '<div class="modal fade" id="adminEditFileModal" tabindex="-1">', $content);
$content = replace_first('<form>', '<form action="" method="POST" enctype="multipart/form-data" id="editMaterialForm">' . "\n" . '                    @csrf @method("PUT")', $content);
$content = preg_replace('/<select class="form-select">.*?<\/select>/s', '<select name="course_id" class="form-select" id="editMaterialCourse" required>' . "\n" . '                            @foreach($courses as $c)<option value="{{ $c->id }}">{{ $c->title }}</option>@endforeach</select>', $content, 1); // Course
$content = replace_first('<input type="text" class="form-control" value="Lec-01: Introduction">', '<input type="text" name="title" class="form-control" id="editMaterialTitle" required>', $content);
$content = replace_first('<input type="file" class="form-control">', '<input type="file" name="file_path" class="form-control">', $content);

// Table loop
$tableStart = strpos($content, '<tbody>');
$tableEnd = strpos($content, '</tbody>', $tableStart) + 8;
$oldTbody = substr($content, $tableStart, $tableEnd - $tableStart);
$newTbody = '<tbody>
    @forelse($materials as $material)
    <tr>
        <td class="px-4 py-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-danger-subtle text-danger rounded p-2"><i class="fas fa-file-pdf"></i></div>
                <div>
                    <div class="fw-bold text-dark">{{ $material->title }}</div>
                    <div class="small text-muted">{{ strtoupper($material->file_type) }}</div>
                </div>
            </div>
        </td>
        <td class="px-4 py-3"><span class="badge bg-light text-dark border">{{ optional($material->course)->code }}</span></td>
        <td class="px-4 py-3"><span class="small text-muted">{{ optional($material->course->teacher)->name ?? \'Admin\' }}</span></td>
        <td class="px-4 py-3"><span class="small text-muted">{{ $material->created_at->format(\'M d, Y\') }}</span></td>
        <td class="px-4 py-3 text-center">
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="btn btn-sm btn-light border text-primary"><i class="fas fa-download"></i></a>
                <form action="{{ route(\'admin.course-materials.destroy\', $material) }}" method="POST" class="d-inline">
                    @csrf @method(\'DELETE\')
                    <button type="submit" class="btn btn-sm btn-light border text-danger delete-btn"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @empty
    <tr><td colspan="5" class="text-center py-4 text-muted">No files found.</td></tr>
    @endforelse
</tbody>';
$content = str_replace($oldTbody, $newTbody, $content);
file_put_contents($file, $content);
echo "Materials fixed.\n";
