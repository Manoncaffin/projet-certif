document.addEventListener("DOMContentLoaded", function () {
    let searchTimeout;
    const map = L.map('map').setView([48.8566, 2.3522], 13);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors © CARTO',
        subdomains: 'abcd',
        maxZoom: 15
    }).addTo(map);
    
    function searchAddress() {
    const address = document.getElementById("geographicalArea").value;
    const material = document.getElementById("material").value;

    const announces = JSON.parse(document.getElementById("announces").dataset.announces);

    const url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const lat = data[0].lat;
                const lon = data[0].lon;
                const myIcon = L.icon({
                    iconUrl: '/images/marker.png',
                    iconSize: [50, 50],
                    iconAnchor: [22, 94],
                    popupAnchor: [3, -76],
                });

                let hasMatchingAnnounce = false;

                map.eachLayer(function (layer) {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                });

                for (const id in announces) {
                    const announce = announces[id];

                    if (announce.material === material) {
                        console.log(data[0].lat);
                        const marker = L.marker([data[0].lat, data[0].lon], {
                            icon: myIcon
                        }).addTo(map);

                        const popupContent = `
                            <div> 
                                <h6>${announce.material}</h6>
                                <p>Date: ${announce.createdAt.substring(0, 10)}</p> 
                                <p>${announce.description}</p> 
                                <a href="http://127.0.0.1:8000/annonce-detail/${announce.id}"><p>Voir l'annonce</p></a> 
                            </div>
                        `;

                        marker.bindPopup(popupContent, {
                            className: 'custom-popup',
                        });

                        marker.on('click', function () {
                            this.openPopup();
                        });
                        hasMatchingAnnounce = true;
                    }
                }

                if (!hasMatchingAnnounce) {
                    alert("Aucune annonce ne correspond à votre recherche.");
                } else {
                    map.setView([lat, lon], 13);
                }
            } else {
                alert("Adresse non trouvée");
            }
        })
        .catch(error => {
            console.error('Erreur lors de la recherche d\'adresse :', error);
            alert("Une erreur s'est produite lors de la recherche d'adresse");
        });
}
document.getElementById("searchButton").addEventListener("click", function() {
searchAddress();
});
});
