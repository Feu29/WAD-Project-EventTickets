// ⏰ CLOCK FUNCTION 
function updateClock() {
  const clock = document.getElementById("clock");
  const now = new Date();
  const hours = now.getHours().toString().padStart(2, "0");
  const minutes = now.getMinutes().toString().padStart(2, "0");
  const seconds = now.getSeconds().toString().padStart(2, "0");
  clock.textContent = `${hours}:${minutes}:${seconds}`;
}
setInterval(updateClock, 1000);
updateClock();

// 🎟️ LOAD EVENTS FROM DATABASE
async function loadEvents() {
  const container = document.getElementById("events-container");

  try {
    const response = await fetch("events.php");

    if (!response.ok) {
      throw new Error(`Server error: ${response.status}`);
    }

    const events = await response.json();

    if (!Array.isArray(events) || events.length === 0) {
      container.innerHTML = "<p>No events available right now.</p>";
      return;
    }

    container.innerHTML = "";

    events.forEach(event => {
      const card = document.createElement("div");
      card.className = "event-card";

      card.innerHTML = `
        <img src="${event.image_path}" alt="${event.event_name}" class="event-image">
        <h3>${event.event_name}</h3>
        <p><strong>Date:</strong> ${event.event_date}</p>
        <p>${event.description}</p>
        <form method="POST" action="book.php">
          <input type="hidden" name="event_id" value="${event.id}">
          <button type="submit" class="book-btn">Book Seat</button>
        </form>
      `;
      container.appendChild(card);
    });
  } catch (error) {
    console.error("Error loading events:", error);
    container.innerHTML = "<p style='color:red;'>⚠️ Failed to load events.</p>";
  }
}

document.addEventListener("DOMContentLoaded", loadEvents);

// 🌙 DARK/LIGHT MODE TOGGLE
const themeButton = document.getElementById("toggleTheme");

// Load saved theme from localStorage
if (localStorage.getItem("theme") === "dark") {
  document.body.classList.add("dark-mode");
  themeButton.textContent = "Dark Mode";
}

// Toggle theme
themeButton.addEventListener("click", () => {
  document.body.classList.toggle("dark-mode");

  if (document.body.classList.contains("dark-mode")) {
    themeButton.textContent = "Dark Mode";
    localStorage.setItem("theme", "dark");
  } else {
    themeButton.textContent = "Light Mode";
    localStorage.setItem("theme", "light");
  }
});
