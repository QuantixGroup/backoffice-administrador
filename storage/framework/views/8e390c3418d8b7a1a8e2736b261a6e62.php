<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('partials.head', ['title' => 'Cooperativistas - COVIMT 17'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body>
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="table-container">
                        <div class="table-header text-center">
                            <h2 class="mb-0">Listado de Cooperativistas</h2>
                        </div>

                        <div class="mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" id="searchCedula" class="form-control"
                                            placeholder="Buscar por documento..." maxlength="8">
                                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-8 text-md-end">
                                    <span id="searchResults" class="text-muted"></span>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="cooperativistasTable" class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Documento</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Fecha de Aprobación</th>
                                        <th>Horas Trabajadas</th>
                                        <th>Estado de Pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $sociosAprobados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="table-row-selectable" data-cedula="<?php echo e($socio->cedula); ?>">
                                            <td><?php echo e($socio->nombre ?? 'N/A'); ?></td>
                                            <td><?php echo e($socio->apellido ?? 'N/A'); ?></td>
                                            <td><?php echo e($socio->cedula ?? 'N/A'); ?></td>
                                            <td><?php echo e($socio->telefono ?? 'N/A'); ?></td>
                                            <td><?php echo e($socio->email ?? 'N/A'); ?></td>
                                            <td><?php echo e($socio->updated_at ? $socio->updated_at->format('d/m/Y H:i') : 'N/A'); ?>

                                            </td>
                                            <td>
                                                <?php echo $socio->horas_trabajadas_badge; ?>

                                            </td>
                                            <td>
                                                <?php echo $socio->estado_pago_badge; ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No hay cooperativistas aprobados aún
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\quantix\backoffice-administrador\resources\views/listado-cooperativistas.blade.php ENDPATH**/ ?>