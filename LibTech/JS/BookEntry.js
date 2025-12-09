// Borrow button functionality
function borrowBook(bookTitle) {
    alert(`You have initiated a request to borrow: "${bookTitle}"`);
}

// Search functionality
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const bookCards = document.querySelectorAll('.book-card');

    searchInput.addEventListener('keyup', (e) => {
        const term = e.target.value.toLowerCase();

        bookCards.forEach(card => {
            const title = card.querySelector('h4').innerText.toLowerCase();
            const author = card.querySelector('.author').innerText.toLowerCase();

            if (title.includes(term) || author.includes(term)) {
                // restore original layout instead of forcing "block"
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    });
});
