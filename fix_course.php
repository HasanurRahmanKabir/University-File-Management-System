<?php
function replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

$file = 'resources/views/admin/course.blade.php';
$content = file_get_contents($file);

// Form fix (Add Course)
$content = replace_first('<form>', '<form action="{{ route(\'admin.courses.store\') }}" method="POST">' . "\n" . '                    @csrf', $content);
$content = replace_first('<input type="text" class="form-control" placeholder="e.g. CSE-201" required>', '<input type="text" name="code" class="form-control" placeholder="e.g. CSE-201" required>', $content);
$content = replace_first('<input type="text" class="form-control" placeholder="e.g. Object Oriented Programming" required>', '<input type="text" name="title" class="form-control" placeholder="e.g. Object Oriented Programming" required>', $content);

// Replace selects correctly
$content = preg_replace('/<select class="form-select" required>.*?<\/select>/s', '<select name="category_id" class="form-select" required>' . "\n" . '                            @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach</select>', $content, 1);

// The Edit form
$content = replace_first('<div class="modal fade" id="editCourseModal" tabindex="-1">', '<div class="modal fade" id="editCourseModal" tabindex="-1">', $content);
$content = replace_first('<form>', '<form action="" method="POST" id="editCourseForm">' . "\n" . '                    @csrf @method("PUT")', $content);
$content = replace_first('<input type="text" class="form-control" value="CSE-201">', '<input type="text" name="code" class="form-control" id="editCourseCode" required>', $content);
$content = replace_first('<input type="text" class="form-control" value="Object Oriented Programming">', '<input type="text" name="title" class="form-control" id="editCourseTitle" required>', $content);
$content = preg_replace('/<select class="form-select">.*?<\/select>/s', '<select name="category_id" class="form-select" id="editCourseCat" required>' . "\n" . '                            @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach</select>', $content, 1);

// Add table loop
$tableStart = strpos($content, '<tbody>');
$tableEnd = strpos($content, '</tbody>', $tableStart) + 8;
$oldTbody = substr($content, $tableStart, $tableEnd - $tableStart);
$newTbody = '<tbody>
    @forelse($courses as $course)
    <tr>
        <td class="px-4 py-3"><div class="fw-bold text-dark">{{ $course->code }}</div></td>
        <td class="px-4 py-3">{{ $course->title }}</td>
        <td class="px-4 py-3"><span class="badge bg-light text-dark border">{{ optional($course->category)->name }}</span></td>
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
    <tr><td colspan="5" class="text-center py-4 text-muted">No courses found.</td></tr>
    @endforelse
</tbody>';
$content = str_replace($oldTbody, $newTbody, $content);
file_put_contents($file, $content);
echo "Course fixed.\n";
