
$(document).ready(function () {
    cargarSocios();
});

function cargarSocios() {
    $.ajax({
        url: "http://localhost:8000/api/socios",
        type: "GET",
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        success: function (data) {
            $("#tablaSocios").empty();
            $.each(data, function (i, socio) {
                $("#tablaSocios").append(`
                    <tr>
                        <td>${socio.cedula}</td>
                        <td>${socio.nombre}</td>
                        <td>${socio.apellido}</td>
                        <td>${socio.email}</td>
                        <td>${socio.profesion}</td>
                    </tr>
                `);
            });
        },
        error: function () {
            alert("Error al cargar socios.");
        }
    });
}
