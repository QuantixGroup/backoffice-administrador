<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('partials.head', ['title' => 'Recibos de Pago - COVIMT 17'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body>
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content">
        <div class="recibos-detalle-container">
            <div class="table-header text-center">
                <h2 class="mb-0">Detalles de recibos de pagos</h2>
            </div>

            <div class="content-wrapper">
                <div class="cooperativista-info">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" value="<?php echo e($cooperativista->nombre ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" value="<?php echo e($cooperativista->apellido ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="documento">Documento:</label>
                        <input type="text" id="documento" value="<?php echo e($cooperativista->cedula ?? ''); ?>" readonly>
                    </div>
                </div>

                <div class="recibos-table-container">
                    <div class="recibos-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Nombre</th>
                                    <th>Mes</th>
                                    <th>Año</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($recibos) && count($recibos) > 0): ?>
                                    <?php $__currentLoopData = $recibos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recibo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($recibo['numero'] ?? 'Data'); ?></td>
                                            <td><?php echo e($recibo['nombre_completo'] ?? 'Data'); ?></td>
                                            <td><?php echo e($recibo['mes'] ?? 'Data'); ?></td>
                                            <td><?php echo e($recibo['año'] ?? 'Data'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <?php for($i = 1; $i <= 8; $i++): ?>
                                        <tr>
                                            <td>Data</td>
                                            <td>Data</td>
                                            <td>Data</td>
                                            <td>Data</td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH C:\Users\sscri\OneDrive\Programacion y Desarrollo Web\Visual Studio Code\2- Proyectos en Curso\UTU\proyectoFinal\backoffice-administrador\resources\views/recibos-detalle.blade.php ENDPATH**/ ?>