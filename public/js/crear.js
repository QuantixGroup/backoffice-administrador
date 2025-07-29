$("#crearSocio").click(function () {
    let socio = {
        cedula: $("#cedula").val(),
        nombre: $("#nombre").val(),
        apellido: $("#apellido").val(),
        fecha_nacimiento: $("#fecha_nacimiento").val(),
        telefono: $("#telefono").val(),
        direccion: $("#direccion").val(),
        departamento: $("#departamento").val(),
        ciudad: $("#ciudad").val(),
        email: $("#email").val(),
        contraseña: $("#contraseña").val(),
        ingreso_mensual: $("#ingreso_mensual").val(),
        situacion_laboral: $("#situacion_laboral").val(),
        estado: "pendiente",
        integrantes_familiares: $("#integrantes_familiares").val(),
        fecha_ingreso: $("#fecha_ingreso").val(),
        fecha_egreso: $("#fecha_egreso").val()
    };


    $.ajax({
        url: "http://localhost:8000/api/socios",
        type: "POST",
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        data: JSON.stringify(socio),
        success: function () {
            alert("Socio creado correctamente");
            cargarSocios();
        },
        error: function () {
            alert("Error al crear socio.");
        }
    });
});
