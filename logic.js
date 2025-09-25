// Sample events data
const events = [
  { id: 1, name: "Tech Fest 2025", date: "2025-10-10", location: "Main Hall", price: "N$50" },
  { id: 2, name: "Cultural Night", date: "2025-10-20", location: "Auditorium", price: "N$30" },
  { id: 3, name: "Sports Gala", date: "2025-11-01", location: "Sports Field", price: "Free" }
];

const eventsList = document.getElementById("events-list");
const myTickets = document.getElementById("my-tickets");

// Render events
function displayEvents() {
  eventsList.innerHTML = "";
  events.forEach(event => {
    const div = document.createElement("div");
    div.classList.add("event-card");
    div.innerHTML = `
      <h3>${event.name}</h3>
      <p><strong>Date:</strong> ${event.date}</p>
      <p><strong>Location:</strong> ${event.location}</p>
      <p><strong>Price:</strong> ${event.price}</p>
      <button onclick="bookTicket(${event.id})">Book Ticket</button>
    `;
    eventsList.appendChild(div);
  });
}

// Book a ticket
function bookTicket(id) {
  const event = events.find(e => e.id === id);
  if (event) {
    const li = document.createElement("li");
    li.textContent = `${event.name} - ${event.date} @ ${event.location}`;
    myTickets.appendChild(li);
    alert(`Ticket booked for ${event.name}`);
  }
}

// Clock
function updateClock() {
  const now = new Date();
  const clock = document.getElementById("clock");
  clock.textContent = now.toLocaleTimeString();
}
setInterval(updateClock, 1000);
updateClock();

// Initialize
displayEvents();


const backgrounds = [
  
  "bckg.png",
  "kE.jpg",
  "one-two.jpg",
  "too.jpg"
];

let currentBg = 0;

function changeBackground() {
  document.body.style.backgroundImage = `url(${backgrounds[currentBg]})`;
  currentBg = (currentBg + 1) % backgrounds.length;
}

// Change every 5 seconds
setInterval(changeBackground, 5000);

// Initialize first background
changeBackground();

