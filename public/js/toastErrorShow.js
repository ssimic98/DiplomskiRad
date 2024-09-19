
document.addEventListener('DOMContentLoaded', function () {
    var toastElement = document.getElementById('errorToast');
    if (toastElement) {
        var toast = new bootstrap.Toast(toastElement, {
            delay: 5000
        });
        toast.show();
    }
});