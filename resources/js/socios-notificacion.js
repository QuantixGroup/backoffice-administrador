function showApproveModal() {
    document.getElementById("approveModal").style.display = "block";
}

function hideApproveModal() {
    document.getElementById("approveModal").style.display = "none";
}

function showRejectModal() {
    document.getElementById("rejectModal").style.display = "block";
}

function hideRejectModal() {
    document.getElementById("rejectModal").style.display = "none";
}

function approveUser() {
    hideApproveModal();
    document.getElementById("approveForm").submit();
}

function rejectUser() {
    hideRejectModal();
    document.getElementById("rejectForm").submit();
}

window.showApproveModal = showApproveModal;
window.hideApproveModal = hideApproveModal;
window.showRejectModal = showRejectModal;
window.hideRejectModal = hideRejectModal;
window.approveUser = approveUser;
window.rejectUser = rejectUser;

window.onclick = function (event) {
    const approveModal = document.getElementById("approveModal");
    const rejectModal = document.getElementById("rejectModal");

    if (event.target === approveModal) {
        hideApproveModal();
    }
    if (event.target === rejectModal) {
        hideRejectModal();
    }
};

function showSuccessNotification(message) {
    const notification = document.getElementById("successNotification");
    const messageSpan = document.getElementById("successMessage");

    messageSpan.textContent = message;
    notification.classList.add("show");

    setTimeout(function () {
        notification.classList.remove("show");
    }, 4000);
}

window.showSuccessNotification = showSuccessNotification;
