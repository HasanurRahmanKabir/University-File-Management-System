<?php
function replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

$file = 'resources/views/admin/teacher.blade.php';
$content = file_get_contents($file);

// Fix Add Form - currently it has id="editTeacherForm" which is wrong and duplicated
$content = replace_first('<div class="modal fade" id="addTeacherModal" tabindex="-1">', '<div class="modal fade" id="addTeacherModal" tabindex="-1">', $content);
$content = replace_first('<form action="" method="POST" id="editTeacherForm">', '<form action="{{ route(\'admin.users.store\') }}" method="POST">', $content);

// Table Loop Fix for Edit Button Data Attributes
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
            <button class="btn btn-sm btn-light border edit-btn" data-bs-toggle="modal" data-bs-target="#editTeacherModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}"><i class="fas fa-edit text-primary"></i></button>
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

// JS for Edit Modal
$js = "
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editTeacherForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const email = this.dataset.email;
                
                document.getElementById('editTeacherName').value = name;
                document.getElementById('editTeacherEmail').value = email;
                
                // Set the action URL correctly
                editForm.action = `/admin/users/\${id}`;
            });
        });
    });
</script>
";

if (strpos($content, 'editTeacherForm') !== false && strpos($content, '<script>') === false) {
    $content = str_replace('</body>', $js . '</body>', $content);
} elseif (strpos($content, '<script>') === false) {
    // just append if body is not there (but it should be since layout is not here, wait layout is extended)
    $content .= "\n" . '@push(\'scripts\')' . "\n" . $js . "\n" . '@endpush' . "\n";
}

file_put_contents($file, $content);
echo "teacher.blade.php fully fixed.\n";
