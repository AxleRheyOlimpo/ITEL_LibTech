<?php
require_once 'includes/auth.php';
checkRememberMe(); // Auto-login if remember me token exists
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LibTech | Book Entry</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/BookEntry.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="dashboard-page">

  <!-- Header -->
  <header>
    <?php if (isLoggedIn()): 
      $user = getCurrentUser();
    ?>
      <!-- Logged in header with user profile -->
      <div class="user-profile" onclick="toggleDropdown()">
        <div class="user-avatar" id="userAvatar"><?php echo strtoupper(substr($user['first_name'], 0, 1)); ?></div>
        <div class="user-info">
          <span class="user-greeting">Welcome back,</span>
          <span class="user-name"><?php echo htmlspecialchars($user['username']); ?></span>
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

  <!-- Available Books Section -->
  <section class="available-section" id="available-books">
    <div class="catalog-header">
      <h3>AVAILABLE BOOKS</h3>
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search by title or author...">
        <button>🔍</button>
      </div>
    </div>

    <div class="book-grid" id="bookGrid">

      <!-- Book 1 -->
      <div class="book book-card">
        <img src="IMAGES/Neural Orchard.png" alt="Neural Orchard book cover">
        <div class="book-info">
          <h4>Neural Orchard</h4>
          <p class="author">by John Doe</p>
          <p class="rating">★★★★☆</p>
          <p class="description">A captivating story exploring AI and human creativity.</p>
          <a href="Issuance.php?book=Neural%20Orchard" class="borrow-btn">Borrow</a>
        </div>
      </div>

      <!-- Book 2 -->
      <div class="book book-card">
        <img src="IMAGES/Synthetic Shadows.png" alt="Synthetic Shadows book cover">
        <div class="book-info">
          <h4>Synthetic Shadows</h4>
          <p class="author">by Jane Smith</p>
          <p class="rating">★★★☆☆</p>
          <p class="description">A thrilling journey into the future of robotics.</p>
          <a href="Issuance.php?book=Synthetic%20Shadows" class="borrow-btn">Borrow</a>
        </div>
      </div>

      <!-- Book 3 -->
      <div class="book book-card">
        <img src="IMAGES/Data Corruption.jpg" alt="Data Corruption book cover">
        <div class="book-info">
          <h4>Data Corruption</h4>
          <p class="author">by Alex Turner</p>
          <p class="rating">★★★★☆</p>
          <p class="description">Insights into cybersecurity and digital vulnerabilities.</p>
          <a href="Issuance.php?book=Data%20Corruption" class="borrow-btn">Borrow</a>
        </div>
      </div>

      <!-- Book 4 -->
      <div class="book book-card">
        <img src="IMAGES/Cosmic Code.png" alt="Cosmic Code book cover">
        <div class="book-info">
          <h4>Cosmic Code</h4>
          <p class="author">by Emily Rose</p>
          <p class="rating">★★★★★</p>
          <p class="description">A science fiction adventure through space and technology.</p>
          <a href="Issuance.php?book=Cosmic%20Code" class="borrow-btn">Borrow</a>
        </div>
      </div>

      <!-- Book 5 -->
      <div class="book book-card">
        <img src="IMAGES/The nature of technology.png" alt="The Nature of Technology book cover">
        <div class="book-info">
          <h4>The Nature of Technology</h4>
          <p class="author">by Michael Brown</p>
          <p class="rating">★★★☆☆</p>
          <p class="description">Exploring how technology shapes human life and society.</p>
          <a href="Issuance.php?book=The%20Nature%20of%20Technology" class="borrow-btn">Borrow</a>
        </div>
      </div>

      <!-- Book 6 -->
      <div class="book book-card">
        <img src="IMAGES/thirst.png" alt="Thirst book cover">
        <div class="book-info">
          <h4>Thirst</h4>
          <p class="author">by Sarah Lee</p>
          <p class="rating">★★★★☆</p>
          <p class="description">An intense story of survival and human determination.</p>
          <a href="Issuance.php?book=Thirst" class="borrow-btn">Borrow</a>
        </div>
      </div>

      <!-- Book 7 -->
      <div class="book book-card">
        <img src="IMAGES/alice_s adventure.png" alt="Alice's Adventure book cover">
        <div class="book-info">
          <h4>Alice's Adventure</h4>
          <p class="author">by Lewis Carroll</p>
          <p class="rating">★★★★★</p>
          <p class="description">A classic tale of wonder and curiosity.</p>
          <a href="Issuance.php?book=Alice%27s%20Adventure" class="borrow-btn">Borrow</a>
        </div>
      </div>

      <!-- Book 8 -->
      <div class="book book-card">
        <img src="IMAGES/fairy tales.png" alt="Fairy Tales book cover">
        <div class="book-info">
          <h4>Fairy Tales</h4>
          <p class="author">by Various Authors</p>
          <p class="rating">★★★★☆</p>
          <p class="description">Magical stories to spark imagination for all ages.</p>
          <a href="Issuance.php?book=Fairy%20Tales" class="borrow-btn">Borrow</a>
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
      <a href="#" target="_blank" class="social-btn google" aria-label="Google">
        <img src="IMAGES/IG logo.png" alt="Google Logo">
      </a>
      <a href="#" target="_blank" class="social-btn twitter" aria-label="Twitter">
        <img src="IMAGES/X or twitter logo.png" alt="Twitter Logo">
      </a>
    </div>
  </footer>

  <script src="JS/BookEntry.js"></script>
</body>
</html>
