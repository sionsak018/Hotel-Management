/**
 * Guest Management JavaScript Module
 * Shared functionality for guest management
 */

const GuestManager = (function () {
    /**
     * Initialize all guest-related functionality
     */
    function init() {
        setupGlobalEventListeners();
        setupModalEventListeners();
        debugCheck();
    }

    /**
     * Set up global event listeners
     */
    function setupGlobalEventListeners() {
        // Close modals with Escape key
        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                if (window.hideAddGuestModal) hideAddGuestModal();
                if (window.hideEditGuestModal) hideEditGuestModal();
            }
        });

        // Handle delete confirmation
        document.addEventListener("submit", function (event) {
            if (
                event.target.matches('form[action*="/guests/"]') &&
                event.target.querySelector(
                    'input[name="_method"][value="DELETE"]',
                )
            ) {
                const confirmed = confirm("តើអ្នកពិតជាចង់លុបភ្ញៀវនេះមែនទេ?");
                if (!confirmed) {
                    event.preventDefault();
                }
            }
        });
    }

    /**
     * Set up modal-specific event listeners
     */
    function setupModalEventListeners() {
        // Add modal closing on outside click
        const modals = ["addGuestModal", "editGuestModal"];

        modals.forEach((modalId) => {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.addEventListener("click", function (event) {
                    if (event.target === this) {
                        this.classList.add("hidden");
                    }
                });
            }
        });
    }

    /**
     * Debug function to check modal functionality
     */
    function debugCheck() {
        console.log("Guest Manager initialized");
        console.log("Modal elements:");
        console.log(
            "- addGuestModal:",
            document.getElementById("addGuestModal") !== null,
        );
        console.log(
            "- editGuestModal:",
            document.getElementById("editGuestModal") !== null,
        );
    }

    /**
     * Validate phone number format (optional)
     * @param {string} phone - Phone number to validate
     * @returns {boolean}
     */
    function validatePhoneNumber(phone) {
        // Cambodian phone number pattern
        const phonePattern = /^(\+855|0)[1-9][0-9]{7,8}$/;
        return phonePattern.test(phone.replace(/\s+/g, ""));
    }

    /**
     * Validate email format
     * @param {string} email - Email to validate
     * @returns {boolean}
     */
    function validateEmail(email) {
        if (!email) return true; // Email is optional
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    /**
     * Format phone number
     * @param {string} phone - Phone number to format
     * @returns {string}
     */
    function formatPhoneNumber(phone) {
        // Remove all non-digits
        const cleaned = phone.replace(/\D/g, "");

        // Format Cambodian phone numbers
        if (cleaned.startsWith("855")) {
            return `+${cleaned}`;
        } else if (cleaned.startsWith("0")) {
            return `+855${cleaned.substring(1)}`;
        }

        return phone;
    }

    // Public API
    return {
        init,
        validatePhoneNumber,
        validateEmail,
        formatPhoneNumber,
        debugCheck,
    };
})();

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    GuestManager.init();
});

// Make available globally
window.GuestManager = GuestManager;
