<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('partials.head', ['title' => 'Recibos de Pago - COVIMT 17'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body>
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content">
        <div class="success-notification" id="successNotification">
            <i class="fas fa-check-circle"></i>
            <span id="successMessage"></span>
        </div>

        <div class="recibos-detalle-container mt-4">
            <div class="table-header text-center mt-5">
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
                                    <th>Monto</th>
                                    <th>Mes</th>
                                    <th>Año</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($recibos) && count($recibos) > 0): ?>
                                    <?php $__currentLoopData = $recibos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recibo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr data-recibo-id="<?php echo e($recibo['id_pago'] ?? ''); ?>">
                                            <td><?php echo e($recibo['numero'] ?? ''); ?></td>
                                            <td><?php echo e($recibo['monto'] ?? ''); ?></td>
                                            <td><?php echo e($recibo['mes'] ?? ''); ?></td>
                                            <td><?php echo e($recibo['año'] ?? ''); ?></td>
                                            <td>
                                                <select class="estado-select" data-id="<?php echo e($recibo['id_pago'] ?? ''); ?>"
                                                    data-original-estado="<?php echo e($recibo['estado'] ?? 'pendiente'); ?>">
                                                    <option value="pendiente" <?php echo e(($recibo['estado'] ?? '') == 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                                                    <option value="aceptado" <?php echo e(($recibo['estado'] ?? '') == 'aceptado' ? 'selected' : ''); ?>>Aceptado</option>
                                                    <option value="rechazado" <?php echo e(($recibo['estado'] ?? '') == 'rechazado' ? 'selected' : ''); ?>>Rechazado</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No hay recibos disponibles</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if(isset($recibos) && count($recibos) > 0): ?>
                        <div class="text-center mt-4 mb-4">
                            <button id="guardarCambiosBtn" class="btn-guardar-cambios" disabled>
                                Guardar
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\proyectoFinal\backoffice-administrador\resources\views/recibos-detalle.blade.php ENDPATH**/ ?>