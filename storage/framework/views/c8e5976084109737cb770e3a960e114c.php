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
                    <div class="table-responsive">
                        <table id="recibosTable" class="table table-hover mb-0">
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
                                        <tr class="table-row-selectable" data-recibo="<?php echo e($recibo['id_pago'] ?? ''); ?>"
                                            data-recibo-id="<?php echo e($recibo['id_pago'] ?? ''); ?>"
                                            data-numero="<?php echo e($recibo['numero'] ?? ''); ?>"
                                            data-monto="<?php echo e($recibo['monto'] ?? ''); ?>"
                                            data-estado="<?php echo e($recibo['estado'] ?? 'pendiente'); ?>"
                                            data-archivo="<?php echo e($recibo['archivo_comprobante'] ?? ''); ?>"
                                            data-observacion="<?php echo e($recibo['observacion'] ?? ''); ?>">
                                            <td><?php echo e($recibo['numero'] ?? ''); ?></td>
                                            <td><?php echo e($recibo['monto'] ?? ''); ?></td>
                                            <td><?php echo e($recibo['mes'] ?? ''); ?></td>
                                            <td><?php echo e($recibo['año'] ?? ''); ?></td>
                                            <td>
                                                <span
                                                    class="badge <?php echo e(($recibo['estado'] ?? 'pendiente') == 'aceptado' ? 'bg-success' : (($recibo['estado'] ?? 'pendiente') == 'rechazado' ? 'bg-danger' : 'bg-warning')); ?>">
                                                    <?php echo e(ucfirst($recibo['estado'] ?? 'Pendiente')); ?>

                                                </span>
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
                    <div class="mt-3 text-center">
                        <button id="btnAbrirRecibo" class="btn-abrir" disabled>Abrir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalReciboDetalle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Recibo #<span id="modalReciboNumero"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="pdf-container">
                                <iframe id="pdfViewer"></iframe>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold mt-4">Monto</label>
                                <input type="text" id="modalMonto" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Estado</label>
                                <select id="modalEstado" class="form-select">
                                    <option value="pendiente" selected>Pendiente</option>
                                    <option value="aceptado">Aceptado</option>
                                    <option value="rechazado">Rechazado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Observación</label>
                                <textarea id="modalObservacion" class="form-control" rows="4"
                                    placeholder="Escriba una observación"></textarea>
                            </div>
                            <input type="hidden" id="modalReciboId">
                            <div class="d-grid">
                                <button type="button" class="btn-guardar" id="btnGuardar">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/recibo-pago.js']); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\proyectoFinal\backoffice-administrador\resources\views/recibos-detalle.blade.php ENDPATH**/ ?>