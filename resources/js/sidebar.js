(function () {
    function init() {
        var btn = document.getElementById("sidebarHamburger");
        var sidebar = document.getElementById("mainSidebar");
        if (!btn || !sidebar) return;

        function openSidebar() {
            sidebar.classList.add("open");
            document.body.style.overflow = "hidden";
            if (btn) btn.setAttribute("aria-expanded", "true");
        }
        function closeSidebar() {
            sidebar.classList.remove("open");
            document.body.style.overflow = "";
            if (btn) btn.setAttribute("aria-expanded", "false");
        }

        btn.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (sidebar.classList.contains("open")) closeSidebar();
            else openSidebar();
        });

        document.addEventListener("click", function (e) {
            if (!sidebar.classList.contains("open")) return;
            if (sidebar.contains(e.target) || btn.contains(e.target)) return;
            closeSidebar();
        });

        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" || e.key === "Esc") {
                if (sidebar.classList.contains("open")) closeSidebar();
            }
        });
    }

    if (document.readyState === "loading")
        document.addEventListener("DOMContentLoaded", init);
    else init();
})();
