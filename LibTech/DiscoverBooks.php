<?php
require_once 'includes/auth.php';
checkRememberMe();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LibTech | Discover Books</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7f6;
      color: #333;
      margin: 0;
    }

    /* Main Content */
    .available-section {
      padding: 50px 8%;
      text-align: left;
    }

    .catalog-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 2rem;
      gap: 1rem;
    }

    .catalog-header h3 {
      font-size: 23px;
      color: #1f5c70;
    }

    .search-bar {
      display: flex;
      gap: 5px;
    }

    .search-bar input {
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      width: 250px;
      outline: none;
    }

    .search-bar input:focus {
      border-color: #2D7D9A;
    }

    .search-bar button {
      padding: 10px 15px;
      background: #1f5c70;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    /* Book Grid */
    .book-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      justify-items: center;
    }

    .book {
      background-color: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      text-decoration: none;
      color: #333;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.3s;
      width: 100%;
      max-width: 280px;
    }

    .book:hover {
      transform: translateY(-5px);
    }

    .book img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 12px 12px 0 0;
    }

    .book-info {
      padding: 15px;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .book-info h4 {
      font-size: 18px;
      margin-bottom: 5px;
      color: #1f5c70;
    }

    .book-info .author {
      font-size: 13px;
      color: #555;
      margin-bottom: 5px;
    }

    .book-info .rating {
      font-size: 14px;
      color: #f4b400;
      margin-bottom: 5px;
    }

    .book-info .description {
      font-size: 13px;
      color: #666;
      line-height: 1.4;
      margin-bottom: 10px;
    }

    .borrow-btn {
      padding: 10px 15px;
      background-color: #1f5c70;
      color: #fff;
      border-radius: 10px;
      font-weight: 600;
      text-align: center;
      text-decoration: none;
      transition: background-color 0.3s;
      margin-top: auto;
      display: block;
    }

    .borrow-btn:hover {
      background-color: #3a8c9d;
    }

    /* Footer */
    footer {
      background: #1f5c70;
      color: #fff;
      padding: 30px 80px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 15px;
    }

    .footer-links {
      display: flex;
      gap: 15px;
    }

    .footer-links a {
      color: #fff;
      text-decoration: none;
      transition: 0.3s;
    }

    .footer-links a:hover {
      text-decoration: underline;
    }

    @media (max-width: 900px) {
      .catalog-header {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <!-- Available Books Section -->
  <section class="available-section" id="available-books">
    <div class="catalog-header">
      <h3>DISCOVER BOOKS</h3>
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search by title or author...">
        <button>🔍</button>
      </div>
    </div>

    <div class="book-grid" id="bookGrid">
      <!-- Books will be loaded dynamically -->
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-left">© 2025 LibTech | All Rights Reserved</div>
    <div class="footer-links">
      <a href="DiscoverBooks.php">Discover</a>
      <a href="AboutUs.php">About Us</a>
      <a href="Dashboard.php">Account</a>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const bookGrid = document.getElementById('bookGrid');
      const searchInput = document.getElementById('searchInput');
      let allBooks = [];

      // Load books
      loadBooks();

      async function loadBooks() {
        try {
          const response = await fetch('api/get_books.php');
          const data = await response.json();

          if (data.success && data.books.length > 0) {
            allBooks = data.books;
            renderBooks(allBooks);
          } else {
            bookGrid.innerHTML = '<p style="grid-column: 1/-1; text-align:center; color:#999;">No books available yet.</p>';
          }
        } catch (error) {
          console.error('Failed to load books:', error);
        }
      }

      function renderBooks(books) {
        bookGrid.innerHTML = '';

        books.forEach(book => {
          const bookCard = document.createElement('div');
          bookCard.className = 'book book-card';
          bookCard.innerHTML = `
            <img src="IMAGES/placeholder-book.png" alt="${escapeHtml(book.title)}" onerror="this.src='IMAGES/BGBG.png'">
            <div class="book-info">
              <h4>${escapeHtml(book.title)}</h4>
              <p class="author">by ${escapeHtml(book.author)}</p>
              <p class="description">Available: ${book.available_copies} / ${book.total_copies}</p>
              <a href="Issuance.php?book=${encodeURIComponent(book.title)}" class="borrow-btn">Borrow</a>
            </div>
          `;
          bookGrid.appendChild(bookCard);
        });
      }

      // Search functionality
      searchInput.addEventListener('keyup', (e) => {
        const term = e.target.value.toLowerCase();
        const filtered = allBooks.filter(book =>
          book.title.toLowerCase().includes(term) ||
          book.author.toLowerCase().includes(term)
        );
        renderBooks(filtered);
      });

      function escapeHtml(text) {
        const map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
        return text.replace(/[&<>"']/g, m => map[m]);
      }
    });
  </script>
</body>
</html>
