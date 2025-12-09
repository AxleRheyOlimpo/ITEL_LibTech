<?php
session_start();
// If already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: Home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login/Register - LibTech</title>
  <link rel="stylesheet" href="CSS/LoginPage.css">
</head>
<body>
  
  <a href="Home.php" class="return-home-btn">← Home</a>

  <div class="container">
    <input type="radio" name="tab" id="login" checked>
    <input type="radio" name="tab" id="register">
    
    <div class="tabs">
      <label for="login" class="tab">Login</label>
      <label for="register" class="tab">Register</label>
    </div>

    <div class="form-container">
      <!-- Login Form -->
      <form id="login-form">
        <div id="login-error" class="error-message"></div>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <div class="options">
          <label><input type="checkbox" name="remember"> Remember me</label>
        </div>

        <button type="submit">Login</button>
        <a href="forgetpass.php" class="forgot">Forget Your Password?</a>
      </form>

      <!-- Register Form -->
      <form id="register-form">
        <div id="register-error" class="error-message"></div>
        <div id="register-success" class="success-message"></div>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
      </form>
    </div>
  </div>

  <script>
    // Login Form Handler
    document.getElementById('login-form').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const errorDiv = document.getElementById('login-error');
      errorDiv.textContent = '';
      
      try {
        const response = await fetch('api/login.php', {
          method: 'POST',
          body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
          window.location.href = 'Home.php';
        } else {
          errorDiv.textContent = data.message;
          errorDiv.style.display = 'block';
        }
      } catch (error) {
        errorDiv.textContent = 'An error occurred. Please try again.';
        errorDiv.style.display = 'block';
      }
    });

    // Register Form Handler
    document.getElementById('register-form').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const errorDiv = document.getElementById('register-error');
      const successDiv = document.getElementById('register-success');
      errorDiv.textContent = '';
      successDiv.textContent = '';
      
      try {
        const response = await fetch('api/register.php', {
          method: 'POST',
          body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
          successDiv.textContent = data.message;
          successDiv.style.display = 'block';
          this.reset();
          
          // Switch to login tab after 2 seconds
          setTimeout(() => {
            document.getElementById('login').checked = true;
          }, 2000);
        } else {
          errorDiv.textContent = data.message;
          errorDiv.style.display = 'block';
        }
      } catch (error) {
        errorDiv.textContent = 'An error occurred. Please try again.';
        errorDiv.style.display = 'block';
      }
    });
  </script>

  <style>
    .error-message, .success-message {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
      display: none;
      font-size: 14px;
    }
    
    .error-message {
      background-color: #fee;
      color: #c33;
      border: 1px solid #fcc;
    }
    
    .success-message {
      background-color: #efe;
      color: #3c3;
      border: 1px solid #cfc;
    }
  </style>
</body>
</html>