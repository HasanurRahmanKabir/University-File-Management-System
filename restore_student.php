<?php

$map = [
    'studentinfo.html' => 'student.blade.php',
];

$sourceDir = 'C:/Users/Hasanur Rahman Kabir/Documents/SUB File Management System/Admin Dashboard/';
$targetDir = 'resources/views/admin/';

foreach ($map as $htmlFile => $bladeFile) {
    $sourcePath = $sourceDir . $htmlFile;
    if (!file_exists($sourcePath)) continue;
    $content = file_get_contents($sourcePath);
    
    $startStr = '<div class="main-content">';
    $startPos = strpos($content, $startStr);
    
    $endStr = '<script>';
    $endPos = strrpos($content, $endStr);
    if ($endPos === false) $endPos = strpos($content, '</body>');
    
    $extracted = substr($content, $startPos, $endPos - $startPos);
    $extracted = preg_replace('/<div class="main-content">/i', '', $extracted, 1);
    
    $modalPos = strpos($extracted, '<div class="modal');
    if ($modalPos !== false) {
        $beforeModal = substr($extracted, 0, $modalPos);
        $afterModal = substr($extracted, $modalPos);
        $lastDivPos = strrpos($beforeModal, '</div>');
        if ($lastDivPos !== false) $beforeModal = substr_replace($beforeModal, '', $lastDivPos, 6);
        $extracted = $beforeModal . $afterModal;
    } else {
        $lastDivPos = strrpos($extracted, '</div>');
        if ($lastDivPos !== false) $extracted = substr_replace($extracted, '', $lastDivPos, 6);
    }
    
    $bladeContent = "@extends('layouts.admin')\n\n@section('content')\n" . $extracted . "\n@endsection\n";
    file_put_contents($targetDir . $bladeFile, $bladeContent);
    echo "Restored $bladeFile\n";
}
