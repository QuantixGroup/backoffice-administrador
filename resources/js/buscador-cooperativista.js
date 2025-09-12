class CooperativistaSearcher {
    constructor() {
        this.searchInput = document.getElementById("searchCedula");
        this.clearButton = document.getElementById("clearSearch");
        this.searchResults = document.getElementById("searchResults");
        this.table = document.getElementById("cooperativistasTable");
        this.tbody = this.table?.querySelector("tbody");
        this.allRows = [];
        this.visibleCount = 0;
        this.totalCount = 0;

        if (this.searchInput && this.table) {
            this.init();
        }
    }

    init() {
        this.allRows = Array.from(this.tbody.querySelectorAll("tr"));
        this.totalCount = this.allRows.filter(
            (row) => !row.querySelector("[colspan]")
        ).length;
        this.visibleCount = this.totalCount;

        this.bindEvents();
    }

    bindEvents() {
        this.searchInput.addEventListener("input", (e) => {
            this.performSearch(e.target.value.trim());
        });

        this.clearButton.addEventListener("click", () => {
            this.clearSearch();
        });

        this.searchInput.addEventListener("keypress", (e) => {
            const char = String.fromCharCode(e.which);
            if (!/[0-9]/.test(char)) {
                e.preventDefault();
            }
        });

        this.searchInput.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                this.clearSearch();
            }
        });
    }

    performSearch(searchTerm) {
        if (!searchTerm) {
            this.showAllRows();
            return;
        }

        let foundRows = [];
        let hasResults = false;

        this.allRows.forEach((row) => {
            if (row.querySelector("[colspan]")) {
                row.style.display = "none";
                return;
            }

            const cedula = row.getAttribute("data-cedula") || "";

            if (cedula.includes(searchTerm)) {
                row.style.display = "";
                foundRows.push(row);
                hasResults = true;
            } else {
                row.style.display = "none";
            }
        });

        this.visibleCount = foundRows.length;
        this.updateResultsDisplay(searchTerm);

        if (!hasResults) {
            this.showNoResultsMessage(searchTerm);
        } else {
            this.hideNoResultsMessage();
        }
    }

    showAllRows() {
        this.allRows.forEach((row) => {
            if (row.classList.contains("no-results-row")) {
                row.style.display = "none";
            } else if (
                !row.querySelector("[colspan]") ||
                row.classList.contains("empty-message-row")
            ) {
                row.style.display = "";
            }
        });

        this.visibleCount = this.totalCount;
        this.updateResultsDisplay();
    }

    showNoResultsMessage(searchTerm) {
        this.hideNoResultsMessage();

        const noResultsRow = document.createElement("tr");
        noResultsRow.classList.add("no-results-row");
        noResultsRow.innerHTML = `
            <td colspan="8" class="text-center text-muted py-4">
                <i class="fas fa-search me-2"></i>
                No se encontraron cooperativistas con la cédula "<strong>${searchTerm}</strong>"
            </td>
        `;

        this.tbody.appendChild(noResultsRow);
    }

    hideNoResultsMessage() {
        const noResultsRow = this.tbody.querySelector(".no-results-row");
        if (noResultsRow) {
            noResultsRow.remove();
        }
    }

    clearSearch() {
        this.searchInput.value = "";
        this.searchInput.focus();
        this.showAllRows();
    }

    updateResultsDisplay(searchTerm = "") {
        if (!this.searchResults) return;
        this.searchResults.innerHTML = "";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    new CooperativistaSearcher();
});
