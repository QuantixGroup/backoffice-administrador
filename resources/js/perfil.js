window.Dropzone = window.Dropzone || {};
Dropzone.autoDiscover = false;

document.addEventListener("DOMContentLoaded", function () {
    const dropzoneElement = document.getElementById("profile-image-dropzone");
    const uploadButton = document.querySelector(".image-upload-button");
    let profileImageDropzone = null;

    function initializeDropzone() {
        if (dropzoneElement && !profileImageDropzone) {
            profileImageDropzone = new Dropzone("#profile-image-dropzone", {
                url: "/perfil/upload-image",
                paramName: "profile_image",
                maxFiles: 1,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                autoProcessQueue: true,
                clickable: true,
                createImageThumbnails: true,
                previewTemplate: `
                    <div class="dz-preview dz-file-preview">
                        <div class="dz-image"><img data-dz-thumbnail /></div>
                        <div class="dz-details">
                            <div class="dz-size"><span data-dz-size></span></div>
                            <div class="dz-filename"><span data-dz-name></span></div>
                        </div>
                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                        <div class="dz-success-mark">✓</div>
                        <div class="dz-error-mark">✗</div>
                        <div class="dz-remove" data-dz-remove>Eliminar</div>
                    </div>
                `,
                dictDefaultMessage: "Haz clic o arrastra una imagen aquí",
                dictRemoveFile: "Eliminar",
                dictCancelUpload: "Cancelar",
                dictUploadCanceled: "Subida cancelada",
                dictInvalidFileType: "Solo se permiten archivos de imagen",
                dictFileTooBig: "El archivo es demasiado grande (máximo 2MB)",
                maxFilesize: 2,
                thumbnailWidth: 200,
                thumbnailHeight: 200,
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                init: function () {
                    const dzInstance = this;

                    this.on("success", function (file, response) {
                        if (response.success) {
                            const profileImg = document.getElementById(
                                "current-profile-image"
                            );
                            profileImg.src = response.image_url;

                            showNotification(
                                "Imagen de perfil actualizada correctamente.",
                                "success"
                            );

                            dropzoneElement.style.display = "none";
                            uploadButton.innerHTML =
                                '<i class="fas fa-camera me-2"></i>Cambiar Imagen';

                            setTimeout(() => {
                                dzInstance.removeAllFiles();
                            }, 2000);
                        } else {
                            showNotification(
                                response.message || "Error al subir la imagen",
                                "danger"
                            );
                        }
                    });

                    this.on("error", function (file, errorMessage) {
                        let message = errorMessage;
                        if (typeof errorMessage === "object") {
                            message =
                                errorMessage.message || "Error desconocido";
                        }
                        showNotification(
                            `Error! No se pudo subir la imagen. ${message}`,
                            "danger"
                        );
                    });

                    this.on("sending", function (file, xhr, formData) {});

                    this.on("addedfile", function (file) {});

                    this.on("removedfile", function (file) {});

                    this.on("maxfilesexceeded", function (file) {
                        this.removeFile(file);
                        showNotification(
                            "Solo puedes subir una imagen de perfil a la vez",
                            "warning"
                        );
                    });

                    this.on("dragenter", function () {
                        dropzoneElement.classList.add("dz-drag-hover");
                    });

                    this.on("dragleave", function () {
                        dropzoneElement.classList.remove("dz-drag-hover");
                    });

                    this.on("drop", function () {
                        dropzoneElement.classList.remove("dz-drag-hover");
                    });
                },
            });
        }
    }

    if (uploadButton) {
        uploadButton.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (
                dropzoneElement.style.display === "none" ||
                !dropzoneElement.style.display
            ) {
                if (!profileImageDropzone) {
                    initializeDropzone();
                }

                dropzoneElement.style.display = "block";
                this.innerHTML = '<i class="fas fa-times me-2"></i>Cancelar';

                setTimeout(() => {
                    if (profileImageDropzone) {
                        profileImageDropzone.enable();
                    }
                }, 100);
            } else {
                dropzoneElement.style.display = "none";
                this.innerHTML =
                    '<i class="fas fa-camera me-2"></i>Agregar Imagen';
            }
        });
    }

    const editButton = document.getElementById("edit-profile-btn");
    const saveButton = document.getElementById("save-profile-btn");
    const cancelButton = document.getElementById("cancel-profile-btn");
    const formInputs = document.querySelectorAll(".profile-form input");

    if (editButton) {
        editButton.addEventListener("click", function () {
            formInputs.forEach((input) => {
                if (!input.classList.contains("no-edit")) {
                    input.disabled = false;
                    input.classList.add("editable");
                }
            });

            editButton.style.display = "none";
            saveButton.style.display = "inline-block";
            cancelButton.style.display = "inline-block";
        });
    }

    if (cancelButton) {
        cancelButton.addEventListener("click", function () {
            formInputs.forEach((input) => {
                input.disabled = true;
                input.classList.remove("editable");
            });

            editButton.style.display = "inline-block";
            saveButton.style.display = "none";
            cancelButton.style.display = "none";

            formInputs.forEach((input) => {
                const originalValue = input.getAttribute("data-original-value");
                if (originalValue !== null) {
                    input.value = originalValue;
                }
            });
        });
    }

    if (saveButton) {
        saveButton.addEventListener("click", function () {
            const nombreEl = document.getElementById("nombre");
            const apellidoEl = document.getElementById("apellido");
            const emailEl = document.getElementById("email");
            const telefonoEl = document.getElementById("telefono");
            const fechaEl = document.getElementById("fecha_nacimiento");

            const formData = new FormData();
            formData.append("nombre", nombreEl ? nombreEl.value : "");
            formData.append("apellido", apellidoEl ? apellidoEl.value : "");
            formData.append("email", emailEl ? emailEl.value : "");
            formData.append("telefono", telefonoEl ? telefonoEl.value : "");
            formData.append("fecha_nacimiento", fechaEl ? fechaEl.value : "");

            fetch("/perfil/update", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        formInputs.forEach((input) => {
                            input.disabled = true;
                            input.classList.remove("editable");
                        });

                        editButton.style.display = "inline-block";
                        saveButton.style.display = "none";
                        cancelButton.style.display = "none";

                        showNotification(
                            "Datos guardados correctamente",
                            "success"
                        );
                    } else {
                        throw new Error(
                            data.message || "Error al actualizar el perfil"
                        );
                    }
                })
                .catch((error) => {
                    showNotification(
                        `Error! No se pudo actualizar el perfil. ${error.message}`,
                        "danger"
                    );
                });
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
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
});

