// Ganti konten tanpa reload
const navLinks = document.querySelectorAll(".nav-linkk");
const sections = document.querySelectorAll(".card");

navLinks.forEach((link) => {
  link.addEventListener("click", () => {
    navLinks.forEach((l) => l.classList.remove("active"));
    link.classList.add("active");

    const target = link.getAttribute("data-target");
    sections.forEach((sec) => {
      sec.classList.add("hidden");
      if (sec.id === target) sec.classList.remove("hidden");
    });
  });
});

// Preview foto profil
function previewFoto(event) {
  const preview = document.getElementById("preview");
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      preview.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
}
