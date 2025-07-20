<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Socios</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>
<body>

    <h2>Alta de Socio</h2>

    <div>
        <input type="text" id="cedula" placeholder="Cédula">
        <input type="text" id="nombre" placeholder="Nombre">
        <input type="text" id="apellido" placeholder="Apellido">
        <input type="text" id="telefono" placeholder="Teléfono">
        <input type="text" id="direccion" placeholder="Dirección">
        <input type="email" id="email" placeholder="Email">
        <input type="password" id="contraseña" placeholder="Contraseña">
        <input type="number" id="ingreso" placeholder="Ingreso Mensual">
        <input type="text" id="profesion" placeholder="Profesión">
        <input type="text" id="estado" placeholder="Estado">
        <input type="number" id="integrantes" placeholder="Integrantes Familiares">
        <input type="date" id="fechaIngreso" placeholder="Fecha Ingreso">
        <input type="date" id="fechaEgreso" placeholder="Fecha Egreso">

        <button id="crearSocio">Crear Socio</button>
    </div>

    <hr>

    <h2>Listado de Socios</h2>
    <table>
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Profesión</th>
            </tr>
        </thead>
        <tbody id="tablaSocios"></tbody>
    </table>

    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/crear.js') }}"></script>
</body>
</html>
