<?php echo $__env->make( 'estructura.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<h2>Login de Administrador</h2>

<?php if($errors->any()): ?>
    <div style="color:red"><?php echo e($errors->first()); ?></div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('login.post')); ?>">
  <?php echo csrf_field(); ?>

  <label>Cédula</label><br>
  <input type="text" name="cedula"><br><br>

  <label>Contraseña</label><br>
  <input type="password" name="password"><br><br>

  <button type="submit">Ingresar</button>
</form>

<?php echo $__env->make('estructura.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proyectoFinal\backoffice-administrador\resources\views/login.blade.php ENDPATH**/ ?>