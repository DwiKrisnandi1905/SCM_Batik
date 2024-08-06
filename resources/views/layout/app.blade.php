<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .content {
            flex: 1 0 auto;
            display: flex;
            margin-top: 56px;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-x: hidden;
            margin-left: 250px;
        }
        .table-wrapper {
            overflow-x: auto;
        }
        table {
            min-width: 800px;
        }
        .img-link {
            position: relative;
            display: inline-block;
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s, transform 0.3s;
            cursor: pointer;
        }
        .img-link::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #007bff;
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }
        .img-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
        .img-link:hover {
            color: #0056b3; 
            transform: scale(1.1);
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }
        .sidebar {
            position: fixed;
            top: 56px; 
            bottom: 0;
            width: 250px;
            overflow-y: auto;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
        .nav-link.dropdown-toggle {
            transition: color 0.3s ease;
        }
        .nav-link.dropdown-toggle:hover {
            color: #ffd700; /* gold color */
        }
        .dropdown-menu {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Harvests</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://via.placeholder.com/40" alt="" width="32" height="32" class="rounded-circle me-2">
                            <strong>Username</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <button class="btn sidebar-toggler" type="button">
        <i class="bi bi-list"></i>
    </button>
    <div class="content">
        @include('component.sidebar')
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.querySelector('.sidebar-toggler').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
