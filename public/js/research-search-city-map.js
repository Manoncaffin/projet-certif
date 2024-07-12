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

//     function searchAddress() {
//         const address = document.getElementById("research_form_geographicalArea").value;
//         const materialGeoSelect = document.getElementById("material-geo-select");
//         const materialBioSelect = document.getElementById("material-bio-select");
//         let material = null;

//         console.log("Searching address for:", address);

//         if (materialGeoSelect) {
//             console.log("Material Geo Select found:", materialGeoSelect.value);
//             material = materialGeoSelect.value;
//         } else if (materialBioSelect) {
//             console.log("Material Bio Select found:", materialBioSelect.value);
//             material = materialBioSelect.value;
//         } else {
//             console.error("Neither 'material-geo-select' nor 'material-bio-select' found in the DOM.");
//             alert("Erreur: Sélecteur de matériau non trouvé.");
//             return;
//         }

//         const announces = JSON.parse(document.getElementById("announces").dataset.announces);
//         console.log(announces);
//         const url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);

//         fetch(url)
//             .then(response => response.json())
//             .then(data => {
//                 if (data && data.length > 0) {
//                     const lat = data[0].lat;
//                     const lon = data[0].lon;
//                     const myIcon = L.icon({
//                         iconUrl: '../images/marker.png',
//                         iconSize: [50, 50],
//                         iconAnchor: [22, 94],
//                         popupAnchor: [3, -76],
//                     });

//                     let hasMatchingAnnounce = false;

//                     map.eachLayer(function (layer) {
//                         if (layer instanceof L.Marker) {
//                             map.removeLayer(layer);
//                         }
//                     });

//                     for (const id in announces) {
//                         const announce = announces[id];

//                         if (announce.material === material && announce.geographicalArea === address) {
//                             const marker = L.marker([announce.latitude, announce.longitude], {
//                                 icon: myIcon
//                             }).addTo(map);

//                             const popupContent = `
//                                 <div> 
//                                     <h6>${announce.material}</h6>
//                                     <p>Date: ${announce.createdAt.substring(0, 10)}</p> 
//                                     <p>${announce.description}</p> 
//                                     <a href="./annonce-detail.html?id=${announce.id}"><p>Voir l'annonce</p></a> 
//                                 </div>
//                             `;

//                             marker.bindPopup(popupContent, {
//                                 className: 'custom-popup',
//                             });

//                             marker.on('click', function () {
//                                 this.openPopup();
//                             });
//                             hasMatchingAnnounce = true;
//                         }
//                     }

//                     if (!hasMatchingAnnounce) {
//                         // alert("Aucune annonce ne correspond à votre recherche.");
//                     } else {
//                         map.setView([lat, lon], 13);
//                     }
//                 } else {
//                     // alert("Adresse non trouvée");
//                 }
//             })
//             .catch(error => {
//                 console.error('Erreur lors de la recherche d\'adresse :', error);
//                 // alert("Une erreur s'est produite lors de la recherche d'adresse");
//             });
//     }
});
