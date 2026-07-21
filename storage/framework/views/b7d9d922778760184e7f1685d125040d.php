<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if(session('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "<?php echo e(session('success')); ?>",
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        <?php endif; ?>

        <?php if(session('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "<?php echo e(session('error')); ?>",
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        <?php endif; ?>

        <?php if($errors->any()): ?>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error!',
                html: `
                    <ul class="text-start mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                `,
                showConfirmButton: true
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
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/partials/sweetalert.blade.php ENDPATH**/ ?>