function showNotification(message, type) {
    const notification = document.createElement("div");
    notification.className = "success-notification";

    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #28a745;
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
        <i class="fas fa-check-circle" style="margin-right: 0.5rem; font-size: 1.2rem;"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 4000);
}

document.addEventListener("DOMContentLoaded", function () {
    const changePasswordForm = document.getElementById("change-password-form");

    if (changePasswordForm) {
        changePasswordForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            const currentPassword = document.getElementById("current_password");
            const newPassword = document.getElementById("new_password");
            const confirmNewPassword = document.getElementById(
                "confirm_new_password"
            );

            if (!currentPassword || !newPassword || !confirmNewPassword) {
                return;
            }

            const formData = new FormData();
            formData.append("current_password", currentPassword.value);
            formData.append("new_password", newPassword.value);
            formData.append("confirm_new_password", confirmNewPassword.value);

            try {
                const response = await fetch("/perfil/cambiar-password", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        Accept: "application/json",
                    },
                    body: formData,
                });

                const data = await response.json();

                if (data.success) {
                    showNotification(
                        "Contraseña actualizada correctamente",
                        "success"
                    );
                    changePasswordForm.reset();
                    setTimeout(() => {
                        window.location.href = "/";
                    }, 1200);
                } else {
                    showNotification(
                        data.message || "Error al cambiar la contraseña",
                        "danger"
                    );
                }
            } catch (error) {
                showNotification(
                    "Error de conexión al cambiar la contraseña",
                    "danger"
                );
            }
        });
    }
});
