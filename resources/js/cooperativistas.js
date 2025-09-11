class CooperativistasManager {
    constructor() {
        this.cooperativistaSeleccionado = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.bindRecibosEvents();
        this.setupChannels();
    }

    bindEvents() {
        document.addEventListener("click", (e) => {
            if (e.target.matches(".btn-aprobar, .btn-aprobar *")) {
                e.preventDefault();
                const button = e.target.closest(".btn-aprobar");
                if (button) {
                    this.aprobarSocio(button);
                }
            }
        });
    }

    bindRecibosEvents() {
        const table = document.querySelector("#recibosTable");
        const btnAbrir = document.getElementById("abrirReciboBtn");

        if (!table) return;

        let cooperativistaSeleccionado = null;

        table.addEventListener("click", function (e) {
            const row = e.target.closest("tr");

            if (row && row.parentNode.tagName.toLowerCase() === "tbody") {
                table.querySelectorAll("tbody tr").forEach((tr) => {
                    tr.classList.remove("table-primary", "selected");
                });

                row.classList.add("table-primary", "selected");

                cooperativistaSeleccionado = row.getAttribute(
                    "data-cooperativista"
                );

                if (btnAbrir && cooperativistaSeleccionado) {
                    btnAbrir.disabled = false;
                }
            }
        });

        window.abrirRecibo = function () {
            if (cooperativistaSeleccionado) {
                alert(
                    "Abriendo recibos para cooperativista: " +
                        cooperativistaSeleccionado
                );
            } else {
                alert("Por favor, selecciona un cooperativista primero");
            }
        };
    }

    async aprobarSocio(button) {
        const cedula = button.dataset.cedula;
        const form = button.closest("form");

        if (!cedula || !form) {
            console.error("No se encontró la cédula");
            return;
        }

        button.disabled = true;
        const originalText = button.innerHTML;
        button.innerHTML =
            '<i class="fas fa-spinner fa-spin"></i> Procesando datos...';

        try {
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "",
                },
            });

            const data = await response.json();

            if (data.success) {
                this.removerDeTablaPendientes(cedula);

                this.agregarATablasAprobados(data.socio);

                this.mostrarNotificacion(
                    "Usuario aprobado con éxito",
                    "success"
                );

                this.actualizarContadores();
            } else {
                throw new Error(data.message || "Error al aprobar usuario");
            }
        } catch (error) {
            console.error("Error:", error);
            this.mostrarNotificacion(
                error.message || "Error al procesar la solicitud",
                "error"
            );

            button.disabled = false;
            button.innerHTML = originalText;
        }
    }

    removerDeTablaPendientes(cedula) {
        const filaPendiente = document.querySelector(
            `tr[data-cedula="${cedula}"]`
        );
        if (filaPendiente) {
            filaPendiente.style.transition = "opacity 0.3s ease";
            filaPendiente.style.opacity = "0";
            setTimeout(() => {
                filaPendiente.remove();
            }, 300);
        }
    }

    agregarATablasAprobados(socio) {
        this.agregarATablaCooperativistas(socio);

        this.agregarATablaRecibos(socio);
    }

    agregarATablaCooperativistas(socio) {
        const tablaCooperativistas = document.querySelector(".table tbody");

        if (
            tablaCooperativistas &&
            window.location.pathname.includes("pendientes")
        ) {
            const filaExistente = tablaCooperativistas.querySelector(
                `tr[data-cedula="${socio.cedula}"]`
            );
            if (filaExistente) return;

            const nuevaFila = document.createElement("tr");
            nuevaFila.dataset.cedula = socio.cedula;
            nuevaFila.innerHTML = `
                <td>${socio.nombre || "N/A"}</td>
                <td>${socio.apellido || "N/A"}</td>
                <td>${socio.cedula || "N/A"}</td>
                <td>${socio.telefono || "N/A"}</td>
                <td>${socio.email || "N/A"}</td>
                <td>${socio.updated_at || "N/A"}</td>
                <td>${
                    socio.estado_pago_badge ||
                    '<span class="badge bg-secondary">Pendiente</span>'
                }</td>
                <td>${
                    socio.horas_trabajadas_badge ||
                    '<span class="badge bg-info">40 hrs</span>'
                }</td>
            `;

            nuevaFila.style.opacity = "0";
            nuevaFila.style.transition = "opacity 0.3s ease";
            tablaCooperativistas.appendChild(nuevaFila);

            setTimeout(() => {
                nuevaFila.style.opacity = "1";
            }, 100);
        }
    }

    agregarATablaRecibos(socio) {
        const tablaRecibos = document
            .querySelector(".recibo-row")
            ?.closest("tbody");

        if (tablaRecibos) {
            const filaExistente = tablaRecibos.querySelector(
                `tr[data-cooperativista="${socio.cedula}"]`
            );
            if (filaExistente) return;

            const nuevaFila = document.createElement("tr");
            nuevaFila.className = "recibo-row";
            nuevaFila.dataset.cooperativista = socio.cedula;
            nuevaFila.innerHTML = `
                <td>${socio.nombre || "N/A"}</td>
                <td>${socio.apellido || "N/A"}</td>
                <td>${socio.cedula || "N/A"}</td>
                <td>${socio.telefono || "N/A"}</td>
                <td>${socio.email || "N/A"}</td>
                <td>${
                    socio.horas_trabajadas_badge ||
                    '<span class="badge bg-info">40 hrs</span>'
                }</td>
                <td>${
                    socio.estado_pago_badge ||
                    '<span class="badge bg-secondary">Pendiente</span>'
                }</td>
            `;

            nuevaFila.style.opacity = "0";
            nuevaFila.style.transition = "opacity 0.3s ease";
            tablaRecibos.appendChild(nuevaFila);

            setTimeout(() => {
                nuevaFila.style.opacity = "1";
            }, 100);

            this.bindRecibosRowEvents(nuevaFila);
        }
    }

    bindRecibosRowEvents(fila) {
        fila.addEventListener("click", function () {
            document.querySelectorAll(".recibo-row.selected").forEach((row) => {
                row.classList.remove("selected");
            });

            this.classList.add("selected");

            const btnAbrir = document.getElementById("abrirReciboBtn");
            if (btnAbrir) {
                btnAbrir.disabled = false;
            }

            if (window.cooperativistaSeleccionado !== undefined) {
                window.cooperativistaSeleccionado = this.dataset.cooperativista;
            }
        });
    }

    mostrarNotificacion(mensaje, tipo = "info") {
        const toast = document.createElement("div");
        toast.className = `alert alert-${
            tipo === "success" ? "success" : "danger"
        } position-fixed top-0 end-0 m-3`;
        toast.style.zIndex = "9999";
        toast.innerHTML = `
            <i class="fas fa-${
                tipo === "success" ? "check-circle" : "exclamation-circle"
            }"></i>
            ${mensaje}
            <button type="button" class="btn-close" aria-label="Close"></button>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = "0";
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 5000);

        toast.querySelector(".btn-close")?.addEventListener("click", () => {
            toast.style.opacity = "0";
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        });
    }

    actualizarContadores() {
        const contadorPendientes = document.querySelector(".badge-counter");
        if (contadorPendientes) {
            const count = parseInt(contadorPendientes.textContent) - 1;
            contadorPendientes.textContent = Math.max(0, count);

            if (count === 0) {
                contadorPendientes.style.display = "none";
            }
        }
    }

    setupChannels() {}
}

document.addEventListener("DOMContentLoaded", function () {
    new CooperativistasManager();
});

window.CooperativistasManager = CooperativistasManager;
