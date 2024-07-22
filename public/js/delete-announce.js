document.addEventListener("DOMContentLoaded", function () {
    const deleteLinks = document.querySelectorAll('.delete-announce');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            if (confirm('Êtes-vous sûr de vouloir supprimer cette discussion ?')) {
                const announceId = this.getAttribute('data-id');
                const announceElement = document.getElementById(`announce-${announceId}`);

                fetch(`/messagerie/supprimer/${announceId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(error => { throw new Error(error.error); });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        announceElement.remove();
                        alert('Discussion supprimée avec succès.');
                    } else {
                        alert(`Erreur lors de la suppression: ${data.error}`);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert(`Erreur lors de la suppression: ${error.message}`);
                });
            }
        });
    });
});
