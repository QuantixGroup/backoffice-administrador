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
});

function abrirDetalle() {
    if (selectedCedula) {
        window.location.href = `/socios/${selectedCedula}/detalle`;
    }
}

function showSuccessNotification(message) {
    const notification = document.getElementById("successNotification");
    const messageSpan = document.getElementById("successMessage");

    messageSpan.textContent = message;
    notification.classList.add("show");

    setTimeout(function () {
        notification.classList.remove("show");
    }, 4000);
}

window.abrirDetalle = abrirDetalle;
window.showSuccessNotification = showSuccessNotification;
