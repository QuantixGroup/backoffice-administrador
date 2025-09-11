<div class="sidebar">
    <div class="navigation-section">
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('home') || request()->routeIs('socios.detalle') ? 'active' : '' }}"
                href="{{ route('home') }}">
                <i class="fas fa-home"></i>INICIO
            </a>
            <a class="nav-link {{ request()->routeIs('perfil') ? 'active' : '' }}" href="{{ route('perfil') }}">
                <i class="fas fa-user"></i>MI PERFIL
            </a>
            <a class="nav-link {{ request()->routeIs('socios.pendientes') ? 'active' : '' }}"
                href="{{ route('socios.pendientes') }}">
                <i class="fas fa-users"></i>COOPERATIVISTAS
            </a>
            <a class="nav-link {{ request()->routeIs('recibos') ? 'active' : '' }}" href="{{ route('recibos') }}">
                <i class="fas fa-file-invoice"></i>RECIBOS DE PAGO
            </a>
            @if(request()->routeIs('socios.detalle'))
                <a class="nav-link btn-back-sidebar" href="{{ route('home') }}">
                    <i class="fas fa-arrow-left"></i>VOLVER
                </a>
            @else
                <a class="nav-link" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt"></i>SALIR
                </a>
            @endif
        </nav>
    </div>

    <div class="logo-section">
        <img src="{{ asset('img/logo_cooperativa.svg') }}" alt="Logo">
        <div class="logo-sidebar">COVIMT 17</div>
    </div>
</div>