<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: 'var(--bg-card, #ffffff)',
            color: 'var(--text-heading, #1f2937)',
            customClass: { popup: 'premium-toast' }
        });

        <?php if(session('success')): ?>
            Toast.fire({
                icon: 'success',
                title: <?php echo json_encode(session('success')); ?>

            });
        <?php endif; ?>

        <?php if(session('error')): ?>
            Toast.fire({
                icon: 'error',
                title: <?php echo json_encode(session('error')); ?>

            });
        <?php endif; ?>

        <?php if(request('error') === 'file_too_large'): ?>
            Toast.fire({
                icon: 'error',
                title: "File Too Large",
                text: "File exceeds max allowed size."
            });
            
            // Clean up the URL so it doesn't show again on refresh
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('error');
                window.history.replaceState({path: url.href}, '', url.href);
            }
        <?php endif; ?>

        <?php if($errors->any() && !isset($hideValidationToast)): ?>
            Toast.fire({
                icon: 'error',
                title: "Validation Error",
                text: <?php echo json_encode($errors->first()); ?>

            });
        <?php endif; ?>

        // Global Delete Confirmation
        document.body.addEventListener('click', function(e) {
            let deleteBtn = e.target.closest('.delete-btn');
            if (deleteBtn) {
                e.preventDefault();
                let form = deleteBtn.closest('form');
                if(!form) return;
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });
</script>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\partials\sweetalert.blade.php ENDPATH**/ ?>