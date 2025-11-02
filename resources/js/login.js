document.addEventListener("DOMContentLoaded", function () {
    const rememberCheckbox = document.getElementById("remember");
    const cedulaInput = document.getElementById("cedula");
    const loginForm = document.querySelector("form");
    const forgotPasswordLink = document.querySelector('a[href="#"]');

    if (rememberCheckbox) {
        if (localStorage.getItem("rememberLogin") === "true") {
            rememberCheckbox.checked = true;
            const savedUser = localStorage.getItem("savedUser");
            if (savedUser && cedulaInput) {
                cedulaInput.value = savedUser;
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
    }

    if (loginForm) {
        loginForm.addEventListener("submit", function () {
            if (rememberCheckbox && rememberCheckbox.checked && cedulaInput) {
                const cedulaValue = cedulaInput.value;
                localStorage.setItem("savedUser", cedulaValue);
            }
        });
    }

    if (forgotPasswordLink) {
        forgotPasswordLink.addEventListener("click", function (e) {
            e.preventDefault();
            const el = document.getElementById("forgotPasswordModal");
            if (el) new bootstrap.Modal(el).show();
        });
    }
});

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
    const inputs = [cedulaInput, passwordInput].filter(Boolean);

    inputs.forEach((input) => {
        input.addEventListener("focus", function () {
            if (this.parentElement)
                this.parentElement.classList.add("input-focused");
        });

        input.addEventListener("blur", function () {
            if (this.parentElement)
                this.parentElement.classList.remove("input-focused");
        });
    });

    setupCedulaValidation("cedula");
}

document.addEventListener("DOMContentLoaded", addLoginEffects);
