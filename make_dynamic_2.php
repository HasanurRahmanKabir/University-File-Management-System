<?php
function replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

// 4. teacher.blade.php
$file = 'resources/views/admin/teacher.blade.php';
$content = file_get_contents($file);

$content = replace_first('<form>', '<form action="{{ route(\'admin.users.store\') }}" method="POST">' . "\n" . '                    @csrf' . "\n" . '                    <input type="hidden" name="role" value="teacher">', $content);
$content = replace_first('<input type="text" class="form-control" placeholder="Enter full name" required>', '<input type="text" name="name" class="form-control" placeholder="Enter full name" required>', $content);
$content = replace_first('<input type="email" class="form-control" placeholder="example@univ.edu" required>', '<input type="email" name="email" class="form-control" placeholder="example@univ.edu" required>', $content);
$content = replace_first('<input type="password" class="form-control" placeholder="Create password" required>', '<input type="password" name="password" class="form-control" placeholder="Create password" required>', $content);

$tableStart = strpos($content, '<tbody>');
$tableEnd = strpos($content, '</tbody>', $tableStart) + 8;
$oldTbody = substr($content, $tableStart, $tableEnd - $tableStart);
$newTbody = '<tbody>
    @forelse($users as $user)
    <tr>
        <td><div class="fw-bold">{{ $user->name }}</div><span class="small text-muted">Teacher</span></td>
        <td>{{ $user->email }}</td>
        <td><span class="badge bg-secondary-subtle text-secondary border">N/A</span></td>
        <td>
            @if($user->is_active)
                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle">Active</span>
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
    <tr><td colspan="5" class="text-center">No teachers found</td></tr>
    @endforelse
</tbody>';
$content = str_replace($oldTbody, $newTbody, $content);
file_put_contents($file, $content);

// 5. admins.blade.php
$file = 'resources/views/admin/admins.blade.php';
$content = file_get_contents($file);

$content = replace_first('<form>', '<form action="{{ route(\'admin.users.store\') }}" method="POST">' . "\n" . '                    @csrf' . "\n" . '                    <input type="hidden" name="role" value="admin">', $content);
$content = replace_first('<input type="text" class="form-control" required placeholder="Full Name">', '<input type="text" name="name" class="form-control" required placeholder="Full Name">', $content);
$content = replace_first('<input type="email" class="form-control" required placeholder="admin@example.com">', '<input type="email" name="email" class="form-control" required placeholder="admin@example.com">', $content);
$content = replace_first('<input type="password" class="form-control" required placeholder="Minimum 8 characters">', '<input type="password" name="password" class="form-control" required placeholder="Minimum 8 characters">', $content);

$tableStart = strpos($content, '<tbody>');
$tableEnd = strpos($content, '</tbody>', $tableStart) + 8;
$oldTbody = substr($content, $tableStart, $tableEnd - $tableStart);
$newTbody = '<tbody>
    @forelse($users as $user)
    <tr>
        <td>
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">{{ substr($user->name, 0, 1) }}</div>
                <div>
                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                    <div class="small text-muted">{{ $user->email }}</div>
                </div>
            </div>
        </td>
        <td>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill"><i class="fas fa-shield-alt me-1"></i> Super Admin</span>
        </td>
        <td>
            @if($user->is_active)
                <span class="badge bg-success-subtle text-success border">Active</span>
            @else
                <span class="badge bg-warning-subtle text-warning border">Inactive</span>
            @endif
        </td>
        <td class="text-center">
            <form action="{{ route(\'admin.users.destroy\', $user) }}" method="POST" class="d-inline">
                @csrf @method(\'DELETE\')
                <button type="submit" class="btn btn-sm btn-light border delete-btn"><i class="fas fa-trash text-danger"></i></button>
            </form>
        </td>
    </tr>
    @empty
    <tr><td colspan="4" class="text-center">No admins found</td></tr>
    @endforelse
</tbody>';
$content = str_replace($oldTbody, $newTbody, $content);
file_put_contents($file, $content);

echo "Done teacher and admins.\n";
