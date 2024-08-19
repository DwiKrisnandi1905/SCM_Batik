<div class="d-flex flex-column flex-shrink-0 p-3 bg-light sidebar">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <i class="bi bi-emoji-smile ms-1 mx-2" style="font-size: 30px;"></i>
        <span class="fs-4">SCM Batik</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">

        @if(auth()->user()->hasRole('admin'))
        <li class="mb-2">
            <a href="{{ route('admin.index') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2 mx-2"></i>
                Dashboard
            </a>
        </li>
        @endif
        
        @if(auth()->user()->hasRole('harvester'))
        <li class="mb-2">
            <a href="{{ route('harvest.index') }}" class="nav-link {{ request()->routeIs('harvest.*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2 mx-2"></i>
                Dashboard
            </a>
        </li>
        @endif

        @if(auth()->user()->hasRole('factory'))
        <li class="mb-2">
            <a href="{{ route('factory.index') }}" class="nav-link {{ request()->routeIs('factory.*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2 mx-2"></i>
                Dashboard
            </a>
        </li>
        @endif

        @if(auth()->user()->hasRole('craftsman'))
        <li class="mb-2">
            <a href="{{ route('craftsman.index') }}" class="nav-link {{ request()->routeIs('craftsman.*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2 mx-2"></i>
                Dashboard
            </a>
        </li>
        @endif

        @if(auth()->user()->hasRole('certificator'))
        <li class="mb-2">
            <a href="{{ route('certification.index') }}" class="nav-link {{ request()->routeIs('certification.*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2 mx-2"></i>
                Dashboard
            </a>
        </li>
        @endif

        @if(auth()->user()->hasRole('waste manager'))
        <li class="mb-2">
            <a href="{{ route('waste.index') }}" class="nav-link {{ request()->routeIs('waste.*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2 mx-2"></i>
                Dashboard
            </a>
        </li>
        @endif

        @if(auth()->user()->hasRole('distributor'))
        <li class="mb-2">
            <a href="{{ route('distribution.index') }}" class="nav-link {{ request()->routeIs('distribution.*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2 mx-2"></i>
                Dashboard
            </a>
        </li>
        @endif

        <li class="mb-2">
            <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-speedometer2 mx-2"></i>
                Profile
            </a>
        </li>
    </ul>
    <hr>
</div>