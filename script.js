const toggleButton = document.getElementById("toggleButton");
const body = document.body;
const icon = document.getElementById("icon");

// Event listener for the toggle button
toggleButton.addEventListener("click", () => {
  body.classList.toggle("dark");
  if (body.classList.contains("dark")) {
    icon.className = "ri-moon-line"; // Change to moon icon
  } else {
    icon.className = "ri-sun-fill"; // Change to sun icon using Font Awesome
  }
});
