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

    @include('estructura.navbar')

    <h1>alo</h1>

    @if(Auth::check())
        <h2>Bienvenido, {{ Auth::user()->name }}</h2>
        <a href="/logout">Cerrar sesión</a>
    @endif

    @if (!Auth::check())
        <a href="/login">Iniciar sesión</a>
    @endif