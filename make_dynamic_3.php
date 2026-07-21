<?php
function replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

// 6. course.blade.php
$file = 'resources/views/admin/course.blade.php';
$content = file_get_contents($file);

$content = replace_first('<form>', '<form action="{{ route(\'admin.courses.store\') }}" method="POST">' . "\n" . '                    @csrf', $content);
$content = replace_first('<input type="text" class="form-control" required placeholder="e.g. CSE-101">', '<input type="text" name="course_code" class="form-control" required placeholder="e.g. CSE-101">', $content);
$content = replace_first('<input type="text" class="form-control" required placeholder="Course Title">', '<input type="text" name="title" class="form-control" required placeholder="Course Title">', $content);
$content = replace_first('<select class="form-select" required>', '<select name="category_id" class="form-select" required>' . "\n" . '                            @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach', $content);
// subcategory and teacher dropdowns exist in original HTML, but they were hardcoded. I will replace the next two selects.
$content = replace_first('<select class="form-select">', '<select name="subcategory_id" class="form-select">' . "\n" . '                            @foreach($subcategories as $sub)<option value="{{ $sub->id }}">{{ $sub->name }}</option>@endforeach', $content);
$content = replace_first('<select class="form-select" required>', '<select name="teacher_id" class="form-select" required>' . "\n" . '                            @foreach($teachers as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach', $content);

$tableStart = strpos($content, '<tbody>');
$tableEnd = strpos($content, '</tbody>', $tableStart) + 8;
$oldTbody = substr($content, $tableStart, $tableEnd - $tableStart);
$newTbody = '<tbody>
    @forelse($courses as $course)
    <tr>
        <td class="px-4 py-3"><div class="fw-bold text-dark">{{ $course->course_code }}</div></td>
        <td class="px-4 py-3">{{ $course->title }}</td>
        <td class="px-4 py-3"><span class="badge bg-light text-dark border">{{ optional($course->category)->name }}</span></td>
        <td class="px-4 py-3"><span class="badge bg-secondary-subtle text-secondary border">{{ optional($course->teacher)->name ?? \'N/A\' }}</span></td>
        <td class="px-4 py-3">
            @if($course->is_active)
                <span class="badge bg-success-subtle text-success border">Active</span>
            @else
                <span class="badge bg-warning-subtle text-warning border">Inactive</span>
            @endif
        </td>
        <td class="px-4 py-3 text-center">
            <form action="{{ route(\'admin.courses.destroy\', $course) }}" method="POST" class="d-inline">
                @csrf @method(\'DELETE\')
                <button type="submit" class="btn btn-sm btn-light border delete-btn"><i class="fas fa-trash text-danger"></i></button>
            </form>
        </td>
    </tr>
    @empty
    <tr><td colspan="6" class="text-center py-4 text-muted">No courses found.</td></tr>
    @endforelse
</tbody>';
$content = str_replace($oldTbody, $newTbody, $content);
file_put_contents($file, $content);


// 7. course-file.blade.php
$file = 'resources/views/admin/course-file.blade.php';
$content = file_get_contents($file);

$content = replace_first('<form>', '<form action="{{ route(\'admin.course-materials.store\') }}" method="POST" enctype="multipart/form-data">' . "\n" . '                    @csrf', $content);
$content = replace_first('<input type="text" class="form-control" placeholder="e.g. Lecture 1" required>', '<input type="text" name="title" class="form-control" placeholder="e.g. Lecture 1" required>', $content);
$content = replace_first('<select class="form-select" required>', '<select name="course_id" class="form-select" required>' . "\n" . '                            @foreach($courses as $c)<option value="{{ $c->id }}">{{ $c->title }}</option>@endforeach', $content);
$content = replace_first('<input class="form-control" type="file" required>', '<input name="file" class="form-control" type="file" required>', $content);

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
                    <div class="small text-muted">{{ strtoupper($material->file_type) }} • 1.2 MB</div>
                </div>
            </div>
        </td>
        <td class="px-4 py-3"><span class="badge bg-light text-dark border">{{ optional($material->course)->course_code }}</span></td>
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

echo "Done courses and files.\n";
