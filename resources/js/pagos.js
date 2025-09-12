let rowSelector;

document.addEventListener("DOMContentLoaded", function () {
    rowSelector = new TableRowSelector(
        ".recibo-row",
        "abrirReciboBtn",
        "cooperativista"
    );
});

function abrirRecibo() {
    const selectedValue = rowSelector?.getSelectedValue();
    openRecibo(selectedValue, "recibos-detalle-url");
}

window.abrirRecibo = abrirRecibo;
