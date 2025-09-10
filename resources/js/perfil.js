// Desactivar auto-descubrimiento de Dropzone
window.Dropzone = false;

document.addEventListener("DOMContentLoaded", function () {
    // Configurar Dropzone
    const dropzoneElement = document.getElementById("profile-image-dropzone");
    const uploadButton = document.querySelector(".image-upload-button");
    let profileImageDropzone = null;

    // Función para inicializar Dropzone
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
                        console.log("Upload success:", response);
                        if (response.success) {
                            const profileImg = document.getElementById(
                                "current-profile-image"
                            );
                            profileImg.src = response.image_url;

                            showNotification(
                                "¡Éxito! Imagen de perfil actualizada correctamente.",
                                "success"
                            );

                            // Ocultar dropzone después de subir
                            dropzoneElement.style.display = "none";
                            uploadButton.innerHTML =
                                '<i class="fas fa-camera me-2"></i>Cambiar Imagen';

                            // Limpiar archivos del dropzone
                            setTimeout(() => {
                                dzInstance.removeAllFiles();
                            }, 2000);
                        }
                    });

                    this.on("error", function (file, errorMessage) {
                        console.error("Error uploading file:", errorMessage);
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

                    this.on("removedfile", function (file) {
                        console.log("File removed:", file.name);
                    });

                    this.on("maxfilesexceeded", function (file) {
                        this.removeFile(file);
                        showNotification(
                            "Solo puedes subir una imagen de perfil a la vez",
                            "warning"
                        );
                    });

                    this.on("addedfile", function (file) {
                        console.log("File added:", file.name);
                    });

                    this.on("sending", function (file, xhr, formData) {
                        console.log("Sending file:", file.name);
                    });
                },
            });
        }
    }

    // Manejar clic en botón de subir imagen
    if (uploadButton) {
        uploadButton.addEventListener("click", function (e) {
            e.preventDefault();
            console.log("Upload button clicked");

            if (
                dropzoneElement.style.display === "none" ||
                !dropzoneElement.style.display
            ) {
                dropzoneElement.style.display = "block";
                this.innerHTML = '<i class="fas fa-times me-2"></i>Cancelar';

                // Inicializar Dropzone cuando se muestra
                if (!profileImageDropzone) {
                    initializeDropzone();
                }
            } else {
                dropzoneElement.style.display = "none";
                this.innerHTML =
                    '<i class="fas fa-camera me-2"></i>Agregar Imagen';
            }
        });
    }

    // Funcionalidad de editar perfil
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

            // Resetear valores originales
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
            const formData = new FormData();
            formData.append("nombre", document.getElementById("nombre").value);
            formData.append(
                "apellido",
                document.getElementById("apellido").value
            );
            formData.append("email", document.getElementById("email").value);
            formData.append(
                "telefono",
                document.getElementById("telefono").value
            );
            formData.append(
                "fecha_nacimiento",
                document.getElementById("fecha_nacimiento").value
            );

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
                    console.error("Error:", error);
                    showNotification(
                        `Error! No se pudo actualizar el perfil. ${error.message}`,
                        "danger"
                    );
                });
        });
    }
});

// Función auxiliar para mostrar notificaciones
function showNotification(message, type) {
    // Crear la notificación con el mismo estilo que en socio-detalle
    const notification = document.createElement("div");
    notification.className = "success-notification";

    // Estilos inline para la notificación (usando el mismo estilo verde)
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

    // Agregar icono y mensaje
    notification.innerHTML = `
        <i class="fas fa-check-circle" style="margin-right: 0.5rem; font-size: 1.2rem;"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(notification);

    // Remover después de 4 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 4000);
}
