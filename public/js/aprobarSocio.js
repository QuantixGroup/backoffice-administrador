$(document).on("click", ".aprobar-btn", function () {
    const cedula = $(this).data("cedula");

    $.ajax({
        url: "http://localhost:8000/api/socios/" + cedula + "/aprobar",
        type: "PUT",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("access_token"),
            "Accept": "application/json"
        },
        success: function () {
            alert("Socio aprobado correctamente");
            location.reload();
        },
        error: function () {
            alert("Error al aprobar socio");
        }
    });
});
