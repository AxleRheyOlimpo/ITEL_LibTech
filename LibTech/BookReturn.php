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
  <title>LibTech | Book Return</title>
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
          <i class="fa-solid fa-magnifying-glass text-3xl mb-2 block"></i>
          <p>No matching records found.</p>
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

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const searchInput = document.getElementById('searchInput');
      const transactionBody = document.getElementById('transactionBody');
      const emptyState = document.getElementById('emptyState');
      
      let allTransactions = [];

      loadIssuedBooks();

      if (searchInput) {
        searchInput.addEventListener('input', filterTransactions);
      }

      async function loadIssuedBooks() {
        try {
          const response = await fetch('api/get_transactions.php?type=issued');
          const data = await response.json();

          if (data.success && data.transactions.length > 0) {
            allTransactions = data.transactions;
            renderTransactions(allTransactions);
          } else {
            showEmptyState();
          }
        } catch (error) {
          console.error('Failed to load transactions:', error);
          showEmptyState();
        }
      }

      function renderTransactions(transactions) {
        if (!transactionBody) return;
        
        transactionBody.innerHTML = '';
        
        if (transactions.length === 0) {
          showEmptyState();
          return;
        }

        if (emptyState) emptyState.classList.add('hidden');

        transactions.forEach(transaction => {
          const row = document.createElement('tr');
          row.className = "border-b border-gray-100 hover:bg-gray-50 transition-colors";
          
          const dueDate = new Date(transaction.due_date);
          const today = new Date();
          const isOverdue = dueDate < today;
          
          row.innerHTML = `
            <td class="py-3 px-4">${escapeHtml(transaction.student_name)}</td>
            <td class="py-3 px-4 font-medium text-[#2b6cb0]">${escapeHtml(transaction.book_title)}</td>
            <td class="py-3 px-4">${formatDate(transaction.due_date)}</td>
            <td class="py-3 px-4">
              <span class="text-xs font-bold px-2 py-1 rounded-full ${
                isOverdue 
                  ? 'bg-red-100 text-red-700' 
                  : 'bg-green-100 text-green-700'
              }">
                ${isOverdue ? 'Overdue' : 'Active'}
              </span>
            </td>
            <td class="py-3 px-4 text-center">
              <button 
                onclick="returnBook(${transaction.transaction_id}, '${escapeHtml(transaction.book_title)}')"
                class="bg-[#2c7a7b] hover:bg-[#285e61] text-white text-xs font-bold py-2 px-4 rounded transition-colors">
                Return
              </button>
            </td>
          `;
          
          transactionBody.appendChild(row);
        });
      }

      function filterTransactions() {
        if (!searchInput) return;
        
        const searchTerm = searchInput.value.toLowerCase();
        
        const filtered = allTransactions.filter(transaction => {
          return transaction.student_name.toLowerCase().includes(searchTerm) ||
                 transaction.book_title.toLowerCase().includes(searchTerm);
        });
        
        renderTransactions(filtered);
      }

      function showEmptyState() {
        if (emptyState) {
          emptyState.classList.remove('hidden');
        }
        if (transactionBody) {
          transactionBody.innerHTML = '';
        }
      }

      function formatDate(dateString) {
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('en-GB', options);
      }

      function escapeHtml(text) {
        const map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
        return text.replace(/[&<>"']/g, m => map[m]);
      }

      window.returnBook = async function(transactionId, bookTitle) {
        if (!confirm(`Are you sure you want to return "${bookTitle}"?`)) {
          return;
        }

        try {
          const formData = new FormData();
          formData.append('transaction_id', transactionId);

          const response = await fetch('api/return_book.php', {
            method: 'POST',
            body: formData
          });

          const data = await response.json();

          if (data.success) {
            alert(`Book "${bookTitle}" returned successfully!`);
            await loadIssuedBooks();
            
            if (typeof updateDashboardMetrics === 'function') {
              updateDashboardMetrics();
            }
          } else {
            alert('Error: ' + data.message);
          }
        } catch (error) {
          alert('Failed to return book. Please try again.');
          console.error(error);
        }
      };
    });
  </script>
  <script src="JS/dashboard-sync.js"></script>
</body>
</html>
