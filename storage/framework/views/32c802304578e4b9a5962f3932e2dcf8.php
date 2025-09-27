<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('partials.head', ['title' => 'Mi Perfil - COVIMT 17'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<body>
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-4 text-center">Perfil de <?php echo e($user->name ?? 'Administrador'); ?></h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="profile-container">
                        <form id="profile-form" class="profile-form">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3 row">
                                <label for="nombre" class="col-sm-4 col-form-label">Nombre</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        value="<?php echo e($user->name ?? ''); ?>" data-original-value="<?php echo e($user->name ?? ''); ?>"
                                        disabled>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="apellido" class="col-sm-4 col-form-label">Apellido</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="apellido" name="apellido"
                                        value="<?php echo e($user->apellido ?? ''); ?>"
                                        data-original-value="<?php echo e($user->apellido ?? ''); ?>" disabled>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="col-sm-4 col-form-label">Email de Contacto</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?php echo e($user->email ?? ''); ?>" data-original-value="<?php echo e($user->email ?? ''); ?>"
                                        disabled>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="documento" class="col-sm-4 col-form-label">Documento</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control no-edit" id="documento" name="documento"
                                        value="<?php echo e($user->cedula ?? ''); ?>"
                                        data-original-value="<?php echo e($user->cedula ?? ''); ?>" disabled>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="fecha_nacimiento" class="col-sm-4 col-form-label">Fecha de
                                    Nacimiento</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="fecha_nacimiento"
                                        name="fecha_nacimiento" value="<?php echo e($user->fecha_nacimiento ?? ''); ?>"
                                        data-original-value="<?php echo e($user->fecha_nacimiento ?? ''); ?>" disabled>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="telefono" class="col-sm-4 col-form-label">Teléfono de Contacto</label>
                                <div class="col-sm-8">
                                    <input type="tel" class="form-control" id="telefono" name="telefono"
                                        value="<?php echo e($user->telefono ?? ''); ?>"
                                        data-original-value="<?php echo e($user->telefono ?? ''); ?>" disabled>
                                </div>
                            </div>

                            <div class="profile-actions">
                                <button type="button" id="edit-profile-btn" class="btn btn-edit-profile">
                                    <i class="fa-solid fa-pen-to-square me-2"></i>Editar Perfil
                                </button>
                                <button type="button" id="cancel-profile-btn" class="btn btn-secondary"
                                    style="display: none;">
                                    <i class="fa-solid fa-times me-2"></i>Cancelar
                                </button>
                                <button type="button" id="save-profile-btn" class="btn btn-success"
                                    style="display: none;">
                                    <i class="fa-solid fa-save me-2"></i>Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="profile-container">
                        <div class="profile-image-section">
                            <img id="current-profile-image" src="<?php echo e($profileImageUrl); ?>" alt="Foto de perfil"
                                class="current-profile-image"
                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xMDAgNzBDMTEzLjgwNyA3MCAxMjUgNTguODA3IDEyNSA0NUM1IDMxLjE5MyA0My44MDcgMjAgMzBTMzEuMTkzIDEwIDQ1IDEwUzEwMCAzMS4xOTMgMTAwIDQ1UzEwOCA4MS4xOTMgMTAwIDcwWk0xNTAgMTQwQzE1MCA5NS44MTcgMTI3LjU4MyA4NSAxMDAgODVTNTAgOTUuODE3IDUwIDE0MEg1MCIgZmlsbD0iIzlDQTNBRiIvPgo8L3N2Zz4='">

                            <button type="button" class="image-upload-button"
                                onclick="document.getElementById('profile-image-dropzone').click()">
                                <i class="fa-solid fa-camera me-2"></i>Agregar Imagen
                            </button>

                            <div id="profile-image-dropzone" class="dropzone" style="display: none;">
                                <div class="dz-message">
                                    <i class="fa-solid fa-cloud-upload-alt fa-3x mb-3"></i>
                                    <p>Arrastra una imagen aquí o haz clic para seleccionar</p>
                                    <small>Tamaño máximo: 2MB | Formatos: JPG, PNG</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
</body>

</html><?php /**PATH C:\xampp\htdocs\proyectoFinal\backoffice-administrador\resources\views/perfil.blade.php ENDPATH**/ ?>