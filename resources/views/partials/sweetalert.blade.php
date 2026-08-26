<style>
.premium-toast {
    border-radius: 12px !important;
    padding: 12px 16px !important;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
    border: 1px solid #e2e8f0 !important;
    font-family: 'Inter', sans-serif !important;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    display: grid !important;
    grid-template-columns: auto 1fr !important;
    grid-column-gap: 12px !important;
    align-items: center !important;
}
.premium-toast .swal2-icon {
    grid-column: 1 !important;
    grid-row: 1 / span 2 !important;
    margin: 0 !important;
    transform: scale(0.85) !important;
    align-self: center !important;
}
.premium-toast .swal2-title {
    grid-column: 2 !important;
    grid-row: 1 !important;
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    text-align: left !important;
    margin: 0 !important;
    align-self: end !important;
    padding: 0 !important;
}
.premium-toast .swal2-html-container {
    grid-column: 2 !important;
    grid-row: 2 !important;
    font-size: 0.82rem !important;
    margin: 2px 0 0 0 !important;
    text-align: left !important;
    align-self: start !important;
    padding: 0 !important;
    color: #64748b !important;
}
.swal2-timer-progress-bar {
    background: #059669 !important;
}
@media (max-width: 576px) {
    .premium-toast { padding: 12px 16px !important; width: auto !important; max-width: 90vw !important; }
    .premium-toast .swal2-icon { transform: scale(0.8) !important; }
    .premium-toast .swal2-title { font-size: 0.85rem !important; white-space: normal !important; word-wrap: break-word !important; }
}
</style>
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

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: {!! json_encode(session('success')) !!}
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: {!! json_encode(session('error')) !!}
            });
        @endif

        @if(request('error') === 'file_too_large')
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
        @endif

        @if($errors->any() && !isset($hideValidationToast))
            Toast.fire({
                icon: 'error',
                title: "Validation Error",
                text: {!! json_encode($errors->first()) !!}
            });
        @endif

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
