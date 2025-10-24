<button id="sidebarHamburger" class="btn-toggle" aria-label="Toggle sidebar" aria-expanded="false"
    data-target="#mainSidebar"><i class="fa-solid fa-bars"></i>
</button>

<div class="sidebar" id="mainSidebar">
    <div class="navigation-section">
        <nav class="nav flex-column">
            <a class="nav-link <?php echo e(request()->routeIs('home') || request()->routeIs('socios.detalle') ? 'active' : ''); ?>"
                href="<?php echo e(route('home')); ?>">
                <i class="fa-solid fa-house-chimney"></i>INICIO
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('perfil') ? 'active' : ''); ?>" href="<?php echo e(route('perfil')); ?>">
                <i class="fa-solid fa-user"></i>MI PERFIL
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('perfil.cambiar-password.form') ? 'active' : ''); ?>"
                href="<?php echo e(route('perfil.cambiar-password.form')); ?>">
                <i class="fa-solid fa-key"></i>CAMBIAR CONTRASEÑA
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('socios.aprobados') ? 'active' : ''); ?>"
                href="<?php echo e(route('socios.aprobados')); ?>">
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
</div>
</div><?php /**PATH C:\xampp\htdocs\proyectoFinal\backoffice-administrador\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>