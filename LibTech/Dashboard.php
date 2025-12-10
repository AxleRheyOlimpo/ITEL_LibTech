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
  <?php include 'includes/header.php'; ?>

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
      <a href="https://www.facebook.com/profile.php?id=61584802821604&_rdc=1&_rdr#" target="_blank" class="social-btn facebook" aria-label="Facebook">
        <img src="IMAGES/FB logo.png" alt="Facebook Logo">
      </a>
      <a href="https://www.instagram.com/libtech2025?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="social-btn google" aria-label="Instagram">
        <img src="IMAGES/IG logo.png" alt="Instagram Logo">
      </a>
      <a href="https://www.x.com" target="_blank" class="social-btn twitter" aria-label="Twitter">
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