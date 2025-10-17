/* admin.css – Styling for admin panel form */

body {
  margin: 0;
  font-family: Arial, sans-serif;
  background: url('bckg.png') no-repeat center center fixed;
  background-size: cover;
  color: #fff;
}

header {
  background-color: rgba(0, 0, 0, 0.7);
  padding: 1rem;
  text-align: center;
}

h1 {
  margin: 0;
  font-size: 2rem;
}

main {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 2rem;
}

form {
  background-color: rgba(0, 0, 0, 0.6);
  padding: 2rem;
  border-radius: 8px;
  width: 100%;
  max-width: 500px;
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
}

form h2 {
  text-align: center;
  margin-bottom: 1.5rem;
  font-size: 1.5rem;
}

label {
  display: block;
  margin-top: 1rem;
  margin-bottom: 0.3rem;
  font-weight: bold;
}

input[type="text"],
input[type="date"],
input[type="file"],
textarea {
  width: 100%;
  padding: 0.6rem;
  border: none;
  border-radius: 4px;
  box-sizing: border-box;
}

textarea {
  resize: vertical;
}

button {
  margin-top: 1.5rem;
  width: 100%;
  padding: 0.8rem;
  background-color: #28a745;
  color: white;
  border: none;
  font-size: 1rem;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #218838;
}

#statusMessage {
  margin-top: 1rem;
  text-align: center;
  font-weight: bold;
}

footer {
  text-align: center;
  padding: 1rem;
  font-size: 0.9rem;
  color: #ddd;
}
