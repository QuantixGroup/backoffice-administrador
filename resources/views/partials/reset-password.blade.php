<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="forgotPasswordModalLabel">Recuperar Contraseña</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="forgotPasswordForm">
                    <div class="mb-3">
                        <label for="emailRecovery" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailRecovery" placeholder="Ingrese su email"
                            required>
                        <div class="form-text">Recibirá un enlace en su email para restablecer la contraseña.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn-send" id="sendRecoveryButton">Enviar</button>
            </div>
        </div>
    </div>
</div>