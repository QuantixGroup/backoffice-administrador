(function () {
    const BTN_ID = "darkModeFloatingToggle",
        FA_SEL = 'link[href*="font-awesome"],link[href*="fontawesome"]';
    const setPref = (v) => {
        try {
            localStorage.setItem("darkMode", v ? "true" : "false");
        } catch (e) {}
    };
    const updateIcon = (isDark) => {
        const btn = document.getElementById(BTN_ID);
        if (!btn) return;
        btn.setAttribute("aria-pressed", isDark ? "true" : "false");
        btn.setAttribute(
            "aria-label",
            isDark ? "Activado modo oscuro" : "Activado modo claro"
        );
        btn.title = isDark ? "Activado modo oscuro" : "Activado modo claro";
        let icon = btn.querySelector("i");
        if (!icon) {
            icon = document.createElement("i");
            icon.className = "fa-solid";
            btn.insertBefore(icon, btn.firstChild);
        }
        const hasFA =
            !!document.querySelector(FA_SEL) ||
            icon.classList.contains("fa-solid");
        if (hasFA) {
            icon.classList.toggle("fa-sun", !isDark);
            icon.classList.toggle("fa-moon", !!isDark);
            icon.textContent = "";
        } else {
            icon.className = "";
            icon.textContent = isDark ? "🌙" : "☀️";
        }
    };
    const setDarkMode = (isDark) => {
        document.body.classList.toggle("dark", !!isDark);
        setPref(isDark);
        updateIcon(!!isDark);
    };
    window.toggleDarkMode = () => {
        setDarkMode(!document.body.classList.contains("dark"));
        return document.body.classList.contains("dark");
    };
    function init() {
        let p = null;
        try {
            p = localStorage.getItem("darkMode");
        } catch (e) {}
        if (p === "true" || p === "false") setDarkMode(p === "true");
        else if (
            window.matchMedia &&
            window.matchMedia("(prefers-color-scheme: dark)").matches
        )
            setDarkMode(true);
        const btn = document.getElementById(BTN_ID);
        if (btn && !btn.getAttribute("onclick"))
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                window.toggleDarkMode();
            });
    }
    document.addEventListener("DOMContentLoaded", init);
})();
