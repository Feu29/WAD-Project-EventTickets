# 🎟️ WAD Project – Event Tickets

Hi! This is a simple event ticketing web app I built as part of a Web Application Development (WAD) project. The goal was to create a basic system where admins can add events (with images), and users can view them.

It uses PHP and MySQL on the backend, and standard HTML, CSS, and JavaScript on the frontend. I'm running it locally with XAMPP.

---

## 🚀 What It Does

- Admins can add new events using a form (title, date, location, description, and image)
- Events are saved into a MySQL database and images are uploaded to a local folder
- Users can view a list of events on the main page
- The UI is kept simple and responsive

---

## 🗂️ File Overview

- `add_event.php` – handles the form submission and uploads event data + image
- `get_events.php` – fetches all events from the database as JSON
- `admin.html` – the admin panel where events can be added
- `main.html` – the main page where users can see the events
- `uploads/` – stores uploaded images
- `db_connect.php` – sets up the MySQL connection
- Other files: JavaScript (`main.js`, `logic.js`, etc.) and stylesheets for UI

---

## 🛠️ Tech Stack

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL (via XAMPP)
- **Dev Environment**: XAMPP (Apache + MySQL)

---

## 🧪 How to Run It Locally

1. Clone this repo or download the ZIP
2. Open XAMPP and start Apache + MySQL
3. Create a database called `event_db` and import the SQL structure (I'll add this soon if it's not there!)
4. Place the project folder inside `htdocs/`
5. Visit `http://localhost/WAD-Project-EventTickets/admin.html` to add events
6. Go to `main.html` to view them

---

## 🧑‍💻 Made By
- @Phill210
- @Feu29  
- @KAFKA-311

---

## 📸 Screenshots

*(Will add UI screenshots soon to show what the admin and main pages look like)*

---

Thanks for checking this out! Still improving it, but it works for now.
