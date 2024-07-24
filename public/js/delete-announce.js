document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('confirm-dialog');
    const confirmBtn = document.getElementById('confirm-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const form = document.getElementById('delete-form');
    const deleteButtons = document.querySelectorAll('.delete_announce');


    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault(); 
            form.setAttribute('action', this.closest('form').getAttribute('action'));
            modal.style.display = 'block'; 
        });
    });

    confirmBtn.addEventListener('click', function () {
        modal.style.display = 'none';
        form.submit(); 
    });

    cancelBtn.addEventListener('click', function () {
        modal.style.display = 'none'; 
    });

    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});


