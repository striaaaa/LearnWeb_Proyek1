
// MOBILE MENU TOGGLE
function toggleMobile() {
    const m = document.getElementById("mobileMenu");
    m.style.display = (m.style.display === "flex") ? "none" : "flex";
}

document.addEventListener("DOMContentLoaded", function () {

    // redirect button[data-link]
    document.querySelectorAll("button[data-link]").forEach(btn => {
        btn.addEventListener("click", () => {
            window.location.href = btn.dataset.link;
        });
    });

    // -----------------------------
    // DESKTOP PROFILE DROPDOWN
    // -----------------------------
    const profileBtn = document.getElementById("profileMenuBtn");
    const dropdown = document.getElementById("profileDropdown");

    if (profileBtn) {
        profileBtn.addEventListener("click", () => {
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        });

        // klik di luar → close
        document.addEventListener("click", function (e) {
            if (!profileBtn.contains(e.target)) dropdown.style.display = "none";
        });
    }

    // -----------------------------
    // DARK MODE DESKTOP + MOBILE
    // -----------------------------
    let theme = localStorage.getItem("theme") || "light";

    const iconDesktop = document.getElementById("iconDesktop");
    const toggleDesktop = document.getElementById("toggleButtonDesktop");

    const iconMobile = document.getElementById("iconMobile");
    const toggleMobileBtn = document.getElementById("toggleButtonMobile");

    function applyTheme() {
        const isDark = theme === "dark";
        document.documentElement.classList.toggle("dark", isDark);

        if (iconDesktop) iconDesktop.className = isDark ? "ri-moon-fill" : "ri-sun-fill";
        if (iconMobile) iconMobile.className = isDark ? "ri-moon-fill" : "ri-sun-fill";
    }

    applyTheme();

    function toggleTheme() {
        theme = theme === "dark" ? "light" : "dark";
        localStorage.setItem("theme", theme);
        applyTheme();
    }

    if (toggleDesktop) toggleDesktop.addEventListener("click", toggleTheme);
    if (toggleMobileBtn) toggleMobileBtn.addEventListener("click", toggleTheme);

});