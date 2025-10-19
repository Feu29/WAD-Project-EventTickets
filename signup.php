<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up | University Events</title>
  <link rel="stylesheet" href="style1.css">
</head>
<body>
  <div class="login-container">
    <h2>🎟️ Sign Up</h2>
    
    <?php
    if(isset($_SESSION['error'])) {
        echo "<p class='error'>".$_SESSION['error']."</p>";
        unset($_SESSION['error']);
    }
    if(isset($_SESSION['success'])) {
        echo "<p class='success'>".$_SESSION['success']."</p>";
        unset($_SESSION['success']);
    }
    ?>
    
    <form action="signup_process.php" method="POST">
      <label>Name</label>
      <input type="text" name="name" placeholder="Your full name" required>

      <label>Email</label>
      <input type="email" name="email" placeholder="you@example.com" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter password" required>

      <label>Confirm Password</label>
      <input type="password" name="confirm_password" placeholder="Confirm password" required>

      <button type="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="logIn.php">Login</a></p>
  </div>
</body>
</html>
