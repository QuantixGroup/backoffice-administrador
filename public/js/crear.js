$("#crearSocio").click(function () {
    let socio = {
        cedula: $("#cedula").val(),
        nombre: $("#nombre").val(),
        apellido: $("#apellido").val(),
        telefono: $("#telefono").val(),
        direccion: $("#direccion").val(),
        email: $("#email").val(),
        contraseña: $("#contraseña").val(),
        IngresoMensual: $("#ingreso").val(),
        profesion: $("#profesion").val(),
        estado: $("#estado").val(),
        IntegrantesFamiliares: $("#integrantes").val(),
        FechaIngreso: $("#fechaIngreso").val(),
        FechaEgreso: $("#fechaEgreso").val()
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
