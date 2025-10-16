class CooperativistaSearcher {
    constructor() {
        this.input = document.getElementById("searchCedula");
        this.clear = document.getElementById("clearSearch");
        this.tabl = document.getElementById("cooperativistasTable");
        this.tbody = this.tabl?.querySelector("tbody");
        if (this.input && this.tbody) {
            this.rows = Array.from(this.tbody.querySelectorAll("tr"));
            this.bind();
        }
    }
    bind() {
        this.input.addEventListener("input", (e) =>
            this.search(e.target.value.trim())
        );
        this.clear.addEventListener("click", (_) => this.reset());
        this.input.addEventListener("keydown", (e) => {
            if (e.key === "Escape") this.reset();
        });
    }
    search(q) {
        if (!q) return this.reset();
        let found = false;
        this.rows.forEach((r) => {
            if (r.querySelector("[colspan]")) {
                r.style.display = "none";
                return;
            }
            const c = r.getAttribute("data-cedula") || "";
            const ok = c.includes(q);
            r.style.display = ok ? "" : "none";
            if (ok) found = true;
        });
        if (!found) this.showNoResults(q);
        else this.hideNoResults();
    }
    reset() {
        this.input.value = "";
        this.rows.forEach((r) => (r.style.display = ""));
        this.hideNoResults();
        this.input.focus();
    }
    showNoResults(q) {
        this.hideNoResults();
        const tr = document.createElement("tr");
        tr.className = "no-results-row";
        tr.innerHTML = `<td colspan="8" class="text-center text-muted py-4"><i class="fas fa-search me-2"></i>No se encontraron cooperativistas con la cédula "<strong>${q}</strong>"</td>`;
        this.tbody.appendChild(tr);
    }
    hideNoResults() {
        const n = this.tbody.querySelector(".no-results-row");
        if (n) n.remove();
    }
}

let rowSelector;
document.addEventListener("DOMContentLoaded", () => {
    new CooperativistaSearcher();
    rowSelector = new TableRowSelector(
        ".table-row-selectable",
        "abrirDetalleBtn",
        "cedula"
    );
    if (!document.getElementById("cooperativistasTable")) {
        window.abrirDetalle = () => {
            const v = rowSelector?.getSelectedValue();
            if (v) window.location.href = `/socios/${v}/detalle`;
        };
    }
});
