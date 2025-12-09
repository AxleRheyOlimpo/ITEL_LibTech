// JS/BookReturn-updated.js
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const transactionBody = document.getElementById('transactionBody');
    const emptyState = document.getElementById('emptyState');
    
    let allTransactions = [];

    // Load issued books
    loadIssuedBooks();

    // Search functionality
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
            
            // Check if overdue
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
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // Make returnBook global
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
                
                // Reload transactions
                await loadIssuedBooks();
                
                // Update dashboard metrics
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