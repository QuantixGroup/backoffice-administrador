<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('partials.head', ['title' => 'Cambiar Contraseña - COVIMT 17'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>

<body>
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content">
        <div class="container-fluid">
            <?php if(isset($user->primer_password) && $user->primer_password): ?>
                <div class="d-flex justify-content-center mt-3">
                    <div class="small-alert alert-primer-inicio d-flex align-items-center px-3 py-2 rounded shadow-sm"
                        role="alert" aria-live="assertive">
                        <i class="fas fa-shield-alt me-2 text-warning alert-icon"></i>
                        <div class="alert-text">
                            <strong>Primer inicio:</strong> Por seguridad, cambia tu contraseña en este formulario.
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-4 mt-4 text-center">Cambiar Contraseña</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6 profile-container">
                    <form id="change-password-form" class="change-password-form">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="current_password" class="col-form-label">Contraseña Actual</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                    data-target="#current_password" aria-label="Mostrar contraseña">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="col-form-label">Nueva Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    required>
                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                    data-target="#new_password" aria-label="Mostrar contraseña">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_new_password" class="col-form-label">Confirmar Nueva
                                Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_new_password"
                                    name="confirm_new_password" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                    data-target="#confirm_new_password" aria-label="Mostrar contraseña">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn-cambiar-password">Cambiar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
</body>

</html><?php /**PATH C:\xampp\htdocs\proyectoFinal\backoffice-administrador\resources\views/cambiar_password.blade.php ENDPATH**/ ?>