document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('confirm-dialog');
    const confirmBtn = document.getElementById('confirm-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    let currentForm = null;

    document.querySelectorAll('.delete_announce').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            currentForm = button.closest('form');
            const action = currentForm.getAttribute('action');
            document.getElementById('confirm-dialog').setAttribute('data-form-action', action);
            modal.style.display = 'block';
        });
    });

    confirmBtn.addEventListener('click', function () {
        if (currentForm) {
            currentForm.action = document.getElementById('confirm-dialog').getAttribute('data-form-action');
            currentForm.submit();
        }
        modal.style.display = 'none';
    });

    cancelBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});


