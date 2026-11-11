document.addEventListener("DOMContentLoaded", () => {
    // Mobile navigation menu.
    // Search, filters and form validation now run on the server in PHP.
    document.querySelectorAll(".menu-toggle").forEach((toggle) => {
        const nav = toggle.parentElement.querySelector(".nav-links");
        if (!nav) return;
        const setOpen = (open) => {
            nav.classList.toggle("open", open);
            toggle.setAttribute("aria-expanded", String(open));
            toggle.setAttribute("aria-label", open ? "Мәзірді жабу" : "Мәзірді ашу");
        };
        toggle.addEventListener("click", () => setOpen(!nav.classList.contains("open")));
        nav.querySelectorAll("a").forEach((link) => link.addEventListener("click", () => setOpen(false)));
    });
});
