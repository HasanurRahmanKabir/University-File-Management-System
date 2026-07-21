<?php
function inject_js($file, $js) {
    $content = file_get_contents($file);
    if (strpos($content, '<script>') === false) {
        $content = str_replace('@endsection', $js . "\n@endsection", $content);
        file_put_contents($file, $content);
        echo "Injected JS into $file\n";
    }
}

$studentJs = "
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
inject_js('resources/views/admin/student.blade.php', $studentJs);

$teacherJs = "
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
// Remove any push push script from teacher if exists and fix it
$teacherContent = file_get_contents('resources/views/admin/teacher.blade.php');
$teacherContent = preg_replace('/@push\(\'scripts\'\).*?@endpush/s', '', $teacherContent);
file_put_contents('resources/views/admin/teacher.blade.php', $teacherContent);
inject_js('resources/views/admin/teacher.blade.php', $teacherJs);
