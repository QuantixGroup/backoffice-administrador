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

        <input type="date" id="fecha_nacimiento" placeholder="Fecha de Nacimiento">

        <input type="text" id="telefono" placeholder="Teléfono">
        <input type="text" id="direccion" placeholder="Dirección">
        <input type="text" id="departamento" placeholder="Departamento">
        <input type="text" id="ciudad" placeholder="Ciudad">

        <input type="email" id="email" placeholder="Email">
        <input type="password" id="contraseña" placeholder="Contraseña">

        <input type="number" id="ingreso_mensual" placeholder="Ingreso Mensual">

        <label for="situacion_laboral">Situación Laboral:</label>
        <select id="situacion_laboral">
            <option value="Empleado/a">Empleado/a</option>
            <option value="Desempleado/a">Desempleado/a</option>
            <option value="Independiente">Independiente</option>
        </select>

        <label for="integrantes_familiares">Integrantes Familiares:</label>
        <select id="integrantes_familiares">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4+">4+</option>
        </select>

        <input type="hidden" id="estado" value="pendiente">

        <input type="date" id="fecha_ingreso" placeholder="Fecha Ingreso">
        <input type="date" id="fecha_egreso" placeholder="Fecha Egreso">

        <br><br>
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
