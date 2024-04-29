// // SEARCH CITY
document.addEventListener("DOMContentLoaded", function () {
    let searchTimeout;

    document.getElementById("geographical").addEventListener("input", function () {
        const postalCode = this.value.trim();

        // Déclencher la recherche si le code postal comporte exactement 5 chiffres
        if (postalCode.length === 5 && /^\d+$/.test(postalCode)) {
            // Annuler le délai précédent pour éviter les requêtes multiples pendant la saisie
            clearTimeout(searchTimeout);

            // Définir un délai avant de lancer la recherche
            searchTimeout = setTimeout(() => {
                // Construire l'URL avec des paramètres de recherche spécifiques à la France et aux territoires d'outre-mer
                const url = 'https://nominatim.openstreetmap.org/search?format=json&postalcode=' + encodeURIComponent(postalCode) + '&countrycodes=FR,RE,GF,GP,MQ,YT';

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const city = data[0].display_name;
                            // Remplir le champ avec la ville trouvée
                            document.getElementById("geographical").value = city;
                        } else {
                            alert("Aucune ville trouvée pour ce code postal");
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la recherche de ville par code postal :', error);
                        alert("Une erreur s'est produite lors de la recherche de ville par code postal");
                    });
            }, 600); // Délai en millisecondes avant de lancer la recherche (par exemple, 500 ms)
        } else if (postalCode.length > 5) {
            // Afficher une alerte si le code postal dépasse 5 chiffres
            alert("Le code postal doit comporter exactement 5 chiffres.");
        }
    });
});
// // SEARCH CITY