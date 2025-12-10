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
  <title>LibTech | Book Entry</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7f6;
    }
  </style>
</head>

<body class="flex flex-col min-h-screen text-slate-800">

  <?php include 'includes/header.php'; ?>

  <!-- Main Content -->
  <main class="flex-grow max-w-7xl mx-auto w-full px-6 py-8">
    <div class="mb-8 flex items-center gap-3">
      <i class="fa-solid fa-book-medical text-3xl text-[#1a365d]"></i>
      <h1 class="text-2xl font-bold text-[#1a365d]">Book Entry</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
      <!-- Form Card -->
      <div class="bg-white rounded-lg shadow-md border-t-4 border-[#1f5c70] p-6 lg:col-span-1">
        <h2 class="text-lg font-bold text-[#1f5c70] mb-6">Add New Book</h2>

        <form id="bookEntryForm" class="space-y-5">
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Book Title</label>
            <input type="text" id="bookTitle" name="title" required
              class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#1f5c70] focus:ring-1 focus:ring-[#1f5c70]"
              placeholder="Enter book title...">
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Author</label>
            <input type="text" id="bookAuthor" name="author" required
              class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#1f5c70] focus:ring-1 focus:ring-[#1f5c70]"
              placeholder="Enter author name...">
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">ISBN (Optional)</label>
            <input type="text" id="bookISBN" name="isbn"
              class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#1f5c70] focus:ring-1 focus:ring-[#1f5c70]"
              placeholder="Enter ISBN...">
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Total Copies</label>
              <input type="number" id="totalCopies" name="total_copies" required min="1" value="1"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#1f5c70]">
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Available</label>
              <input type="number" id="availableCopies" name="available_copies" required min="0" value="1"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#1f5c70]">
            </div>
          </div>

          <button type="submit"
            class="w-full bg-[#1f5c70] hover:bg-[#2a7a92] text-white font-bold py-3 rounded shadow text-sm uppercase tracking-wide mt-4">
            Add Book
          </button>
        </form>
      </div>

      <!-- Books Table -->
      <div class="bg-white rounded-lg shadow-md p-6 lg:col-span-2 min-h-[400px]">
        <h2 class="text-base font-bold text-gray-600 mb-4">Book Inventory</h2>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-gray-50 text-gray-800 text-sm border-b border-gray-100">
                <th class="py-3 px-4 font-bold">Title</th>
                <th class="py-3 px-4 font-bold">Author</th>
                <th class="py-3 px-4 font-bold w-24">Total</th>
                <th class="py-3 px-4 font-bold w-24">Available</th>
                <th class="py-3 px-4 font-bold w-24 text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="booksBody" class="text-sm text-gray-600">
              <tr id="emptyState">
                <td colspan="5" class="text-center py-12 text-gray-400">
                  <i class="fa-solid fa-book-open text-4xl mb-3 block"></i>
                  No books in inventory yet.
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

  <!-- Toast Notification -->
  <div id="toast"
    class="fixed bottom-5 right-5 bg-gray-800 text-white px-6 py-3 rounded shadow-lg transform translate-y-20 opacity-0 transition-all duration-300 flex items-center gap-3 z-50">
    <i class="fa-solid fa-circle-check text-green-400"></i>
    <span>Book added successfully!</span>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('bookEntryForm');
      const booksBody = document.getElementById('booksBody');
      const emptyState = document.getElementById('emptyState');
      const toast = document.getElementById('toast');
      const totalCopiesInput = document.getElementById('totalCopies');
      const availableCopiesInput = document.getElementById('availableCopies');

      // Auto-update available copies when total changes
      totalCopiesInput.addEventListener('input', () => {
        availableCopiesInput.value = totalCopiesInput.value;
      });

      // Load books on page load
      loadBooks();

      // Form submission
      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        try {
          const response = await fetch('api/add_book.php', {
            method: 'POST',
            body: formData
          });

          const data = await response.json();

          if (data.success) {
            showToast('Book added successfully!');
            form.reset();
            totalCopiesInput.value = '1';
            availableCopiesInput.value = '1';
            loadBooks();
          } else {
            alert('Error: ' + data.message);
          }
        } catch (error) {
          alert('Failed to add book. Please try again.');
          console.error(error);
        }
      });

      async function loadBooks() {
        try {
          const response = await fetch('api/get_books.php');
          const data = await response.json();

          if (data.success && data.books.length > 0) {
            emptyState.style.display = 'none';
            booksBody.innerHTML = '';

            data.books.forEach(book => {
              const row = document.createElement('tr');
              row.className = "border-b border-gray-100 hover:bg-gray-50 transition-colors";
              row.innerHTML = `
                <td class="py-3 px-4 font-medium text-[#2b6cb0]">${escapeHtml(book.title)}</td>
                <td class="py-3 px-4">${escapeHtml(book.author)}</td>
                <td class="py-3 px-4">${book.total_copies}</td>
                <td class="py-3 px-4">
                  <span class="font-bold ${book.available_copies > 0 ? 'text-green-600' : 'text-red-600'}">
                    ${book.available_copies}
                  </span>
                </td>
                <td class="py-3 px-4 text-center">
                  <button onclick="deleteBook(${book.book_id})" 
                    class="text-red-600 hover:text-red-800 text-sm">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </td>
              `;
              booksBody.appendChild(row);
            });
          } else {
            emptyState.style.display = '';
          }
        } catch (error) {
          console.error('Failed to load books:', error);
        }
      }

      window.deleteBook = async function(bookId) {
        if (!confirm('Are you sure you want to delete this book?')) return;

        try {
          const formData = new FormData();
          formData.append('book_id', bookId);

          const response = await fetch('api/delete_book.php', {
            method: 'POST',
            body: formData
          });

          const data = await response.json();

          if (data.success) {
            showToast('Book deleted successfully!');
            loadBooks();
          } else {
            alert('Error: ' + data.message);
          }
        } catch (error) {
          alert('Failed to delete book.');
          console.error(error);
        }
      };

      function showToast(message) {
        toast.querySelector('span').textContent = message;
        toast.classList.remove('translate-y-20', 'opacity-0');
        setTimeout(() => {
          toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
      }

      function escapeHtml(text) {
        const map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
        return text.replace(/[&<>"']/g, m => map[m]);
      }
    });
  </script>
</body>
</html>
