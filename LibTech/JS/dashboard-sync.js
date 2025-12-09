// JS/dashboard-sync.js
// Sync dashboard metrics across all pages

async function updateDashboardMetrics() {
  try {
    const response = await fetch('api/get_dashboard_data.php');
    const data = await response.json();
    
    if (data.success) {
      const metrics = data.data;
      
      // Update all metric values on the page
      const availableBooksElements = document.querySelectorAll('[data-metric="available-books"]');
      availableBooksElements.forEach(el => {
        el.textContent = metrics.availableBooks;
      });
      
      const checkedOutElements = document.querySelectorAll('[data-metric="checked-out"]');
      checkedOutElements.forEach(el => {
        el.textContent = metrics.checkedOut;
      });
      
      const returnedElements = document.querySelectorAll('[data-metric="returned"]');
      returnedElements.forEach(el => {
        el.textContent = metrics.returned;
      });
      
      // Update user info if elements exist
      if (metrics.user) {
        const userNameElements = document.querySelectorAll('[data-user="fullName"]');
        userNameElements.forEach(el => {
          el.textContent = metrics.user.first_name + ' ' + metrics.user.last_name;
        });
        
        const firstNameElements = document.querySelectorAll('[data-user="firstName"]');
        firstNameElements.forEach(el => {
          el.textContent = metrics.user.first_name;
        });
        
        const avatarElements = document.querySelectorAll('[data-user="avatar"]');
        avatarElements.forEach(el => {
          el.textContent = metrics.user.first_name.charAt(0).toUpperCase();
        });
      }
    }
  } catch (error) {
    console.error('Failed to update dashboard metrics:', error);
  }
}

// Update on page load
document.addEventListener('DOMContentLoaded', updateDashboardMetrics);

// Optional: Auto-refresh every 30 seconds
setInterval(updateDashboardMetrics, 30000);

// Dropdown toggle function
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