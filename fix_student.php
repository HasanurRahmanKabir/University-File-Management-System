<?php
function replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

$file = 'resources/views/admin/student.blade.php';
$content = file_get_contents($file);

// Fix Add Form
$content = replace_first('<form>', '<form action="{{ route(\'admin.users.store\') }}" method="POST">' . "\n" . '                    @csrf' . "\n" . '                    <input type="hidden" name="role" value="student">', $content);
$content = replace_first('<input type="text" class="form-control" required>', '<input type="email" name="email" class="form-control" placeholder="Enter Email" required>', $content); // Replace Student ID with Email
$content = replace_first('<label class="form-label fw-semibold">Student ID</label>', '<label class="form-label fw-semibold">Email Address</label>', $content); // Replace label
$content = replace_first('<input type="password" class="form-control" required>', '<input type="password" name="password" class="form-control" required>', $content);
$content = replace_first('<input type="text" class="form-control" placeholder="e.g. John Doe" required>', '<input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required>', $content);

// Fix Edit Form
$content = replace_first('<div class="modal fade" id="editStudentModal" tabindex="-1">', '<div class="modal fade" id="editStudentModal" tabindex="-1">', $content);
$content = replace_first('<form>', '<form action="" method="POST" id="editStudentForm">' . "\n" . '                    @csrf @method("PUT")' . "\n" . '                    <input type="hidden" name="role" value="student">', $content);
$content = replace_first('<input type="text" class="form-control" value="Rahat Karim">', '<input type="text" name="name" class="form-control" id="editStudentName" required>', $content);
$content = replace_first('<input type="text" class="form-control" value="UG02-45-19-021" readonly>', '<input type="email" name="email" class="form-control" id="editStudentEmail" required>', $content);
$content = replace_first('<label class="form-label fw-semibold">Student ID</label>', '<label class="form-label fw-semibold">Email Address</label>', $content);
$content = replace_first('<input type="password" class="form-control" placeholder="Change password (Optional)">', '<input type="password" name="password" class="form-control" placeholder="Change password (Optional)">', $content);

// Table Loop
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
        <td class="text-center">
            <button class="btn btn-sm btn-light border edit-btn" data-bs-toggle="modal" data-bs-target="#editStudentModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}"><i class="fas fa-edit text-primary"></i></button>
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

// JS for Edit Modal
$js = "
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editStudentForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const email = this.dataset.email;
                
                document.getElementById('editStudentName').value = name;
                document.getElementById('editStudentEmail').value = email;
                
                // Set the action URL correctly
                editForm.action = `/admin/users/\${id}`;
            });
        });
    });
</script>
";

$content = str_replace('</body>', $js . '</body>', $content);

file_put_contents($file, $content);
echo "student.blade.php fully fixed.\n";
