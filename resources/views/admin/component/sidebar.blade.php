<link href="{{ asset('css/styles.css') }}" rel="stylesheet">

<div class="d-flex flex-column flex-shrink-0 p-3 bg-light sidebar">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <i class="bi bi-emoji-smile ms-1 mx-2" style="font-size: 30px;"></i>
        <span class="fs-4">SCM Batik</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="mb-2">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('monitoring') }}" class="nav-link {{ request()->routeIs('monitoring') ? 'active' : 'link-dark' }}">
                <i class="bi bi-table"></i>
                Monitoring
            </a>
        </li>
    </ul>
    <hr>
</div>
