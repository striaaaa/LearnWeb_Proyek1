const toggleButton = document.getElementById("toggleButton");
const body = document.body;
const icon = document.getElementById("icon");

toggleButton.addEventListener("click", () => {
  body.classList.toggle("dark");
  if (body.classList.contains("dark")) {
    icon.className = "ri-moon-line";
  } else {
    icon.className = "ri-sun-fill";
  }
});
