<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('partials.head', ['title' => 'Recibos de Pago - COVIMT 17'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <meta name="recibos-detalle-url" content="<?php echo e(route('recibos.detalle')); ?>">
</head>

<body>
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="table-container">
                        <div class="table-header text-center">
                            <h2 class="mb-0">Recibos de Pago</h2>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="recibosTable" class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Documento</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Horas Trabajadas</th>
                                    <th>Estado de Pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $sociosAprobados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="recibo-row" data-cooperativista="<?php echo e($socio->cedula ?? 'N/A'); ?>">
                                        <td><?php echo e($socio->nombre ?? 'N/A'); ?></td>
                                        <td><?php echo e($socio->apellido ?? 'N/A'); ?></td>
                                        <td><?php echo e($socio->cedula ?? 'N/A'); ?></td>
                                        <td><?php echo e($socio->telefono ?? 'N/A'); ?></td>
                                        <td><?php echo e($socio->email ?? 'N/A'); ?></td>
                                        <td>
                                            <?php echo $socio->horas_trabajadas_badge; ?>

                                        </td>
                                        <td>
                                            <?php echo $socio->estado_pago_badge; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No hay cooperativistas aprobados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="action-buttons">
                        <div class="row">
                            <div class="col-12 text-end">
                                <button id="abrirReciboBtn" class="btn-ver-recibo" onclick="abrirRecibo()" disabled>
                                    Ver Recibos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>

</html><?php /**PATH C:\Users\sscri\OneDrive\Programacion y Desarrollo Web\Visual Studio Code\2- Proyectos en Curso\UTU\proyectoFinal\backoffice-administrador\resources\views/recibos-pagos.blade.php ENDPATH**/ ?>