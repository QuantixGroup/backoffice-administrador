function showApproveModal() {
    document.getElementById("approveModal").style.display = "block";
}

function hideApproveModal() {
    document.getElementById("approveModal").style.display = "none";
}

function showRejectModal() {
    document.getElementById("rejectModal").style.display = "block";
}

function hideRejectModal() {
    document.getElementById("rejectModal").style.display = "none";
}

function approveUser() {
    hideApproveModal();
    document.getElementById("approveForm").submit();
}

function rejectUser() {
    hideRejectModal();
    document.getElementById("rejectForm").submit();
}

function showDeleteModal() {
    document.getElementById("deleteModal").style.display = "block";
}

function hideDeleteModal() {
    document.getElementById("deleteModal").style.display = "none";
}

async function deleteUser() {
    const form = document.getElementById("deleteForm");
    const action = form.getAttribute("action");
    if (!action) {
        hideDeleteModal();
        return;
    }

    hideDeleteModal();

    try {
        const res = await fetch(action, {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "X-CSRF-TOKEN": getCsrfToken(),
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        if (res.status === 401) {
            showSuccessNotification(
                "Sesión expirada. Por favor, reingrese al sistema."
            );
            return;
        }

        let data = {};
        try {
            data = await res.json();
        } catch (e) {
            data = {};
        }

        const consideredSuccess =
            res.ok && (data.success === true || Object.keys(data).length === 0);

        if (consideredSuccess) {
            showSuccessNotification("Usuario eliminado correctamente");
            await refreshSociosTbody();
        } else {
            const msg =
                data.error || data.message || "No se pudo eliminar el usuario";
            showSuccessNotification(msg);
        }
    } catch (e) {}
}

async function refreshSociosTbody() {
    try {
        const res = await fetch("/socios/aprobados", {
            method: "GET",
            credentials: "same-origin",
            headers: {
                "X-CSRF-TOKEN": getCsrfToken(),
                Accept: "text/html",
            },
        });

        if (res.status === 401) {
            showSuccessNotification(
                "Sesión terminada. Por favor, reingrese al sistema."
            );
            return;
        }

        const html = await res.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, "text/html");
        const newTbody = doc.querySelector("#cooperativistasTable tbody");
        const table = document.querySelector("#cooperativistasTable");
        if (table && newTbody) {
            const oldTbody = table.querySelector("tbody");
            oldTbody.replaceWith(newTbody.cloneNode(true));
            bindTableSelectionHandlers();
            const accionBtn = document.getElementById("accionBtn");
            if (accionBtn) accionBtn.disabled = true;
        }
    } catch (e) {}
}

function bindTableSelectionHandlers() {
    const table = document.getElementById("cooperativistasTable");
    if (!table) return;

    let selectedCedula = null;

    table.querySelectorAll("tr.table-row-selectable").forEach((row) => {
        row.addEventListener("click", function () {
            table
                .querySelectorAll("tr.table-row-selectable")
                .forEach((r) => r.classList.remove("selected"));
            this.classList.add("selected");
            selectedCedula = this.getAttribute("data-cedula");
            const accionBtn = document.getElementById("accionBtn");
            if (accionBtn) accionBtn.disabled = false;
        });
    });

    const accionBtn = document.getElementById("accionBtn");
    if (accionBtn) {
        accionBtn.onclick = function () {
            if (!selectedCedula) return;
            const form = document.getElementById("deleteForm");
            form.action = "/socios/" + selectedCedula + "/eliminar";
            showDeleteModal();
        };
    }
}

window.showApproveModal = showApproveModal;
window.hideApproveModal = hideApproveModal;
window.showRejectModal = showRejectModal;
window.hideRejectModal = hideRejectModal;
window.approveUser = approveUser;
window.rejectUser = rejectUser;
window.showDeleteModal = showDeleteModal;
window.hideDeleteModal = hideDeleteModal;
window.deleteUser = deleteUser;

document.addEventListener("DOMContentLoaded", function () {
    const successMessage = document.querySelector(
        'meta[name="success-message"]'
    );
    if (successMessage) {
        showSuccessNotification(successMessage.getAttribute("content"));
    }

    bindTableSelectionHandlers();
});

window.onclick = function (event) {
    const approveModal = document.getElementById("approveModal");
    const rejectModal = document.getElementById("rejectModal");

    if (event.target === approveModal) {
        hideApproveModal();
    }
    if (event.target === rejectModal) {
        hideRejectModal();
    }
    const deleteModal = document.getElementById("deleteModal");
    if (event.target === deleteModal) {
        hideDeleteModal();
    }
};
