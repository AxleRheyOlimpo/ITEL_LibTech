<?php
require_once 'includes/auth.php';
checkRememberMe();
requireLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LibTech | Borrower's Entry</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; }
  </style>
</head>

<body class="flex flex-col min-h-screen text-slate-800">

  <?php include 'includes/header.php'; ?>

  <!-- Main Content -->
  <main class="flex-grow max-w-7xl mx-auto w-full px-6 py-8">
    <div class="mb-8 flex items-center gap-3">
      <i class="fa-solid fa-user-plus text-3xl text-[#1a365d]"></i>
      <h1 class="text-2xl font-bold text-[#1a365d]">Borrower's Entry</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
      <!-- Form Card -->
      <div class="bg-white rounded-lg shadow-md border-t-4 border-[#2c7a7b] p-6 lg:col-span-1">
        <h2 class="text-lg font-bold text-[#2c7a7b] mb-6">Add New Borrower</h2>

        <form id="borrowerForm" class="space-y-5">
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Student Name</label>
            <input type="text" id="studentName" name="student_name" required
              class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#2c7a7b] focus:ring-1 focus:ring-[#2c7a7b]"
              placeholder="Enter full name...">
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Student ID</label>
            <input type="text" id="studentId" name="student_id" required
              class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#2c7a7b] focus:ring-1 focus:ring-[#2c7a7b]"
              placeholder="Enter student ID...">
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
            <input type="email" id="studentEmail" name="email" required
              class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#2c7a7b] focus:ring-1 focus:ring-[#2c7a7b]"
              placeholder="Enter email address...">
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Phone Number</label>
            <input type="tel" id="studentPhone" name="phone"
              class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#2c7a7b] focus:ring-1 focus:ring-[#2c7a7b]"
              placeholder="Enter phone number...">
          </div>

          <button type="submit"
            class="w-full bg-[#2c7a7b] hover:bg-[#285e61] text-white font-bold py-3 rounded shadow text-sm uppercase tracking-wide mt-4">
            Add Borrower
          </button>
        </form>
      </div>

      <!-- Borrowers Table -->
      <div class="bg-white rounded-lg shadow-md p-6 lg:col-span-2 min-h-[400px]">
        <h2 class="text-base font-bold text-gray-600 mb-4">Registered Borrowers</h2>

        <div class="mb-4">
          <input type="text" id="searchBorrower" placeholder="Search by name or student ID..."
            class="w-full max-w-sm border border-gray-300 rounded px-3 py-2 text-sm">
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-gray-50 text-gray-800 text-sm border-b border-gray-100">
                <th class="py-3 px-4 font-bold">Student Name</th>
                <th class="py-3 px-4 font-bold">Student ID</th>
                <th class="py-3 px-4 font-bold">Email</th>
                <th class="py-3 px-4 font-bold w-24 text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="borrowersBody" class="text-sm text-gray-600">
              <tr id="emptyState">
                <td colspan="4" class="text-center py-12 text-gray-400">
                  <i class="fa-solid fa-users text-4xl mb-3 block"></i>
                  No borrowers registered yet.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-[#1f5c70] text-white py-8 px-20">
    <div class="flex justify-between items-center flex-wrap gap-4">
      <div>© 2025 LibTech | All Rights Reserved</div>
      <div class="flex gap-4">
        <a href="DiscoverBooks.php" class="hover:underline">Discover</a>
        <a href="AboutUs.php" class="hover:underline">About Us</a>
        <a href="Dashboard.php" class="hover:underline">Account</a>
      </div>
    </div>
  </footer>

  <!-- Toast -->
  <div id="toast"
    class="fixed bottom-5 right-5 bg-gray-800 text-white px-6 py-3 rounded shadow-lg transform translate-y-20 opacity-0 transition-all duration-300 flex items-center gap-3 z-50">
    <i class="fa-solid fa-circle-check text-green-400"></i>
    <span>Borrower added successfully!</span>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('borrowerForm');
      const borrowersBody = document.getElementById('borrowersBody');
      const emptyState = document.getElementById('emptyState');
      const toast = document.getElementById('toast');
      const searchInput = document.getElementById('searchBorrower');
      let allBorrowers = [];

      loadBorrowers();

      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        try {
          const response = await fetch('api/add_borrower.php', {
            method: 'POST',
            body: formData
          });

          const data = await response.json();

          if (data.success) {
            showToast('Borrower added successfully!');
            form.reset();
            loadBorrowers();
          } else {
            alert('Error: ' + data.message);
          }
        } catch (error) {
          alert('Failed to add borrower.');
          console.error(error);
        }
      });

      async function loadBorrowers() {
        try {
          const response = await fetch('api/get_borrowers.php');
          const data = await response.json();

          if (data.success && data.borrowers.length > 0) {
            allBorrowers = data.borrowers;
            renderBorrowers(allBorrowers);
          } else {
            emptyState.style.display = '';
            borrowersBody.innerHTML = '';
          }
        } catch (error) {
          console.error('Failed to load borrowers:', error);
        }
      }

      function renderBorrowers(borrowers) {
        emptyState.style.display = 'none';
        borrowersBody.innerHTML = '';

        borrowers.forEach(borrower => {
          const row = document.createElement('tr');
          row.className = "border-b border-gray-100 hover:bg-gray-50 transition-colors";
          row.innerHTML = `
            <td class="py-3 px-4 font-medium">${escapeHtml(borrower.student_name)}</td>
            <td class="py-3 px-4">${escapeHtml(borrower.student_id)}</td>
            <td class="py-3 px-4">${escapeHtml(borrower.email)}</td>
            <td class="py-3 px-4 text-center">
              <button onclick="deleteBorrower(${borrower.borrower_id})" 
                class="text-red-600 hover:text-red-800 text-sm">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          `;
          borrowersBody.appendChild(row);
        });
      }

      searchInput.addEventListener('input', () => {
        const term = searchInput.value.toLowerCase();
        const filtered = allBorrowers.filter(b =>
          b.student_name.toLowerCase().includes(term) ||
          b.student_id.toLowerCase().includes(term)
        );
        renderBorrowers(filtered);
      });

      window.deleteBorrower = async function(id) {
        if (!confirm('Are you sure you want to delete this borrower?')) return;

        try {
          const formData = new FormData();
          formData.append('borrower_id', id);

          const response = await fetch('api/delete_borrower.php', {
            method: 'POST',
            body: formData
          });

          const data = await response.json();

          if (data.success) {
            showToast('Borrower deleted successfully!');
            loadBorrowers();
          } else {
            alert('Error: ' + data.message);
          }
        } catch (error) {
          alert('Failed to delete borrower.');
        }
      };

      function showToast(message) {
        toast.querySelector('span').textContent = message;
        toast.classList.remove('translate-y-20', 'opacity-0');
        setTimeout(() => toast.classList.add('translate-y-20', 'opacity-0'), 3000);
      }

      function escapeHtml(text) {
        const map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
        return text.replace(/[&<>"']/g, m => map[m]);
      }
    });
  </script>
</body>
</html>
