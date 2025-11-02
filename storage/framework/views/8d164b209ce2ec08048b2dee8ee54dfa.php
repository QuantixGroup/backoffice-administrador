<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('partials.head', ['title' => 'Dashboard - COVIMT 17'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php if(session('ok')): ?>
        <meta name="success-message" content="<?php echo e(session('ok')); ?>">
    <?php endif; ?>
</head>

<body>
    <div class="success-notification" id="successNotification">
        <i class="fas fa-check-circle"></i>
        <span id="successMessage"></span>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="mt-4 text-left ">Hola <?php echo e(auth()->user()->name ?? auth()->user()->cedula); ?></h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="table-container">
                        <div class="table-header text-center">
                            <h2>Usuarios pendientes</h2>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th class="d-none d-md-table-cell">Email</th>
                                        <th class="d-none d-md-table-cell">Teléfono</th>
                                        <th class="d-none d-lg-table-cell">Fecha de Nacimiento</th>
                                        <th class="d-none d-lg-table-cell">Departamento</th>
                                        <th class="d-none d-lg-table-cell">Situación Laboral</th>
                                        <th class="d-none d-xl-table-cell">Ingresos Mensuales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $sociosPendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="table-row-selectable" data-cedula="<?php echo e($socio->cedula); ?>">
                                            <td><?php echo e($socio->nombre ?? 'N/A'); ?> <?php echo e($socio->apellido ?? ''); ?></td>
                                            <td><?php echo e($socio->cedula ?? 'N/A'); ?></td>
                                            <td class="d-none d-md-table-cell"><?php echo e($socio->email ?? 'N/A'); ?></td>
                                            <td class="d-none d-md-table-cell"><?php echo e($socio->telefono ?? 'N/A'); ?></td>
                                            <td class="d-none d-lg-table-cell">
                                                <?php echo e($socio->fecha_nacimiento ? \Carbon\Carbon::parse($socio->fecha_nacimiento)->format('d/m/Y') : 'N/A'); ?>

                                            </td>
                                            <td class="d-none d-lg-table-cell"><?php echo e($socio->departamento ?? 'N/A'); ?></td>
                                            <td class="d-none d-lg-table-cell"><?php echo e($socio->situacion_laboral ?? 'N/A'); ?></td>
                                            <td class="d-none d-xl-table-cell">
                                                <?php echo e($socio->ingresos_mensuales ? '$' . number_format($socio->ingresos_mensuales, 0, ',', '.') : 'N/A'); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No hay usuarios pendientes de aprobación
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="action-buttons">
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button id="abrirBtn" class="btn-abrir" onclick="abrirDetalle()" disabled>
                                        Abrir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\proyectoFinal\backoffice-administrador\resources\views/inicio.blade.php ENDPATH**/ ?>