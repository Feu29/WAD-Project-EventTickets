const form = document.getElementById("eventForm");
const statusMessage = document.getElementById("statusMessage");

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const formData = new FormData(form);

  try {
    const response = await fetch("db_connect.php", {
      method: "POST",
      body: formData,
    });

    const text = await response.text();

    if (response.ok && text.includes("success")) {
      statusMessage.style.color = "lightgreen";
      statusMessage.textContent = "✅ Event added successfully!";
      form.reset();
    } else {
      statusMessage.style.color = "red";
      statusMessage.textContent = "❌ Failed to add event: " + text;
    }
  } catch (error) {
    statusMessage.style.color = "red";
    statusMessage.textContent = "⚠️ Error connecting to server.";
    console.error(error);
  }
});
fetch("http://localhost/EventTicket-PROJECT/add_event.php", {
  method: "POST",
  body: formData
});
