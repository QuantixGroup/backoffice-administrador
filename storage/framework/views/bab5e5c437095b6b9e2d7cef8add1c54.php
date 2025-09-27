<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div class="container">
    <a class="navbar-brand" href="<?php echo e(url('/')); ?>">Backoffice</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php echo e(request()->is('/') ? 'active' : ''); ?>" aria-current="page" href="<?php echo e(url('/')); ?>">
            <i class="bi bi-house me-1"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-table me-1"></i> Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-grid me-1"></i> Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-people me-1"></i> Customers</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto">
        <?php if(auth()->guard()->check()): ?>
          <li class="nav-item">
            <span class="navbar-text me-2">Hola, <?php echo e(auth()->user()->name); ?></span>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-light btn-sm" href="<?php echo e(url('/logout')); ?>">Cerrar sesión</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-primary btn-sm" href="<?php echo e(url('/login')); ?>">Iniciar sesión</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<?php /**PATH C:\xampp\htdocs\proyectoFinal\backoffice-administrador\resources\views/estructura/navbar.blade.php ENDPATH**/ ?>