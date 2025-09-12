<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
  <?php echo $__env->make('partials.head', ['title' => 'Iniciar Sesión - COVIMT 17'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="body-background">
  <main>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="logo-container">
            <img src="<?php echo e(asset('img/logo_cooperativa.svg')); ?>" alt="Logo">
            <h1 class="logo-text">COVIMT 17</h1>
          </div>
          <div class="login-card">
            <?php if($errors->any()): ?>
              <div class="alert alert-danger text-center"><?php echo e($errors->first()); ?></div>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('login.post')); ?>">
              <?php echo csrf_field(); ?>
              <div class="mb-3">
                <label for="cedula" class="form-label">Usuario (CI)</label>
                <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ingrese su Documento">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <div class="position-relative">
                  <input type="password" name="password" id="password" class="form-control" placeholder="Su contraseña">
                  <button type="button" class="btn-toggle-password" onclick="togglePassword()">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                  </button>
                </div>
              </div>
              <button type="submit" class="btn-login w-100">
                <i class="fa-solid fa-right-to-bracket mr-4"></i> Entrar
              </button>
              <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember" name="remember">
                  <label class="form-check-label" for="remember">Recordar</label>
                </div>
                <a href="#">¿Olvidó su contraseña?</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>
</body>

</html><?php /**PATH C:\Users\sscri\OneDrive\Programacion y Desarrollo Web\Visual Studio Code\2- Proyectos en Curso\UTU\proyectoFinal\backoffice-administrador\resources\views/login.blade.php ENDPATH**/ ?>