<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php if(session('ok')): ?>
        <meta name="success-message" content="<?php echo e(session('ok')); ?>">
    <?php endif; ?>
</head>

<body>
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content">
        <div class="success-notification" id="successNotification">
            <i class="fas fa-check-circle"></i>
            <span id="successMessage"></span>
        </div>

        <div class="container-fluid">
            <div class="form-container mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Nombre</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo e($socio->nombre ?? ''); ?>" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Apellido</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo e($socio->apellido ?? ''); ?>" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" value="<?php echo e($socio->email ?? ''); ?>" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Departamento</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo e($socio->departamento ?? ''); ?>"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Ingresos Mensuales</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="<?php echo e($socio->ingresos_mensuales ? '$' . number_format($socio->ingresos_mensuales, 0, ',', '.') : ''); ?>"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Estado Civil</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo e($socio->estado_civil ?? ''); ?>"
                                    disabled>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Documento</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo e($socio->cedula ?? ''); ?>" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Fecha de Nacimiento</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="<?php echo e($socio->fecha_nacimiento ? \Carbon\Carbon::parse($socio->fecha_nacimiento)->format('d/m/Y') : ''); ?>"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Teléfono</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo e($socio->telefono ?? ''); ?>" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Ciudad</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo e($socio->ciudad ?? ''); ?>" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Situación Laboral</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo e($socio->situacion_laboral ?? ''); ?>"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Cantidad de Integrantes</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="<?php echo e($socio->integrantes_familiares ?? ''); ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">¿Por qué desea unirse a nuestra cooperativa de
                                viviendas?</label>
                            <textarea class="form-control textarea-large" rows="8"
                                disabled><?php echo e($socio->motivacion ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center mt-4">
                    <button type="button" class="btn-reject" onclick="showRejectModal()">
                        Rechazar Usuario
                    </button>
                    <button type="button" class="btn-approve" onclick="showApproveModal()">
                        Aceptar Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="approveModal">
        <div class="modal-content">
            <div class="modal-title">¿Está seguro que desea aceptar la solicitud?</div>
            <div class="modal-buttons">
                <button class="btn-modal-cancel" onclick="hideApproveModal()">Cancelar</button>
                <button class="btn-modal-confirm btn-aprobar" data-cedula="<?php echo e($socio->cedula); ?>"
                    onclick="approveUser()">Aceptar</button>
            </div>
        </div>
    </div>


    <div class="modal-overlay" id="rejectModal">
        <div class="modal-content">
            <div class="modal-title">¿Está seguro que desea rechazar la solicitud?</div>
            <div class="modal-buttons">
                <button class="btn-modal-cancel" onclick="hideRejectModal()">Cancelar</button>
                <button class="btn-modal-confirm" onclick="rejectUser()">Aceptar</button>
            </div>
        </div>
    </div>

    <form id="approveForm" method="POST" action="<?php echo e(route('socios.aprobar', $socio->cedula)); ?>" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>

    <form id="rejectForm" method="POST" action="<?php echo e(route('socios.rechazar', $socio->cedula)); ?>" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\proyectoFinal\backoffice-administrador\resources\views/socio-detalle.blade.php ENDPATH**/ ?>