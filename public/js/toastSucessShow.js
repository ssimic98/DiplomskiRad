
document.addEventListener('DOMContentLoaded', function () {
    var toastElement = document.getElementById('toastLoad');
    if (toastElement) {
        var toast = new bootstrap.Toast(toastElement, {
            delay: 5000
        });
        toast.show();
    }
});