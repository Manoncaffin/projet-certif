function showDeleteModal() {
    const modal = document.getElementById('delete-account-modal');
    const confirmBtn = document.getElementById('confirm-delete-btn');
    const cancelBtn = document.getElementById('cancel-delete-btn');
    const form = document.getElementById('delete-account-form');

    modal.style.display = 'block'; 

    confirmBtn.onclick = function() {
        form.setAttribute('action', form.getAttribute('data-action')); 
        form.submit(); 
    };

    cancelBtn.onclick = function() {
        modal.style.display = 'none'; 
    };

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none'; 
        }
    };
}