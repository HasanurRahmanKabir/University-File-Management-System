<?php
function replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

$file = 'resources/views/admin/admins.blade.php';
$content = file_get_contents($file);

// Fix Add Form
$content = replace_first('<input type="text" class="form-control" placeholder="Enter admin name" required>', '<input type="text" name="name" class="form-control" placeholder="Enter admin name" required>', $content);
$content = replace_first('<input type="email" class="form-control" placeholder="admin@system.com" required>', '<input type="email" name="email" class="form-control" placeholder="admin@system.com" required>', $content);
$content = replace_first('<input type="password" class="form-control" placeholder="Set a secure password" required>', '<input type="password" name="password" class="form-control" placeholder="Set a secure password" required>', $content);

// Fix Edit Form
$content = replace_first('<form action="" method="POST" id="editAdminForm">', '<form action="" method="POST" id="editAdminForm">' . "\n" . '                    @csrf @method("PUT")' . "\n" . '                    <input type="hidden" name="role" value="admin">', $content);

$content = replace_first('<input type="text" class="form-control" value="Abdullah Al Mamun">', '<input type="text" name="name" class="form-control" id="editAdminName" required>', $content);
$content = replace_first('<input type="email" class="form-control" value="mamun.admin@system.com">', '<input type="email" name="email" class="form-control" id="editAdminEmail" required>', $content);
$content = replace_first('<input type="password" class="form-control" placeholder="Enter new password to change">', '<input type="password" name="password" class="form-control" placeholder="Enter new password to change">', $content);

// Table Loop Fix for Edit Button Data Attributes
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
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill"><i class="fas fa-shield-alt me-1"></i> Admin</span>
        </td>
        <td>
            @if($user->is_active)
                <span class="badge bg-success-subtle text-success border">Active</span>
            @else
                <span class="badge bg-warning-subtle text-warning border">Inactive</span>
            @endif
        </td>
        <td class="text-center">
            <button class="btn btn-sm btn-light border edit-btn" data-bs-toggle="modal" data-bs-target="#editAdminModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}"><i class="fas fa-edit text-primary"></i></button>
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

$js = "
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editAdminForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const email = this.dataset.email;
                
                document.getElementById('editAdminName').value = name;
                document.getElementById('editAdminEmail').value = email;
                
                // Set the action URL correctly
                editForm.action = `/admin/users/\${id}`;
            });
        });
    });
</script>
";

if (strpos($content, '<script>') === false) {
    $content = str_replace('@endsection', $js . "\n@endsection", $content);
}
file_put_contents($file, $content);
echo "admins.blade.php fully fixed.\n";
