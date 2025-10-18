document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("toggleTheme");
  const body = document.body;

  if (!toggleBtn) return;

  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "light") {
    body.classList.add("light-mode");
    toggleBtn.textContent = "Dark Mode";
  } else {
    toggleBtn.textContent = "Light Mode";
  }

  toggleBtn.addEventListener("click", () => {
    body.classList.toggle("light-mode");

    if (body.classList.contains("light-mode")) {
      toggleBtn.textContent = "Dark Mode";
      localStorage.setItem("theme", "light");
    } else {
      toggleBtn.textContent = "Light Mode";
      localStorage.setItem("theme", "dark");
    }
  });
});
