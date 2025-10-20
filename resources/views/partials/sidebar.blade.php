<button id="sidebarHamburger" class="btn-toggle" aria-label="Toggle sidebar" aria-expanded="false"
    data-target="#mainSidebar"><i class="fa-solid fa-bars"></i>
</button>

<div class="sidebar" id="mainSidebar">
    <div class="navigation-section">
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('home') || request()->routeIs('socios.detalle') ? 'active' : '' }}"
                href="{{ route('home') }}">
                <i class="fa-solid fa-house-chimney"></i>INICIO
            </a>
            <a class="nav-link {{ request()->routeIs('perfil') ? 'active' : '' }}" href="{{ route('perfil') }}">
                <i class="fa-solid fa-user"></i>MI PERFIL
            </a>
            <a class="nav-link {{ request()->routeIs('socios.aprobados') ? 'active' : '' }}"
                href="{{ route('socios.aprobados') }}">
                <i class="fa-solid fa-user-group"></i>COOPERATIVISTAS
            </a>
            <a class="nav-link {{ request()->routeIs('recibos.*') ? 'active' : '' }}"
                href="{{ route('recibos.pagos') }}">
                <i class="fa-solid fa-folder-open"></i>RECIBOS DE PAGO
            </a>
            @if(request()->routeIs('socios.detalle') || request()->routeIs('recibos.detalle'))
                <a class="nav-link btn-back-sidebar"
                    href="{{ request()->routeIs('recibos.detalle') ? route('recibos.pagos') : route('home') }}">
                    <i class="fa-solid fa-arrow-left"></i>VOLVER
                </a>
            @else
                <a class="nav-link" href="{{ route('logout') }}">
                    <i class="fa-solid fa-sign-out-alt"></i>SALIR
                </a>
            @endif
        </nav>
    </div>

    <div class="logo-section">
        <img src="{{ asset('img/logo_cooperativa.svg') }}" alt="Logo">
        <div class="logo-sidebar">COVIMT 17</div>
    </div>
</div>
</div>