<?php
require_once 'includes/auth.php';
checkRememberMe(); // Auto-login if remember me token exists
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibTech - Book Issuance</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Your Dashboard Page CSS -->
    <link rel="stylesheet" href="CSS/Issuance.css">

    <style>
        /* Ensure Poppins is applied globally */
        body, h1, h2, h3, h4, h5, h6, input, button, select, textarea {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="dashboard-page flex flex-col min-h-screen text-slate-800">

    <!-- =================== HEADER =================== -->
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

    <!-- =================== MAIN CONTENT =================== -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-6 py-8">
        <div class="mb-8 flex items-center gap-3">
            <i class="fa-solid fa-calendar-check text-3xl text-[#1a365d]"></i>
            <h1 class="text-2xl font-bold text-[#1a365d]">Book Issuance</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Left Card -->
            <div class="bg-white rounded-lg shadow-md border-t-4 border-[#319795] p-6 lg:col-span-1">
                <h2 class="text-lg font-bold text-[#319795] mb-6">New Transaction</h2>

                <form id="issuanceForm" class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Student Name</label>
                        <input type="text" id="studentName" required
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#319795] focus:ring-1 focus:ring-[#319795]"
                            placeholder="Enter student name...">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Book Title</label>
                        <div class="relative">
                            <input list="bookOptions" id="bookTitle" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#319795] focus:ring-1 focus:ring-[#319795] pr-10"
                                placeholder="Type or select book title...">

                            <button type="button" id="clearBookBtn"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500 hidden">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </button>

                            <datalist id="bookOptions">
                                <option value="Clean Code">
                                <option value="The Great Gatsby">
                                <option value="Introduction to Algorithms">
                                <option value="Design Patterns">
                                <option value="To Kill a Mockingbird">
                            </datalist>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Book ISBN</label>
                        <input type="text" id="bookISBN" readonly
                            class="w-full bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm text-gray-500 cursor-not-allowed"
                            placeholder="Auto-filled ISBN">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Issue Date</label>
                            <input type="date" id="issueDate" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-sm text-gray-600 focus:outline-none focus:border-[#319795]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Due Date</label>
                            <input type="date" id="dueDate" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-sm text-gray-600 focus:outline-none focus:border-[#319795]">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#2c7a7b] hover:bg-[#285e61] text-white font-bold py-3 rounded shadow text-sm uppercase tracking-wide mt-4">
                        Confirm Issue
                    </button>
                </form>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white rounded-lg shadow-md p-6 lg:col-span-2 min-h-[400px]">
                <h2 class="text-base font-bold text-gray-600 mb-4">Recent Transactions</h2>

                <div class="overflow-x-auto table-container">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-800 text-sm border-b border-gray-100">
                                <th class="py-3 px-4 font-bold w-16">ID</th>
                                <th class="py-3 px-4 font-bold">Student</th>
                                <th class="py-3 px-4 font-bold">Book</th>
                                <th class="py-3 px-4 font-bold w-32">Due Date</th>
                                <th class="py-3 px-4 font-bold w-24">Status</th>
                            </tr>
                        </thead>
                        <tbody id="transactionBody" class="text-sm text-gray-600">
                            <tr id="emptyState">
                                <td colspan="5" class="text-center py-12 text-gray-400">
                                    <i class="fa-regular fa-folder-open text-4xl mb-3 block"></i>
                                    No recent transactions found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>

    <!-- =================== FOOTER =================== -->
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
      <a href="https://youtu.be/dQw4w9WgXcQ?si=UZ_sGkBnUkLYToFJ" target="_blank" class="social-btn facebook" aria-label="Facebook">
        <img src="IMAGES/FB logo.png" alt="Facebook Logo">
      </a>
      <a href="https://youtu.be/dQw4w9WgXcQ?si=UZ_sGkBnUkLYToFJ" target="_blank" class="social-btn google" aria-label="Google">
        <img src="IMAGES/IG logo.png" alt="Google Logo">
      </a>
      <a href="https://youtu.be/dQw4w9WgXcQ?si=UZ_sGkBnUkLYToFJ" target="_blank" class="social-btn twitter" aria-label="Twitter">
        <img src="IMAGES/X or twitter logo.png" alt="Twitter Logo">
      </a>
    </div>
  </footer>

    <div id="toast"
        class="fixed bottom-5 right-5 bg-gray-800 text-white px-6 py-3 rounded shadow-lg transform translate-y-20 opacity-0 transition-all duration-300 flex items-center gap-3 z-50">
        <i class="fa-solid fa-circle-check text-green-400"></i>
        <span>Book issued successfully!</span>
    </div>

    <script src="JS/Issuance-updated.js"></script>
    <script src="dashboard-sync.js"></script>
</body>
</html>
