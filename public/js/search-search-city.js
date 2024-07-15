document.addEventListener("DOMContentLoaded", function () {
    let searchTimeout;

    document.getElementById("search_geographicalArea").addEventListener("input", function () {
        if (!document.getElementById("search_geographicalArea")) {
            setTimeout(arguments.callee, 100);
            return;
        }

        const postalCode = this.value.trim();

        if (postalCode.length === 5 && /^\d+$/.test(postalCode)) {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                const url = 'https://nominatim.openstreetmap.org/search?format=json&postalcode=' + encodeURIComponent(postalCode) + '&countrycodes=FR,RE,GF,GP,MQ,YT';

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const city = data[0].display_name;
                            document.getElementById("search_geographicalArea").value = city;
                        } else {
                            alert("Aucune ville trouvée pour ce code postal");
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la recherche de ville par code postal :', error);
                        alert("Une erreur s'est produite lors de la recherche de ville par code postal");
                    });
            }, 600);
        } else if (postalCode.length > 5) {
            alert("Le code postal doit comporter exactement 5 chiffres.");
        }
    });
});
