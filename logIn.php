
<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In</title>
  <link rel="stylesheet" href="style1.css">
</head>
<body>
  <div class="header">
    <img src="logo.png" alt="logo" width="120">
    <ul>
      <li><a href="signup.php">SignUp</a></li
      <li><a href="#">Help</a></li>
    </ul>
    <div id="clock"></div>
  </div>
  <div class="login-container">
    <?php
    if(isset($_SESSION['error'])) {
        echo "<p class='error'>".$_SESSION['error']."</p>";
        unset($_SESSION['error']);
    }
    ?>

  <div class="row">
  <form action="login_process.php" method="POST">
      <div class="title">Log In</div>
      <form id="loginForm">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" id="loginEmail" placeholder="e.g alfeus@gmail.com" required>
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" id="loginPassword" placeholder="Enter Password" required>
          </div>
        </div>
        <button type="submit">Login</button>
         
        
        <p>Don’t have an account? <a href="signUp.php">Sign up</a></p>
      </form>
  </div>
</body>
</html>
