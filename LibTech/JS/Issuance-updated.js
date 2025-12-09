// JS/Issuance-updated.js
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('issuanceForm');
    const bookTitleInput = document.getElementById('bookTitle');
    const clearBookBtn = document.getElementById('clearBookBtn');
    const bookISBNInput = document.getElementById('bookISBN');
    const issueDateInput = document.getElementById('issueDate');
    const dueDateInput = document.getElementById('dueDate');
    const transactionBody = document.getElementById('transactionBody');
    const emptyState = document.getElementById('emptyState');
    const toast = document.getElementById('toast');

    let transactionCount = 1001;

    const today = new Date().toISOString().split('T')[0];
    issueDateInput.value = today;

    const nextWeek = new Date();
    nextWeek.setDate(nextWeek.getDate() + 7);
    dueDateInput.value = nextWeek.toISOString().split('T')[0];

    const generateISBN = () => {
        const prefix = "978";
        const randomPart = Math.floor(Math.random() * 1000000000);
        return `${prefix}-${randomPart}`;
    };

    const toggleClearBtn = () => {
        if (bookTitleInput.value.length > 0) {
            clearBookBtn.classList.remove('hidden');
        } else {
            clearBookBtn.classList.add('hidden');
        }
    };

    clearBookBtn.addEventListener('click', () => {
        bookTitleInput.value = '';
        bookISBNInput.value = '';
        delete bookISBNInput.dataset.fixed;
        toggleClearBtn();
        bookTitleInput.focus();
    });

    bookTitleInput.addEventListener('input', (e) => {
        toggleClearBtn();
        if (e.target.value.length > 2) {
            if (!bookISBNInput.dataset.fixed) {
                bookISBNInput.value = generateISBN();
                bookISBNInput.dataset.fixed = "true";
            }
        } else if (e.target.value.length === 0) {
            bookISBNInput.value = "";
            delete bookISBNInput.dataset.fixed;
        }
    });

    // Prefill book from URL
    const urlParams = new URLSearchParams(window.location.search);
    const prefillBook = urlParams.get('book');
    if (prefillBook) {
        bookTitleInput.value = decodeURIComponent(prefillBook);
        if (!bookISBNInput.dataset.fixed) {
            bookISBNInput.value = generateISBN();
            bookISBNInput.dataset.fixed = "true";
        }
        toggleClearBtn();
    }

    // Load existing transactions
    loadTransactions();

    // Form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('student_name', document.getElementById('studentName').value);
        formData.append('book_title', bookTitleInput.value);
        formData.append('issue_date', issueDateInput.value);
        formData.append('due_date', dueDateInput.value);

        try {
            const response = await fetch('api/issue_book.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showToast(`Book "${bookTitleInput.value}" issued successfully`);
                
                // Reload transactions
                loadTransactions();
                
                // Update dashboard metrics
                if (typeof updateDashboardMetrics === 'function') {
                    updateDashboardMetrics();
                }

                // Reset form
                document.getElementById('studentName').value = '';
                bookTitleInput.value = '';
                bookISBNInput.value = '';
                delete bookISBNInput.dataset.fixed;
                toggleClearBtn();
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            alert('Failed to issue book. Please try again.');
            console.error(error);
        }
    });

    async function loadTransactions() {
        try {
            const response = await fetch('api/get_transactions.php?type=issued');
            const data = await response.json();

            if (data.success && data.transactions.length > 0) {
                if (emptyState) emptyState.style.display = 'none';
                
                transactionBody.innerHTML = '';
                
                data.transactions.forEach(transaction => {
                    const row = document.createElement('tr');
                    row.className = "border-b border-gray-100 hover:bg-gray-50 transition-colors";
                    row.innerHTML = `
                        <td class="py-3 px-4 font-medium text-gray-800">#${transaction.transaction_id}</td>
                        <td class="py-3 px-4">${transaction.student_name}</td>
                        <td class="py-3 px-4 font-medium text-[#2b6cb0]">${transaction.book_title}</td>
                        <td class="py-3 px-4">${formatDate(transaction.due_date)}</td>
                        <td class="py-3 px-4">
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">
                                Issued
                            </span>
                        </td>
                    `;
                    transactionBody.appendChild(row);
                });
            }
        } catch (error) {
            console.error('Failed to load transactions:', error);
        }
    }

    function formatDate(dateString) {
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('en-GB', options);
    }

    function showToast(message) {
        toast.querySelector('span').textContent = message;
        toast.classList.remove('translate-y-20', 'opacity-0');

        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    }
});