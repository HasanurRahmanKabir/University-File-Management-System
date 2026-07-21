<?php

$files = [
    'resources/views/admin/student.blade.php' => 'admin.student-info',
    'resources/views/admin/teacher.blade.php' => 'admin.teacher-info',
    'resources/views/admin/admins.blade.php' => 'admin.admins'
];

foreach ($files as $file => $routeNamePrefix) {
    $content = file_get_contents($file);
    $content = str_replace("route('admin.users.store')", "route('$routeNamePrefix.store')", $content);
    $content = str_replace("route('admin.users.destroy', \$user)", "route('$routeNamePrefix.destroy', \$user)", $content);
    $content = preg_replace("/editForm.action = `\/admin\/users\/\\\$\{id\}`;/", "editForm.action = `/" . str_replace('.', '/', $routeNamePrefix) . "/\${id}`;", $content);
    file_put_contents($file, $content);
}
echo "Forms updated successfully.\n";
