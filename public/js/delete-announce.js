document.addEventListener('DOMContentLoaded', function() {
    const deleteLinks = document.querySelectorAll('.delete-announce');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            const id = this.getAttribute('data-id');
            const url = `/messagerie/supprimer/${id}`;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer l'élément du DOM
                    this.closest('.description_announce').remove();
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });
});
