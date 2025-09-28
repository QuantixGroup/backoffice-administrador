<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <?php echo $__env->make('estructura.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <h1>alo</h1>

    <?php if(Auth::check()): ?>
        <h2>Bienvenido, <?php echo e(Auth::user()->name); ?></h2>
        <a href="/logout">Cerrar sesión</a>
    <?php endif; ?>

    <?php if(!Auth::check()): ?>
        <a href="/login">Iniciar sesión</a>
    <?php endif; ?><?php /**PATH C:\xampp\htdocs\quantix\backoffice-administrador\resources\views/estructura/header.blade.php ENDPATH**/ ?>