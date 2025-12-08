document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("button[data-link]").forEach(btn => {
  btn.addEventListener("click", () => {
    window.location.href = btn.dataset.link;
  });
});
    const toggleBtn = document.getElementById("toggleButton");
    const icon = document.getElementById("icon");

    // 1. cek preferensi user
    let theme = localStorage.getItem("theme") || "light";

    // 2. apply saat page load
    if (theme === "dark") {
        document.documentElement.classList.add("dark");
        icon.classList.remove("ri-sun-fill");
        icon.classList.add("ri-moon-fill");
    }

    // 3. toggle
    toggleBtn.addEventListener("click", function () {
        console.log('es');
        
        document.documentElement.classList.toggle("dark");

        const isDark = document.documentElement.classList.contains("dark");

        if (isDark) {
            icon.classList.remove("ri-sun-fill");
            icon.classList.add("ri-moon-fill");
            localStorage.setItem("theme", "dark");
        } else {
            icon.classList.remove("ri-moon-fill");
            icon.classList.add("ri-sun-fill");
            localStorage.setItem("theme", "light");
        }
    });
});
