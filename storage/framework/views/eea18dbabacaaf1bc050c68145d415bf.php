<?php echo $__env->make( 'estructura.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php if(session('ok')): ?>
<div style="color:green"><?php echo e(session('ok')); ?></div> <?php endif; ?>
<?php if(session('error')): ?>
<div style="color:red"><?php echo e(session('error')); ?></div> <?php endif; ?>

<h2>Socios pendientes</h2>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Situación laboral</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $sociosPendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($socio->cedula); ?></td>
                <td><?php echo e($socio->nombre); ?></td>
                <td><?php echo e($socio->apellido); ?></td>
                <td><?php echo e($socio->email); ?></td>
                <td><?php echo e($socio->situacion_laboral ?? '-'); ?></td>
                <td>
                    <form method="POST" action="<?php echo e(route('socios.aprobar', $socio->cedula)); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit">Aprobar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6">No hay socios pendientes.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php echo $__env->make('estructura.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\quantix\backoffice-administrador\resources\views/socios.blade.php ENDPATH**/ ?>