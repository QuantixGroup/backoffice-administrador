let selectedRow = null;
let selectedCedula = null;

document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll(".user-row");
    const abrirBtn = document.getElementById("abrirBtn");

    rows.forEach((row) => {
        row.addEventListener("click", function () {
            if (selectedRow) {
                selectedRow.classList.remove("selected", "table-primary");
            }

            selectedRow = this;
            selectedCedula = this.getAttribute("data-cedula");
            this.classList.add("selected", "table-primary");

            abrirBtn.disabled = false;
        });
    });

    const successMessage = document.querySelector(
        'meta[name="success-message"]'
    );
    if (successMessage) {
        showSuccessNotification(successMessage.getAttribute("content"));
    }
});

function abrirDetalle() {
    if (selectedCedula) {
        window.location.href = `/socios/${selectedCedula}/detalle`;
    }
}

window.abrirDetalle = abrirDetalle;
