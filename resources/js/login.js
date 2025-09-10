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
        showForgotPasswordModal();
    });
});

function showForgotPasswordModal() {
    const modalHTML = `
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgotPasswordModalLabel">Recuperar Contraseña</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="forgotPasswordForm">
                            <div class="mb-3">
                                <label for="emailRecovery" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="emailRecovery" placeholder="Ingrese su correo electrónico" required>
                                <div class="form-text">Recibirá un enlace para restablecer su contraseña en este correo.</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="sendRecoveryEmail()">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    if (!document.getElementById("forgotPasswordModal")) {
        document.body.insertAdjacentHTML("beforeend", modalHTML);
    }

    const modal = new bootstrap.Modal(
        document.getElementById("forgotPasswordModal")
    );
    modal.show();
}

function sendRecoveryEmail() {
    const email = document.getElementById("emailRecovery").value;

    if (!email) {
        alert("Por favor ingrese su correo electrónico");
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Por favor ingrese un correo electrónico válido");
        return;
    }

    // Aquí puedes enviar la petición AJAX al servidor
    // Por ahora simularemos el envío
    const sendButton = document.querySelector(
        "#forgotPasswordModal .btn-primary"
    );
    const originalText = sendButton.textContent;

    sendButton.disabled = true;
    sendButton.textContent = "Enviando...";

    setTimeout(() => {
        alert(
            "Se ha enviado un enlace de recuperación a su correo electrónico"
        );

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
