<?php
require_once 'includes/auth.php';
checkRememberMe();

// Get the current user data
$user = getCurrentUser();
$username = $user['username'];
$firstName = $user['first_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LibTech | Dashboard</title>
  <link rel="stylesheet" href="CSS/Dashboard.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
      </style>
</head>
<body>

  <!-- Header -->
  <header>
    <?php if (isLoggedIn()): ?>
      <!-- Logged in header with user profile -->
      <div class="user-profile" onclick="toggleDropdown()">
        <div class="user-avatar" id="userAvatar"><?php echo strtoupper(substr($firstName, 0, 1)); ?></div>
        <div class="user-info">
          <span class="user-greeting">Welcome back,</span>
          <span class="user-name"><?php echo htmlspecialchars($username); ?></span>
        </div>
          
        <div class="user-dropdown" id="userDropdown">
          <a href="pages/profile.php" class="dropdown-item">My Profile</a>
          <a href="pages/settings.php" class="dropdown-item">Settings</a>
          <a href="pages/help.php" class="dropdown-item">Help</a>
          <a href="api/logout.php" class="dropdown-item logout">Logout</a>
        </div>
      </div>
    <?php else: ?>
      <!-- Not logged in - show login/signup -->
      <div class="auth-buttons">
        <a href="LoginPage.php" class="login-btn">Login</a>
        <a href="LoginPage.php" class="signup-btn">Sign Up</a>
      </div>
    <?php endif; ?>
  </header>

  <hr id="thckoutline">

  <!-- Welcome Section -->
  <section class="welcome-section">
    <div class="welcome-container">
      <div class="welcome-text">
        <h2>Hello, <span id="welcomeName"><?php echo htmlspecialchars($firstName); ?></span>!</h2>
        <p>Welcome to your LibTech dashboard. Here's an overview of your library's current status and activity.</p>
      </div>
    </div>
  </section>

  <!-- Dashboard Metrics -->
  <section class="dashboard-metrics">
    <div class="metrics-container">
      
      <div class="metrics-grid">
        
        <div class="metric-card">
          <div class="metric-icon">📚</div>
          <div class="metric-value" data-metric="available-books">0</div>
          <div class="metric-label">Total Books</div>
        </div>

        <div class="metric-card">
          <div class="metric-icon">📖</div>
          <div class="metric-value" data-metric="checked-out">0</div>
          <div class="metric-label">Books Checked Out</div>
        </div>

        <div class="metric-card">
          <div class="metric-icon">✔</div>
          <div class="metric-value" data-metric="returned">0</div>
          <div class="metric-label">Books Returned</div>
        </div>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-left">
      © 2025 LibTech | All Rights Reserved
    </div>

    <div class="footer-links">
      <a href="BookEntry.php">Discover</a>
      <a href="AboutUs.php">About Us</a>
      <a href="Dashboard.php">Account</a>
    </div>

    <div class="socials">
      <a href="#" target="_blank" class="social-btn facebook" aria-label="Facebook">
        <img src="IMAGES/FB logo.png" alt="Facebook Logo">
      </a>
      <a href="#" target="_blank" class="social-btn google" aria-label="Instagram">
        <img src="IMAGES/IG logo.png" alt="Instagram Logo">
      </a>
      <a href="#" target="_blank" class="social-btn twitter" aria-label="Twitter">
        <img src="IMAGES/X or twitter logo.png" alt="Twitter Logo">
      </a>
    </div>
  </footer>

  <script>
    // Toggle dropdown menu
    function toggleDropdown() {
      const dropdown = document.getElementById('userDropdown');
      dropdown.classList.toggle('show');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
      const userProfile = document.querySelector('.user-profile');
      const dropdown = document.getElementById('userDropdown');
      
      if (userProfile && !userProfile.contains(event.target)) {
        dropdown.classList.remove('show');
      }
    });
  </script>

<script src="JS/dashboard-sync.js"></script>

</body>
</html>