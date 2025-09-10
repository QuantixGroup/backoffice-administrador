<style>
    .sidebar {
        background-color: #1b4965;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
    }

    .sidebar .nav-link {
        color: #ffffff;
        padding: 1rem 1.5rem;
        border-radius: 0;
        margin-bottom: 0.2rem;
        font-weight: 500;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: #3693CB;
        color: #ffffff;
    }

    .sidebar .nav-link i {
        margin-right: 0.75rem;
        width: 20px;
    }

    .navigation-section {
        flex: 1;
        padding-top: 2rem;
    }

    .logo-section {
        padding: 2rem 1rem;
        text-align: center;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: auto;
    }

    .logo-section img {
        width: 100%;
        max-width: 200px;
        height: auto;
        margin-bottom: 1rem;
        border-radius: 50%;
        padding: 20px;
    }

    .logo-text {
        color: #ffffff;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .main-content {
        margin-left: 250px;
        padding: 2rem;
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    .table-container {
        background-color: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-header {
        background-color: #1b4965;
        color: #ffffff;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
    }
</style>

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
            <a class="nav-link" href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt"></i>SALIR
            </a>
        </nav>
    </div>

    <div class="logo-section">
        <img src="{{ asset('img/logo_cooperativa.svg') }}" alt="Logo">
        <div class="logo-text">COVIMT 17</div>
    </div>
</div>