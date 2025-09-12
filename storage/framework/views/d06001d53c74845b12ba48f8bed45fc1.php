<div class="sidebar">
    <div class="navigation-section">
        <nav class="nav flex-column">
            <a class="nav-link <?php echo e(request()->routeIs('home') || request()->routeIs('socios.detalle') ? 'active' : ''); ?>"
                href="<?php echo e(route('home')); ?>">
                <i class="fa-solid fa-house-chimney"></i>INICIO
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('perfil') ? 'active' : ''); ?>" href="<?php echo e(route('perfil')); ?>">
                <i class="fa-solid fa-user"></i>MI PERFIL
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('socios.pendientes') ? 'active' : ''); ?>"
                href="<?php echo e(route('socios.pendientes')); ?>">
                <i class="fa-solid fa-user-group"></i>COOPERATIVISTAS
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('recibos.*') ? 'active' : ''); ?>"
                href="<?php echo e(route('recibos.pagos')); ?>">
                <i class="fa-solid fa-folder-open"></i>RECIBOS DE PAGO
            </a>
            <?php if(request()->routeIs('socios.detalle') || request()->routeIs('recibos.detalle')): ?>
                <a class="nav-link btn-back-sidebar"
                    href="<?php echo e(request()->routeIs('recibos.detalle') ? route('recibos.pagos') : route('home')); ?>">
                    <i class="fa-solid fa-arrow-left"></i>VOLVER
                </a>
            <?php else: ?>
                <a class="nav-link" href="<?php echo e(route('logout')); ?>">
                    <i class="fa-solid fa-sign-out-alt"></i>SALIR
                </a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="logo-section">
        <img src="<?php echo e(asset('img/logo_cooperativa.svg')); ?>" alt="Logo">
        <div class="logo-sidebar">COVIMT 17</div>
    </div>
</div><?php /**PATH C:\Users\sscri\OneDrive\Programacion y Desarrollo Web\Visual Studio Code\2- Proyectos en Curso\UTU\proyectoFinal\backoffice-administrador\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>