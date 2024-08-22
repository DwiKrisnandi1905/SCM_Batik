<style>
    .gradient-custom {
        background: #ffcc00;
        background: -webkit-linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
        background: linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
    }
    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .navbar-nav .nav-link {
        font-size: 1.1rem;
        margin-right: 1rem;
    }
    .navbar-nav .nav-item .dropdown-menu {
        border-radius: 0.5rem;
    }
    .navbar-toggler {
        border: none;
    }
    .navbar-toggler-icon {
        background-image: url('data:image/svg+xml,%3Csvg xmlns%3D"http%3A//www.w3.org/2000/svg" viewBox%3D"0 0 30 30"%3E%3Cpath stroke%3D"rgba%28255, 255, 255, 0.55%29" stroke-width%3D"2" stroke-linecap%3D"round" stroke-miterlimit%3D"10" d%3D"M4 7h22M4 15h22M4 23h22"/%3E%3C/svg%3E');
    }

    .dropdown-item:hover {
        background: #ffb347;
    }

    .swal2-popup .swal2-title,
    .swal2-popup .swal2-content,
    .swal2-popup .swal2-icon .swal2-icon-content {
        color: white;
    }
    .swal2-popup .swal2-icon.swal2-warning {
        border-color: white;
    }
    .swal2-popup .swal2-icon.swal2-warning .swal2-icon-content {
        color: white;
    }
    .swal2-popup .swal2-actions button {
        margin: 0 5px;
    }
    .btn-danger {
        background-color: #ff8008;
        color: white;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark gradient-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">{{ $name }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ auth()->user()->image ? asset('storage/images/' . auth()->user()->image) : asset('img/pasfoto.jpg') }}" alt="" width="35" height="35" class="rounded-circle me-2">
                        <strong>{{ auth()->user()->name }}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="submit" class="dropdown-item" id="signout-btn">Sign out</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    document.getElementById('signout-btn').addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff8008',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, sign out!',
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
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>