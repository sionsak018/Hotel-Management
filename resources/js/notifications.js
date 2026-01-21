// Function to show browser notification
function showNotification(title, message) {
    if (!("Notification" in window)) {
        console.log("This browser does not support desktop notification");
        return;
    }

    if (Notification.permission === "granted") {
        new Notification(title, { body: message });
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then((permission) => {
            if (permission === "granted") {
                new Notification(title, { body: message });
            }
        });
    }
}

// Function to update notification badge
function updateNotificationBadge(count) {
    const badge = document.getElementById("notification-badge");
    if (badge) {
        badge.textContent = count;
        badge.classList.toggle("hidden", count === 0);
    }
}

// Poll for new notifications
function pollNotifications() {
    fetch("/api/notifications/unread-count")
        .then((response) => response.json())
        .then((data) => {
            updateNotificationBadge(data.count);
        });
}

// Poll every 30 seconds
setInterval(pollNotifications, 30000);

// Initial poll
document.addEventListener("DOMContentLoaded", pollNotifications);
