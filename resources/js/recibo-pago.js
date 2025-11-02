let rowSelector;

document.addEventListener("DOMContentLoaded", () => {
    const modalEl = document.getElementById("modalReciboDetalle");
    if (!modalEl) return;
    const modal = new bootstrap.Modal(modalEl);
    const $ = (s) => document.querySelector(s);
    const getData = (el, k) => el?.dataset[k] || "";

    rowSelector = new TableRowSelector(
        ".table-row-selectable",
        "btnAbrirRecibo",
        "recibo"
    );

    $("#btnAbrirRecibo")?.addEventListener("click", () => {
        const id = rowSelector?.getSelectedValue();
        const row = id && $(`tr[data-recibo="${id}"]`);
        if (!row) return;

        $("#modalReciboNumero").textContent = getData(row, "numero");
        $("#modalMonto").value = getData(row, "monto");
        $("#modalEstado").value = getData(row, "estado") || "pendiente";
        $("#modalObservacion").value = getData(row, "observacion");
        $("#modalReciboId").value = getData(row, "reciboId");
        $("#pdfViewer").src = `/recibos/pdf/${getData(row, "reciboId")}`;
        modal.show();
    });

    $("#btnGuardar")?.addEventListener("click", async () => {
        const modalReciboId = document.getElementById("modalReciboId");
        const modalEstado = document.getElementById("modalEstado");
        const modalObservacion = document.getElementById("modalObservacion");
        const id = modalReciboId ? modalReciboId.value : null;
        const estado = modalEstado ? modalEstado.value : null;
        const observacion = modalObservacion
            ? modalObservacion.value || ""
            : "";

        if (estado === "rechazado" && !observacion.trim())
            return alert("Tiene que ingresar el motivo del rechazo del pago");

        try {
            const res = await fetch(`/recibos/actualizar-estado/${id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": getCsrfToken(),
                },
                body: JSON.stringify({ estado, observacion }),
            });

            const data = await res.json();
            if (!data.success)
                return alert(data.message || "Error al actualizar");

            const row = $(
                `tr[data-recibo="${rowSelector?.getSelectedValue()}"]`
            );
            if (row) {
                const badge = row.querySelector(".badge");
                const classes = {
                    aceptado: "bg-success",
                    rechazado: "bg-danger",
                    pendiente: "bg-warning",
                };
                const texts = {
                    aceptado: "Aceptado",
                    rechazado: "Rechazado",
                    pendiente: "Pendiente",
                };

                if (badge) {
                    badge.className = `badge ${classes[estado]}`;
                    badge.textContent = texts[estado];
                }
                row.dataset.estado = estado;
                row.dataset.observacion = observacion;
                row.classList.remove("table-primary", "selected");
            }

            const notif = $("#successNotification");
            if (notif) {
                $("#successMessage").textContent =
                    "Estado actualizado correctamente";
                notif.style.display = "block";
                setTimeout(() => (notif.style.display = "none"), 3000);
            }

            modal.hide();
            rowSelector?.clearSelection();
            $("#btnAbrirRecibo").disabled = true;
        } catch (e) {}
    });
});
