<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Socios</title>
</head>
<body>
    <h1>Socios</h1>

    <form action="/socio" method="POST">
        @csrf
        Cédula: <input type="text" name="cedula"><br>
        Nombre: <input type="text" name="nombre"><br>
        Apellido: <input type="text" name="apellido"><br>
        Teléfono: <input type="text" name="telefono"><br>
        Dirección: <input type="text" name="direccion"><br>
        Email: <input type="email" name="email"><br>
        Contraseña: <input type="password" name="contraseña"><br>
        Ingreso mensual: <input type="text" name="IngresoMensual"><br>
        Profesión: <input type="text" name="profesion"><br>
        Estado: <select name="estado">
            <option value="pendiente">Pendiente</option>
            <option value="aprobado">Aprobado</option>
            <option value="rechazado">Rechazado</option>
        </select><br>
        Integrantes familiares: <input type="number" name="IntegrantesFamiliares"><br>
        Fecha de ingreso: <input type="date" name="FechaIngreso"><br>
        Fecha de egreso: <input type="date" name="FechaEgreso"><br>
        <input type="submit" value="Agregar Socio"><br><br>
    </form>

    @if(session("socioAgregado"))
        <strong>Socio agregado correctamente.</strong>
    @endif

    <h2>Listado</h2>
    @foreach ($socios as $socio)
        <div>
            {{ $socio->cedula }} - {{ $socio->nombre }} {{ $socio->apellido }}
        </div>
    @endforeach
</body>
</html>
