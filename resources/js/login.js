document.addEventListener("DOMContentLoaded", function () {
    const rememberCheckbox = document.getElementById("remember");

    if (localStorage.getItem("rememberLogin") === "true") {
        rememberCheckbox.checked = true;
        const savedUser = localStorage.getItem("savedUser");
        if (savedUser) {
            document.getElementById("cedula").value = savedUser;
        }
    }

    rememberCheckbox.addEventListener("change", function () {
        if (this.checked) {
            localStorage.setItem("rememberLogin", "true");
        } else {
            localStorage.removeItem("rememberLogin");
            localStorage.removeItem("savedUser");
        }
    });

    const loginForm = document.querySelector("form");
    loginForm.addEventListener("submit", function () {
        if (rememberCheckbox.checked) {
            const cedulaValue = document.getElementById("cedula").value;
            localStorage.setItem("savedUser", cedulaValue);
        }
    });

    const forgotPasswordLink = document.querySelector('a[href="#"]');
    forgotPasswordLink.addEventListener("click", function (e) {
        e.preventDefault();
        const el = document.getElementById("forgotPasswordModal");
        if (el) new bootstrap.Modal(el).show();
    });
});

function togglePassword() {
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    }
}

window.togglePassword = togglePassword;

function showForgotPasswordModal() {
    const el = document.getElementById("forgotPasswordModal");
    if (el) new bootstrap.Modal(el).show();
}

function sendRecoveryEmail() {
    const email = document.getElementById("emailRecovery").value;

    if (!email) {
        alert("Por favor ingrese su email");
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Por favor ingrese un email válido");
        return;
    }

    const sendButton = document.querySelector("#sendRecoveryButton");
    const originalText = sendButton.textContent;

    sendButton.disabled = true;
    sendButton.textContent = "Enviando...";

    setTimeout(() => {
        alert("Se ha enviado un email para recuperar su contraseña");

        const modal = bootstrap.Modal.getInstance(
            document.getElementById("forgotPasswordModal")
        );
        modal.hide();

        sendButton.disabled = false;
        sendButton.textContent = originalText;

        document.getElementById("emailRecovery").value = "";
    }, 2000);
}

function addLoginEffects() {
    const cedulaInput = document.getElementById("cedula");
    const passwordInput = document.getElementById("password");

    [cedulaInput, passwordInput].forEach((input) => {
        input.addEventListener("focus", function () {
            this.parentElement.classList.add("input-focused");
        });

        input.addEventListener("blur", function () {
            this.parentElement.classList.remove("input-focused");
        });
    });

    cedulaInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
        if (this.value.length > 8) {
            this.value = this.value.substring(0, 8);
        }
    });
}

document.addEventListener("DOMContentLoaded", addLoginEffects);
