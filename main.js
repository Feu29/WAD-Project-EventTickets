async function loadEvents() {
  const container = document.getElementById("events-container");

  try {
    const response = await fetch("get_events.php");
    const events = await response.json();

    if (events.length === 0) {
      container.innerHTML = "<p>No events available right now.</p>";
      return;
    }

    container.innerHTML = ""; // Clear previous content

    events.forEach(event => {
      const card = document.createElement("div");
      card.className = "event-card";

      card.innerHTML = `
        <img src="${event.image_path}" alt="${event.event_name}">
        <h3>${event.event_name}</h3>
        <p><strong>Date:</strong> ${event.event_date}</p>
        <p>${event.description}</p>
        <button>Get Ticket</button>
      `;

      container.appendChild(card);
    });
  } catch (error) {
    container.innerHTML = "<p style='color:red;'>⚠️ Failed to load events.</p>";
    console.error("Error loading events:", error);
  }
}

loadEvents();
