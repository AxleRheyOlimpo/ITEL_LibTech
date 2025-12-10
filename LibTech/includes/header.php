<?php
// includes/header.php - Unified header for all pages
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$user = isLoggedIn() ? getCurrentUser() : null;

function isActive($page) {
    global $currentPage;
    return $currentPage === $page ? 'active' : '';
}
?>
<!DOCTYPE html>
<style>
/* Universal Header Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 80px;
  background: #ffffff;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
  height: 100px;
  position: sticky;
  top: 0;
  z-index: 1000;
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
}

.logo img {
  height: clamp(80px, 15vw, 130px);
  width: auto;
  object-fit: contain;
}

.logo-text h1 {
  font-size: 28px;
  color: #1f5c70;
}

.logo-text p {
  font-size: 14px;
  color: #1f5c70;
  margin-top: -5px;
}

/* Navigation */
.dashboard-nav {
  display: flex;
  gap: 5px;
  flex: 1;
  justify-content: center;
}

.dashboard-nav .nav-btn {
  padding: 10px 15px;
  color: #000;
  text-decoration: none;
  font-weight: 600;
  font-size: 14px;
  transition: color 0.3s ease, border-bottom 0.3s ease;
  border-bottom: 3px solid transparent;
}

.dashboard-nav .nav-btn:hover {
  color: #1f5c70;
}

.dashboard-nav .nav-btn.active {
  color: #1f5c70;
  border-bottom: 3px solid #1f5c70;
}

/* User Profile Section */
.user-profile {
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
  position: relative;
}

.user-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: linear-gradient(135deg, #1f5c70 0%, #2a7a92 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 700;
  font-size: 20px;
  box-shadow: 0 2px 8px rgba(31, 92, 112, 0.3);
  transition: transform 0.3s ease;
}

.user-avatar:hover {
  transform: scale(1.05);
}

.user-info {
  display: flex;
  flex-direction: column;
}

.user-greeting {
  font-size: 12px;
  color: #666;
  font-weight: 500;
}

.user-name {
  font-size: 16px;
  color: #1f5c70;
  font-weight: 600;
}

/* Dropdown Menu */
.user-dropdown {
  position: absolute;
  top: 65px;
  right: 0;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  min-width: 180px;
  display: none;
  z-index: 100;
}

.user-dropdown.show {
  display: block;
}

.dropdown-item {
  padding: 12px 20px;
  color: #333;
  text-decoration: none;
  display: block;
  transition: background 0.2s ease;
  font-size: 14px;
}

.dropdown-item:hover {
  background: #f5f5f5;
}

.dropdown-item.logout {
  color: #e74c3c;
  border-top: 1px solid #eee;
}

/* Auth Buttons */
.auth-buttons {
  display: flex;
  gap: 10px;
}

.login-btn,
.signup-btn {
  text-decoration: none;
  padding: 8px 18px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 600;
  transition: 0.3s ease;
}

.login-btn {
  color: #1f5c70;
  border: 2px solid #1f5c70;
  background: transparent;
}

.login-btn:hover {
  background: #1f5c70;
  color: white;
}

.signup-btn {
  background: #1f5c70;
  color: #fff;
}

.signup-btn:hover {
  background: #1f7a90;
}

/* Thick Outline */
hr#thckoutline {
  height: 10px;
  background-color: #1f5c70;
  border: none;
  display: block;
  margin: 0;
}

/* Responsive */
@media (max-width: 1024px) {
  .dashboard-nav {
    gap: 3px;
  }
  
  .dashboard-nav .nav-btn {
    padding: 8px 12px;
    font-size: 13px;
  }
}

@media (max-width: 900px) {
  header {
    flex-direction: column;
    height: auto;
    padding: 20px;
    gap: 15px;
  }

  .dashboard-nav {
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
  }
}
</style>

<header>
  <div class="logo">
    <a href="Home.php">
      <img src="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '../' : ''; ?>IMAGES/BGBGBG.png" alt="LibTech Logo" loading="lazy">
    </a>
    <div class="logo-text">
      <h1>LibTech</h1>
      <p>Library Management System</p>
    </div>
  </div>

  <nav class="dashboard-nav">
    <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '../' : ''; ?>Home.php" 
       class="nav-btn <?php echo isActive('Home'); ?>">Home</a>
    <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '../' : ''; ?>BookEntry.php" 
       class="nav-btn <?php echo isActive('BookEntry'); ?>">Book Entry</a>
    <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '../' : ''; ?>BorrowerEntry.php" 
       class="nav-btn <?php echo isActive('BorrowerEntry'); ?>">Borrower's Entry</a>
    <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '../' : ''; ?>Issuance.php" 
       class="nav-btn <?php echo isActive('Issuance'); ?>">Book Issuance</a>
    <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '../' : ''; ?>BookReturn.php" 
       class="nav-btn <?php echo isActive('BookReturn'); ?>">Book Return</a>
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
          <?php echo htmlspecialchars($user['username']); ?>
        </span>
      </div>
      
      <div class="user-dropdown" id="userDropdown">
        <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '' : 'pages/'; ?>profile.php" class="dropdown-item">My Profile</a>
        <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '' : 'pages/'; ?>settings.php" class="dropdown-item">Settings</a>
        <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '' : 'pages/'; ?>help.php" class="dropdown-item">Help</a>
        <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '../' : ''; ?>api/logout.php" class="dropdown-item logout">Logout</a>
      </div>
    </div>
  <?php else: ?>
    <!-- Not logged in - show login/signup buttons -->
    <div class="auth-buttons">
      <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '../' : ''; ?>LoginPage.php" class="login-btn">Login</a>
      <a href="<?php echo strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '../' : ''; ?>LoginPage.php" class="signup-btn">Sign Up</a>
    </div>
  <?php endif; ?>
</header>

<hr id="thckoutline">

<script>
// Toggle dropdown menu
function toggleDropdown() {
  const dropdown = document.getElementById('userDropdown');
  if (dropdown) {
    dropdown.classList.toggle('show');
  }
}

// Close dropdown when clicking outside
document.addEventListener('click', (event) => {
  const userProfile = document.querySelector('.user-profile');
  const dropdown = document.getElementById('userDropdown');
  
  if (userProfile && dropdown && !userProfile.contains(event.target)) {
    dropdown.classList.remove('show');
  }
});
</script>
