<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="{{ $globalSettings['seo_meta_description'] ?? 'Teacher Dashboard — University OBE File Management System' }}">
    <title>@yield('page-title', 'Teacher') — {{ $globalSettings['teacher_tab_title'] ?? 'Teacher Dashboard - OBE System' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    @stack('styles')
</head>
<body>

<button class="sb-toggler" id="toggleBtn" aria-label="Toggle sidebar"><i class="fas fa-bars"></i></button>

<div class="sb-overlay" id="overlay"></div>

<!-- SIDEBAR -->
@include('layouts.partials.teacher-sidebar')

<!-- MAIN -->
<div class="main">
    
    <!-- TOPBAR -->
    @include('layouts.partials.teacher-topbar')

    <!-- PAGE CONTENT -->
    <main class="page-content">
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('layouts.partials.teacher-footer')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if(toggleBtn && sidebar && overlay) {
            toggleBtn.onclick = () => {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            overlay.onclick = () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        }
    });
</script>
@include('partials.sweetalert')
@stack('scripts')
@stack('modals')

</body>
</html>
