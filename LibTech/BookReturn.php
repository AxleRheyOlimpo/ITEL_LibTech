<?php
require_once 'includes/auth.php';
checkRememberMe(); // Auto-login if remember me token exists
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LibTech | Book Return</title>

  <!-- Fonts & Tailwind -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="CSS/BookReturn.css">
</head>
<body class="BookReturn flex flex-col min-h-screen text-slate-800">

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

  <!-- Main Content -->
  <main class="flex-grow max-w-7xl mx-auto w-full px-6 py-8">

    <div class="mb-6 flex items-center gap-3">
      <i class="fa-solid fa-rotate-left text-2xl text-[#1a365d]"></i>
      <h1 class="text-2xl font-bold text-[#1a365d]">Book Return</h1>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 min-h-[600px]">

      <div class="mb-6">
        <div class="relative max-w-sm">
          <input type="text" id="searchInput"
            class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-700 placeholder-gray-500 focus:outline-none focus:border-[#2b6cb0] focus:ring-1 focus:ring-[#2b6cb0] transition-all"
            placeholder="Search Student or Book Title...">
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-sm">
              <th class="py-3 px-4 font-bold text-gray-700">Student Name</th>
              <th class="py-3 px-4 font-bold text-gray-700">Book Title</th>
              <th class="py-3 px-4 font-bold text-gray-700 w-32">Due Date</th>
              <th class="py-3 px-4 font-bold text-gray-700 w-32">Status</th>
              <th class="py-3 px-4 font-bold text-gray-700 w-24 text-center">Action</th>
            </tr>
          </thead>
          <tbody id="transactionBody" class="text-sm text-gray-600"></tbody>
        </table>

        <div id="emptyState" class="hidden text-center py-12 text-gray-400">
          <i class="fa-solid fa-magnifying-glass text-3xl mb-2"></i>
          <p>No matching records found.</p>
        </div>
      </div>
    </div>
  </main>

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

  <script src="dashboard-sync.js"></script>

</body>
</html>
