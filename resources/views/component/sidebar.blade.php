<link href="{{ asset('css/styles.css') }}" rel="stylesheet">

<div class="d-flex flex-column flex-shrink-0 p-3 bg-light sidebar">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <i class="bi bi-emoji-smile ms-1 mx-2" style="font-size: 30px;"></i>
        <span class="fs-4">SCM Batik</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="mb-2">
            <a href="{{ route('harvest.index') }}" class="nav-link {{ request()->routeIs('harvest.index') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2 mx-2"></i>
                Dashboard
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.index') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2 mx-2"></i>
                Profile
            </a>
        </li>
    </ul>
    <hr>
</div>
