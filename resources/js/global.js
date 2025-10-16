const showSuccessNotification = (m, d = 4e3) => {
    const n = document.getElementById("successNotification"),
        t = document.getElementById("successMessage");
    if (n && t) {
        t.textContent = m;
        n.style.display = "block";
        setTimeout(() => (n.style.display = "none"), d);
    }
};
class TableRowSelector {
    constructor(s, b, a = "cooperativista") {
        this.tableSelector = s;
        const t = document.querySelector(s);
        this.table = t
            ? t.tagName && t.tagName.toLowerCase() === "table"
                ? t
                : t.closest && t.closest("table")
                ? t.closest("table")
                : document.querySelector("table")
            : document.querySelector("table");
        this.button = document.getElementById(b) || null;
        this.selectedValue = null;
        this.dataAttribute = a;
        if (this.table) this.bindEvents();
    }
    bindEvents() {
        if (!this.table) return;
        this.table.addEventListener("click", (e) => {
            const r = e.target.closest("tr");
            if (
                r &&
                r.parentNode &&
                r.parentNode.tagName.toLowerCase() === "tbody" &&
                r.closest &&
                r.closest("table") === this.table
            )
                this.selectRow(r);
        });
    }
    selectRow(r) {
        this.clearSelection();
        r.classList.add("selected", "table-primary");
        this.selectedValue =
            r.dataset[this.dataAttribute] ||
            r.getAttribute(`data-${this.dataAttribute}`);
        if (this.selectedValue && this.button) this.button.disabled = false;
    }
    clearSelection() {
        this.table
            .querySelectorAll("tbody tr.table-row-selectable")
            .forEach((r) => r.classList.remove("selected", "table-primary"));
        this.selectedValue = null;
        if (this.button) this.button.disabled = true;
    }
    getSelectedValue() {
        return this.selectedValue;
    }
}
const openRecibo = (
    v,
    meta = "recibos-detalle-url",
    fb = "/recibos/detalle"
) => {
    if (!v) {
        alert("Por favor, seleccione un cooperativista primero");
        return;
    }
    const base =
        document
            .querySelector(`meta[name="${meta}"]`)
            ?.getAttribute("content") || fb;
    window.location.href = `${base}?documento=${v}`;
};
window.showSuccessNotification = showSuccessNotification;
window.TableRowSelector = TableRowSelector;
window.openRecibo = openRecibo;
