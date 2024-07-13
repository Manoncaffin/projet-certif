document.addEventListener("DOMContentLoaded", function () {
    let searchTimeout;
    const map = L.map('map').setView([48.8566, 2.3522], 13);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors © CARTO',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    document.getElementById("research_form_search").addEventListener("click", function (event) {
        searchAddress();
    });

    document.getElementById("research_form_geographicalArea").addEventListener("input", function () {
        const postalCode = this.value.trim();

        if (postalCode.length === 5 && /^\d+$/.test(postalCode)) {
            clearTimeout(searchTimeout);

            const url = 'https://nominatim.openstreetmap.org/search?format=json&postalcode=' + encodeURIComponent(postalCode) + '&countrycodes=FR,RE,GF,GP,MQ,YT';

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const city = data[0].display_name;
                        document.getElementById("research_form_geographicalArea").value = city;
                        searchAddress();
                    } else {
                        alert("Aucune ville trouvée pour ce code postal");
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la recherche de ville par code postal :', error);
                    alert("Une erreur s'est produite lors de la recherche de ville par code postal");
                });
        } else if (postalCode.length > 5) {
            alert("Le code postal doit comporter exactement 5 chiffres.");
        }
    });
});
