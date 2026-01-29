// Main JavaScript file for Innovation Club Management System
// Version: 1.0.0

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle functionality
    const burger = document.getElementById('navbar-burger');
    const menu = document.getElementById('navbar-menu');

    if (burger && menu) {
        burger.addEventListener('click', function() {
            burger.classList.toggle('active');
            menu.classList.toggle('is-active');
            burger.setAttribute('aria-expanded', burger.classList.contains('active'));
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (burger && menu && !burger.contains(event.target) && !menu.contains(event.target)) {
            burger.classList.remove('active');
            menu.classList.remove('is-active');
            burger.setAttribute('aria-expanded', 'false');
        }
    });

    // User dropdown toggle
    const userDropdown = document.querySelector('.user-dropdown');
    const userMenu = document.querySelector('.user-menu');

    if (userDropdown && userMenu) {
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('is-active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!userDropdown.contains(event.target)) {
                userMenu.classList.remove('is-active');
            }
        });
    }

    // Notification system
    const notificationCloseButtons = document.querySelectorAll('.notification .delete');

    notificationCloseButtons.forEach(button => {
        button.addEventListener('click', function() {
            button.parentElement.style.display = 'none';
        });
    });

    // Auto-hide notifications after 5 seconds
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        if (!notification.classList.contains('is-permanent')) {
            setTimeout(() => {
                notification.style.display = 'none';
            }, 5000);
        }
    });

    // Form validation enhancements
    const forms = document.querySelectorAll('form[data-validate="true"]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-danger');
                    isValid = false;
                } else {
                    field.classList.remove('is-danger');
                }
            });

            if (!isValid) {
                e.preventDefault();
                showNotification('Please fill in all required fields.', 'danger');
            }
        });
    });

    // Loading states for buttons
    const loadingButtons = document.querySelectorAll('[data-loading]');
    loadingButtons.forEach(button => {
        button.addEventListener('click', function() {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            button.disabled = true;

            // Re-enable after 3 seconds (fallback)
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 3000);
        });
    });

    // Table row highlighting
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            tableRows.forEach(r => r.classList.remove('is-selected'));
            this.classList.add('is-selected');
        });
    });

    // Modal functionality
    const modalTriggers = document.querySelectorAll('[data-target]');
    const modals = document.querySelectorAll('.modal');
    const modalCloses = document.querySelectorAll('.modal .delete, .modal-background');

    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const target = document.getElementById(trigger.dataset.target);
            if (target) {
                target.classList.add('is-active');
                document.body.classList.add('has-modal-open');
            }
        });
    });

    modalCloses.forEach(close => {
        close.addEventListener('click', function() {
            modals.forEach(modal => modal.classList.remove('is-active'));
            document.body.classList.remove('has-modal-open');
        });
    });

    // Search functionality
    const searchInputs = document.querySelectorAll('[data-search]');
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const targetSelector = this.dataset.search;
            const targets = document.querySelectorAll(targetSelector);

            targets.forEach(target => {
                const text = target.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    target.style.display = '';
                } else {
                    target.style.display = 'none';
                }
            });
        });
    });

    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const message = this.dataset.confirmDelete || 'Are you sure you want to delete this item?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Tooltip initialization
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(tooltip => {
        tooltip.style.position = 'relative';
    });

    // Print functionality
    const printButtons = document.querySelectorAll('[data-print]');
    printButtons.forEach(button => {
        button.addEventListener('click', function() {
            window.print();
        });
    });

    // Copy to clipboard
    const copyButtons = document.querySelectorAll('[data-copy]');
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const textToCopy = this.dataset.copy || this.textContent;
            navigator.clipboard.writeText(textToCopy).then(() => {
                showNotification('Copied to clipboard!', 'success');
            }).catch(() => {
                showNotification('Failed to copy to clipboard.', 'danger');
            });
        });
    });
});

// Utility function to show notifications
function showNotification(message, type = 'info', duration = 3000) {
    const notificationContainer = document.querySelector('.notification-container') ||
                                 document.body.appendChild(document.createElement('div'));

    if (!notificationContainer.classList.contains('notification-container')) {
        notificationContainer.className = 'notification-container';
        notificationContainer.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 400px;
        `;
    }

    const notification = document.createElement('div');
    notification.className = `notification is-${type}`;
    notification.innerHTML = `
        <button class="delete"></button>
        ${message}
    `;

    notificationContainer.appendChild(notification);

    // Auto remove after duration
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, duration);

    // Click to dismiss
    notification.querySelector('.delete').addEventListener('click', () => {
        notification.parentNode.removeChild(notification);
    });
}

// Utility function for AJAX requests
function ajaxRequest(url, options = {}) {
    const defaultOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        ...options
    };

    if (defaultOptions.body && typeof defaultOptions.body === 'object') {
        defaultOptions.body = JSON.stringify(defaultOptions.body);
    }

    return fetch(url, defaultOptions)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .catch(error => {
            console.error('AJAX Error:', error);
            showNotification('An error occurred. Please try again.', 'danger');
            throw error;
        });
}

// Utility function to format dates
function formatDate(date, format = 'Y-m-d') {
    const d = new Date(date);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');

    switch (format) {
        case 'Y-m-d':
            return `${year}-${month}-${day}`;
        case 'd/m/Y':
            return `${day}/${month}/${year}`;
        case 'M d, Y':
            return d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        default:
            return d.toISOString().split('T')[0];
    }
}

// Utility function to debounce function calls
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Export utilities for global use
window.InnovationClub = {
    showNotification,
    ajaxRequest,
    formatDate,
    debounce
};