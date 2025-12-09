<?php
// includes/header.php - Reusable header component
// Usage: include 'includes/header.php'; (after auth.php)

$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$user = isLoggedIn() ? getCurrentUser() : null;

function isActive($page) {
    global $currentPage;
    return $currentPage === $page ? 'active' : '';
}
?>
<header>
  <div class="logo">
    <a href="Home.php">
      <img src="IMAGES/BGBGBG.png" alt="LibTech Logo" loading="lazy">
    </a>
    <div class="logo-text">
      <h1>LibTech</h1>
      <p>Empowering Smart Libraries Through Technology</p>
    </div>
  </div>

  <nav class="dashboard-nav">
    <a href="Home.php" class="nav-btn <?php echo isActive('Home'); ?>">Home</a>
    <a href="Dashboard.php" class="nav-btn <?php echo isActive('Dashboard'); ?>">Dashboard</a>
    <a href="BookEntry.php" class="nav-btn <?php echo isActive('BookEntry'); ?>">Book Entry</a>
    <a href="Issuance.php" class="nav-btn <?php echo isActive('Issuance'); ?>">Issuance</a>
    <a href="BookReturn.php" class="nav-btn <?php echo isActive('BookReturn'); ?>">Book Return</a>
  </nav>

  <?php if ($user): ?>
    <!-- Logged in - show user profile -->
    <div class="user-profile" onclick="toggleDropdown()">
      <div class="user-avatar" data-user="avatar">
        <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
      </div>
      <div class="user-info">
        <span class="user-greeting">Welcome back,</span>
        <span class="user-name" data-user="fullName">
          <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
        </span>
      </div>
      
      <div class="user-dropdown" id="userDropdown">
        <a href="pages/profile.php" class="dropdown-item">My Profile</a>
        <a href="pages/settings.php" class="dropdown-item">Settings</a>
        <a href="pages/help.php" class="dropdown-item">Help</a>
        <a href="api/logout.php" class="dropdown-item logout">Logout</a>
      </div>
    </div>
  <?php else: ?>
    <!-- Not logged in - show login/signup buttons -->
    <div class="auth-buttons">
      <a href="LoginPage.php" class="login-btn">Login</a>
      <a href="LoginPage.php" class="signup-btn">Sign Up</a>
    </div>
  <?php endif; ?>
</header>

<hr id="thckoutline">