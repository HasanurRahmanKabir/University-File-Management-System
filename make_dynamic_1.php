<?php
function replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

// 1. student.blade.php
$file = 'resources/views/admin/student.blade.php';
$content = file_get_contents($file);

// Form fix (Add Student)
$content = replace_first('<form>', '<form action="{{ route(\'admin.users.store\') }}" method="POST">' . "\n" . '                    @csrf' . "\n" . '                    <input type="hidden" name="role" value="student">', $content);
$content = replace_first('<input type="text" class="form-control" required>', '<input type="text" name="name" class="form-control" required>', $content);
// The original has a Student ID, we can repurpose it to email
$content = replace_first('<label class="form-label fw-semibold">Student ID</label>'."\n".'                                <input type="text" class="form-control" required>', '<label class="form-label fw-semibold">Email Address</label>'."\n".'                                <input type="email" name="email" class="form-control" required>', $content);
$content = replace_first('<input type="password" class="form-control" required>', '<input type="password" name="password" class="form-control" required>', $content);

// Table fix (Add Foreach but keep design)
$tableStart = strpos($content, '<tbody>');
$tableEnd = strpos($content, '</tbody>', $tableStart) + 8;
$oldTbody = substr($content, $tableStart, $tableEnd - $tableStart);

$newTbody = '<tbody>
    @forelse($users as $user)
    <tr>
        <td><div class="fw-bold">{{ $user->name }}</div><span class="small text-muted text-truncate">{{ $user->email }}</span></td>
        <td><span class="badge bg-dark">ID-{{ str_pad($user->id, 4, \'0\', STR_PAD_LEFT) }}</span></td>
        <td>L-4, T-1</td>
        <td>
            @if($user->is_active)
                <span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle">Active</span>
            @else
                <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle">Inactive</span>
            @endif
        </td>
        <td>
            <form action="{{ route(\'admin.users.destroy\', $user) }}" method="POST" class="d-inline">
                @csrf @method(\'DELETE\')
                <button type="submit" class="btn btn-sm btn-light border delete-btn"><i class="fas fa-trash text-danger"></i></button>
            </form>
        </td>
    </tr>
    @empty
    <tr><td colspan="5" class="text-center">No students found</td></tr>
    @endforelse
</tbody>';
$content = str_replace($oldTbody, $newTbody, $content);
file_put_contents($file, $content);


// 2. category.blade.php
$file = 'resources/views/admin/category.blade.php';
$content = file_get_contents($file);
$content = replace_first('<form>', '<form action="{{ route(\'admin.categories.store\') }}" method="POST">' . "\n" . '                    @csrf', $content);
$content = replace_first('<input type="text" class="form-control" placeholder="e.g. Computer Science" required>', '<input type="text" name="name" class="form-control" placeholder="e.g. Computer Science" required>', $content);
$content = replace_first('<textarea class="form-control" rows="3" placeholder="Brief description..."></textarea>', '<textarea name="description" class="form-control" rows="3" placeholder="Brief description..."></textarea>', $content);
$content = replace_first('<select class="form-select">', '<select name="is_active" class="form-select">', $content);

$tableStart = strpos($content, '<tbody>');
$tableEnd = strpos($content, '</tbody>', $tableStart) + 8;
$oldTbody = substr($content, $tableStart, $tableEnd - $tableStart);
$newTbody = '<tbody>
    @forelse($categories as $category)
    <tr>
        <td class="px-4 py-3"><div class="fw-bold text-dark">{{ $category->name }}</div></td>
        <td class="px-4 py-3"><span class="text-muted small">{{ Str::limit($category->description, 50) }}</span></td>
        <td class="px-4 py-3">
            @if($category->is_active)
                <span class="badge bg-success-subtle text-success border">Active</span>
            @else
                <span class="badge bg-warning-subtle text-warning border">Inactive</span>
            @endif
        </td>
        <td class="px-4 py-3 text-center">
            <form action="{{ route(\'admin.categories.destroy\', $category) }}" method="POST" class="d-inline">
                @csrf @method(\'DELETE\')
                <button type="submit" class="btn btn-sm btn-light border delete-btn"><i class="fas fa-trash text-danger"></i></button>
            </form>
        </td>
    </tr>
    @empty
    <tr><td colspan="4" class="text-center py-4 text-muted">No categories found.</td></tr>
    @endforelse
</tbody>';
$content = str_replace($oldTbody, $newTbody, $content);
file_put_contents($file, $content);


// 3. subcategory.blade.php
$file = 'resources/views/admin/subcategory.blade.php';
$content = file_get_contents($file);
$content = replace_first('<form>', '<form action="{{ route(\'admin.subcategories.store\') }}" method="POST">' . "\n" . '                    @csrf', $content);
$content = replace_first('<select class="form-select" required>', '<select name="category_id" class="form-select" required>' . "\n" . '                            @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach', $content);
$content = replace_first('<input type="text" class="form-control" required placeholder="e.g. Operating System">', '<input type="text" name="name" class="form-control" required placeholder="e.g. Operating System">', $content);
$content = replace_first('<select class="form-select">', '<select name="is_active" class="form-select">', $content);

$tableStart = strpos($content, '<tbody>');
$tableEnd = strpos($content, '</tbody>', $tableStart) + 8;
$oldTbody = substr($content, $tableStart, $tableEnd - $tableStart);
$newTbody = '<tbody>
    @forelse($subcategories as $subcategory)
    <tr>
        <td class="px-4 py-3"><div class="fw-bold text-dark">{{ $subcategory->name }}</div></td>
        <td class="px-4 py-3"><span class="badge bg-light text-dark border">{{ optional($subcategory->category)->name }}</span></td>
        <td class="px-4 py-3">
            @if($subcategory->is_active)
                <span class="badge bg-success-subtle text-success border">Active</span>
            @else
                <span class="badge bg-warning-subtle text-warning border">Inactive</span>
            @endif
        </td>
        <td class="px-4 py-3 text-center">
            <form action="{{ route(\'admin.subcategories.destroy\', $subcategory) }}" method="POST" class="d-inline">
                @csrf @method(\'DELETE\')
                <button type="submit" class="btn btn-sm btn-light border delete-btn"><i class="fas fa-trash text-danger"></i></button>
            </form>
        </td>
    </tr>
    @empty
    <tr><td colspan="4" class="text-center py-4 text-muted">No subcategories found.</td></tr>
    @endforelse
</tbody>';
$content = str_replace($oldTbody, $newTbody, $content);
file_put_contents($file, $content);

echo "Done student, category, subcategory.\n";
