const showSuccessNotification = (m, d = 4e3) => {
    let n = document.getElementById("successNotification");
    let t = document.getElementById("successMessage");

    if (n && t) {
        t.textContent = m;
        n.style.display = "block";
        setTimeout(() => (n.style.display = "none"), d);
        return;
    }

    n = document.createElement("div");
    n.className = "success-notification show";
    n.innerHTML = `<i class="fas fa-check-circle" style="margin-right:0.5rem"></i><span class="js-temp-success">${m}</span>`;
    document.body.appendChild(n);
    setTimeout(() => {
        if (n.parentNode) n.remove();
    }, d);
};

const showNotification = (message, type = "success", duration = 4000) => {
    const notification = document.createElement("div");
    notification.className = "success-notification";

    const colors = {
        success: "#28a745",
        danger: "#dc3545",
        warning: "#ffc107",
        info: "#17a2b8",
    };

    const icons = {
        success: "fa-check-circle",
        danger: "fa-exclamation-circle",
        warning: "fa-exclamation-triangle",
        info: "fa-info-circle",
    };

    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: ${colors[type] || colors.success};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.375rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1060;
        display: flex;
        align-items: center;
        min-width: 300px;
        animation: slideInRight 0.3s ease-out;
    `;

    notification.innerHTML = `
        <i class="fas ${
            icons[type] || icons.success
        }" style="margin-right: 0.5rem; font-size: 1.2rem;"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, duration);
};

const getCsrfToken = () => {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute("content") : "";
};

const handleFetchError = async (response, data) => {
    if (response.status === 401) {
        showNotification(
            data?.message || "La contraseña actual es incorrecta",
            "danger"
        );
        return true;
    }

    if (response.status === 422) {
        const errors = data?.errors || {};
        const messages = [];

        Object.keys(errors).forEach((field) => {
            if (Array.isArray(errors[field])) {
                messages.push(...errors[field]);
            }
        });

        const message = messages.length
            ? messages.join(". ")
            : data?.message || "Error de validación";
        showNotification(message, "danger");
        return true;
    }

    if (response.status >= 500) {
        showNotification(
            data?.message || "Error del servidor. Intente nuevamente.",
            "danger"
        );
        return true;
    }

    if (!response.ok) {
        showNotification(
            data?.message || "Ocurrió un error inesperado",
            "danger"
        );
        return true;
    }

    return false;
};

const initializeTogglePassword = () => {
    const toggles = document.querySelectorAll(".toggle-password");

    toggles.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            const targetSelector = btn.getAttribute("data-target");
            if (!targetSelector) return;

            const input = document.querySelector(targetSelector);
            if (!input) return;

            if (input.type === "password") {
                input.type = "text";
                const icon = btn.querySelector("i");
                if (icon) {
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                }
                btn.setAttribute("aria-label", "Ocultar contraseña");
            } else {
                input.type = "password";
                const icon = btn.querySelector("i");
                if (icon) {
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
                btn.setAttribute("aria-label", "Mostrar contraseña");
            }
        });
    });
};

const togglePassword = (passwordId = "password", iconId = "toggleIcon") => {
    const passwordInput = document.getElementById(passwordId);
    const toggleIcon = document.getElementById(iconId);

    if (!passwordInput || !toggleIcon) return;

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    }
};

const setupCedulaValidation = (inputId = "cedula") => {
    const input = document.getElementById(inputId);
    if (!input) return;

    input.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
        if (this.value.length > 8) {
            this.value = this.value.substring(0, 8);
        }
    });
};

class TableRowSelector {
    constructor(s, b, a = "cooperativista") {
        this.tableSelector = s;
        const t = document.querySelector(s);
        this.table = t
            ? t.tagName && t.tagName.toLowerCase() === "table"
                ? t
                : t.closest && t.closest("table")
                ? t.closest("table")
                : document.querySelector("table")
            : document.querySelector("table");
        this.button = document.getElementById(b) || null;
        this.selectedValue = null;
        this.dataAttribute = a;
        if (this.table) this.bindEvents();
    }
    bindEvents() {
        if (!this.table) return;
        this.table.addEventListener("click", (e) => {
            const r = e.target.closest("tr");
            if (
                r &&
                r.parentNode &&
                r.parentNode.tagName.toLowerCase() === "tbody" &&
                r.closest &&
                r.closest("table") === this.table
            )
                this.selectRow(r);
        });
    }
    selectRow(r) {
        this.clearSelection();
        r.classList.add("selected", "table-primary");
        this.selectedValue =
            r.dataset[this.dataAttribute] ||
            r.getAttribute(`data-${this.dataAttribute}`);
        if (this.selectedValue && this.button) this.button.disabled = false;
    }
    clearSelection() {
        this.table
            .querySelectorAll("tbody tr.table-row-selectable")
            .forEach((r) => r.classList.remove("selected", "table-primary"));
        this.selectedValue = null;
        if (this.button) this.button.disabled = true;
    }
    getSelectedValue() {
        return this.selectedValue;
    }
}

const openRecibo = (
    v,
    meta = "recibos-detalle-url",
    fb = "/recibos/detalle"
) => {
    if (!v) {
        alert("Por favor, seleccione un cooperativista primero");
        return;
    }
    const base =
        document
            .querySelector(`meta[name="${meta}"]`)
            ?.getAttribute("content") || fb;
    window.location.href = `${base}?documento=${v}`;
};

window.showSuccessNotification = showSuccessNotification;
window.showNotification = showNotification;
window.getCsrfToken = getCsrfToken;
window.handleFetchError = handleFetchError;
window.initializeTogglePassword = initializeTogglePassword;
window.togglePassword = togglePassword;
window.setupCedulaValidation = setupCedulaValidation;
window.TableRowSelector = TableRowSelector;
window.openRecibo = openRecibo;

document.addEventListener("DOMContentLoaded", () => {
    initializeTogglePassword();
});
