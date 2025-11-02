let rowSelector;

document.addEventListener("DOMContentLoaded", function () {
    rowSelector = new TableRowSelector(
        ".table-row-selectable",
        "abrirReciboBtn",
        "cooperativista"
    );

    initRecibosEstadoManager();
});

function abrirRecibo() {
    const selectedValue = rowSelector?.getSelectedValue();
    openRecibo(selectedValue, "recibos-detalle-url");
}

function initRecibosEstadoManager() {
    const selects = document.querySelectorAll(".estado-select");
    const guardarBtn = document.getElementById("guardarCambiosBtn");

    if (!guardarBtn) return;

    const cambiosPendientes = new Map();
    const originalBtnText = guardarBtn.textContent.trim();

    selects.forEach((select) => {
        select.addEventListener("change", function () {
            const idPago = this.dataset.id;
            const nuevoEstado = this.value;
            const estadoOriginal = this.dataset.originalEstado;

            if (nuevoEstado !== estadoOriginal) {
                cambiosPendientes.set(idPago, {
                    nuevoEstado: nuevoEstado,
                    select: this,
                });
            } else {
                cambiosPendientes.delete(idPago);
            }

            if (cambiosPendientes.size > 0) {
                guardarBtn.disabled = false;
            } else {
                guardarBtn.disabled = true;
            }
        });
    });

    guardarBtn.addEventListener("click", async function () {
        if (cambiosPendientes.size === 0) return;

        guardarBtn.disabled = true;

        let todosExitosos = true;
        let contadorExitosos = 0;

        for (const [idPago, data] of cambiosPendientes.entries()) {
            try {
                const response = await fetch(
                    `/recibos/actualizar-estado/${idPago}`,
                    {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": getCsrfToken(),
                        },
                        body: JSON.stringify({
                            estado: data.nuevoEstado,
                        }),
                    }
                );

                const responseData = await response.json();

                if (response.ok && responseData.success) {
                    data.select.dataset.originalEstado = data.nuevoEstado;
                    contadorExitosos++;
                } else {
                    todosExitosos = false;
                    data.select.value = data.select.dataset.originalEstado;
                }
            } catch (error) {
                todosExitosos = false;
                data.select.value = data.select.dataset.originalEstado;
            }
        }

        cambiosPendientes.clear();

        guardarBtn.disabled = true;

        if (todosExitosos && contadorExitosos > 0) {
            const mensaje =
                contadorExitosos === 1
                    ? "Pago aceptado con éxito"
                    : `${contadorExitosos} pagos actualizados con éxito`;
            showSuccessNotification(mensaje);
        } else if (contadorExitosos > 0) {
            showSuccessNotification(
                `${contadorExitosos} pagos actualizados. Algunos cambios no se pudieron guardar.`
            );
        } else {
            showSuccessNotification(
                "No se pudo actualizar ningún pago. Por favor, inténtelo de nuevo."
            );
        }
    });
}

window.abrirRecibo = abrirRecibo;
