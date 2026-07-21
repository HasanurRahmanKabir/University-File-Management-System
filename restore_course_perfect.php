<?php

$sourcePath = 'C:/Users/Hasanur Rahman Kabir/Documents/SUB File Management System/Admin Dashboard/courseinfo.html';
$content = file_get_contents($sourcePath);

// Extract from <div class="container-fluid"> up to just before <script>
$startStr = '<div class="container-fluid">';
$startPos = strpos($content, $startStr);

$endStr = '<script>';
$endPos = strpos($content, $endStr);

$extracted = substr($content, $startPos, $endPos - $startPos);

// The extracted string now ends with </div></div> </div> and then modals.
// But wait, the original HTML has:
// </div> (closes table-container)
// </div> (closes container-fluid)
// </div> (closes main-content)
// <div class="modal fade" ...>

// Let's remove the closing </div> of main-content.
// It is the last </div> before the first <div class="modal
$modalPos = strpos($extracted, '<div class="modal');
$beforeModal = substr($extracted, 0, $modalPos);
$afterModal = substr($extracted, $modalPos);

// Find the last </div> in beforeModal
$lastDivPos = strrpos($beforeModal, '</div>');
$beforeModal = substr_replace($beforeModal, '', $lastDivPos, 6);

$bladeContent = "@extends('layouts.admin')\n\n@section('content')\n\n" . $beforeModal . $afterModal . "\n@endsection\n";
file_put_contents('resources/views/admin/course.blade.php', $bladeContent);

echo "course.blade.php restored cleanly.\n";
