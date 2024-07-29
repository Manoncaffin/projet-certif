function showModal() {
    var modal = document.getElementById('delete-account-modal');
    modal.style.display = 'block';
}

function closeModal() {
    var modal = document.getElementById('delete-account-modal');
    modal.style.display = 'none';
}

document.getElementById('confirm-delete-btn').addEventListener('click', function() {
    closeModal();
});

window.onclick = function(event) {
    var modal = document.getElementById('delete-account-modal');
    if (event.target == modal) {
        closeModal(); 
    }
}

window.onload = function() {
    closeModal(); 
}
