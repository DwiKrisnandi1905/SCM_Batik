// Handle image modal display
var imageModal = document.getElementById('imageModal');
imageModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var imageUrl = button.getAttribute('data-bs-image');
    var modalImage = document.getElementById('modalImage');
    modalImage.src = imageUrl;
});

// Handle delete button with confirmation modal using SweetAlert2
document.querySelectorAll('.delete-button').forEach(function (button) {
    button.addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff8008',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                popup: 'gradient-custom',
                title: 'swal2-title',
                content: 'swal2-content',
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-warning',
                icon: 'swal2-icon swal2-warning'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    });
});

// Automatically fade out and remove alerts after 3 seconds
setTimeout(function () {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
        alert.style.transition = 'opacity 0.5s ease-out';
        alert.style.opacity = '0';
        setTimeout(function () {
            alert.style.display = 'none';
        }, 500);
    });
}, 3000);