let rowSelector;

document.addEventListener("DOMContentLoaded", function () {
    rowSelector = new TableRowSelector(
        ".table-row-selectable",
        "abrirBtn",
        "cedula"
    );

    const successMessage = document.querySelector(
        'meta[name="success-message"]'
    );
    if (successMessage) {
        showSuccessNotification(successMessage.getAttribute("content"));
    }
});

function abrirDetalle() {
    const selectedCedula = rowSelector?.getSelectedValue();
    if (selectedCedula) {
        window.location.href = `/socios/${selectedCedula}/detalle`;
    }
}

window.abrirDetalle = abrirDetalle;
