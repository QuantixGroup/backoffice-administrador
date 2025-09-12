function showSuccessNotification(message, duration = 4000) {
    const notification = document.getElementById("successNotification");
    const messageElement = document.getElementById("successMessage");

    if (notification && messageElement) {
        messageElement.textContent = message;
        notification.style.display = "block";

        setTimeout(() => {
            notification.style.display = "none";
        }, duration);
    }
}

class TableRowSelector {
    constructor(
        tableSelector,
        buttonSelector,
        dataAttribute = "cooperativista"
    ) {
        this.table = document.querySelector(tableSelector);
        this.button = document.getElementById(buttonSelector);
        this.selectedValue = null;
        this.dataAttribute = dataAttribute;

        if (this.table && this.button) {
            this.init();
        }
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        this.table.addEventListener("click", (e) => {
            const row = e.target.closest("tr, .recibo-row");

            if (row && this.isSelectableRow(row)) {
                this.selectRow(row);
            }
        });
    }

    isSelectableRow(row) {
        if (row.tagName.toLowerCase() === "tr") {
            return row.parentNode.tagName.toLowerCase() === "tbody";
        }
        return row.classList.contains("recibo-row");
    }

    selectRow(row) {
        this.clearSelection();
        row.classList.add("table-primary", "selected");
        this.selectedValue =
            row.dataset[this.dataAttribute] ||
            row.getAttribute(`data-${this.dataAttribute}`);

        if (this.selectedValue) {
            this.button.disabled = false;
        }
    }

    clearSelection() {
        const allRows = this.table.querySelectorAll("tr, .recibo-row");
        allRows.forEach((row) => {
            row.classList.remove("table-primary", "selected");
        });
    }

    getSelectedValue() {
        return this.selectedValue;
    }
}

function openRecibo(
    selectedValue,
    baseUrlMetaName = "recibos-detalle-url",
    fallbackUrl = "/recibos/detalle"
) {
    if (!selectedValue) {
        alert("Por favor, seleccione un cooperativista primero");
        return;
    }

    const baseUrl =
        document
            .querySelector(`meta[name="${baseUrlMetaName}"]`)
            ?.getAttribute("content") || fallbackUrl;

    window.location.href = `${baseUrl}?documento=${selectedValue}`;
}

window.showSuccessNotification = showSuccessNotification;
window.TableRowSelector = TableRowSelector;
window.openRecibo = openRecibo;
