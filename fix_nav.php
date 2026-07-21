<?php

$views = [
    'resources/views/admin/student.blade.php',
    'resources/views/admin/teacher.blade.php',
    'resources/views/admin/admins.blade.php',
    'resources/views/admin/course.blade.php',
    'resources/views/admin/course-file.blade.php',
    'resources/views/admin/category.blade.php',
    'resources/views/admin/subcategory.blade.php'
];

$navReplacements = [
    'href="studentinfo.html"' => 'href="{{ route(\'admin.users.index\', [\'role\'=>\'student\']) }}"',
    'href="teacherinfo.html"' => 'href="{{ route(\'admin.users.index\', [\'role\'=>\'teacher\']) }}"',
    'href="admins.html"' => 'href="{{ route(\'admin.users.index\', [\'role\'=>\'admin\']) }}"',
    'href="courseinfo.html"' => 'href="{{ route(\'admin.courses.index\') }}"',
    'href="coursefileinfo.html"' => 'href="{{ route(\'admin.course-materials.index\') }}"',
    'href="categorylist.html"' => 'href="{{ route(\'admin.categories.index\') }}"',
    'href="subcategorylist.html"' => 'href="{{ route(\'admin.subcategories.index\') }}"',
    'href="#" class="logout-link"' => 'href="{{ route(\'logout\') }}" onclick="event.preventDefault(); document.getElementById(\'logout-form\').submit();" class="logout-link"',
];

// Ensure logout form is in the sidebar
$logoutForm = '<form id="logout-form" action="{{ route(\'logout\') }}" method="POST" class="d-none">@csrf</form>';

foreach ($views as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Replace Nav
    foreach ($navReplacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    // Add logout form if not exists
    if (strpos($content, 'logout-form') === false) {
        $content = str_replace('</div>
    </div>

    <div class="main-content">', $logoutForm . '</div>
    </div>

    <div class="main-content">', $content);
    }

    file_put_contents($file, $content);
}
echo "Sidebar nav updated.\n";
