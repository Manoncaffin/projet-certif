// document.addEventListener("DOMContentLoaded", function () {
//     let searchTimeout;
//     const map = L.map('map').setView([48.8566, 2.3522], 13);
//     L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
//         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
//         subdomains: 'abcd', // ajouter une virgule ici
//         maxZoom: 19
//     }).addTo(map);

//     // Déclarer une variable pour stocker la référence au marqueur précédent
//     let previousMarker = null;

//     document.getElementById("search_geographicalArea").addEventListener("input", function () {
//         const postalCode = this.value.trim();

//         // Déclencher la recherche si le code postal comporte exactement 5 chiffres
//         if (postalCode.length === 5 && /^\d+$/.test(postalCode)) {
//             // Annuler le délai précédent pour éviter les requêtes multiples pendant la saisie
//             clearTimeout(searchTimeout);

//             // Construire l'URL avec des paramètres de recherche spécifiques à la France et aux territoires d'outre-mer
//             const url = 'https://nominatim.openstreetmap.org/search?format=json&postalcode=' + encodeURIComponent(postalCode) + '&countrycodes=FR,RE,GF,GP,MQ,YT';

//             fetch(url)
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data && data.length > 0) {
//                         const city = data[0].display_name;
//                         // Remplir le champ avec la ville trouvée
//                         document.getElementById("search_geographicalArea").value = city;
//                         // Déclencher la recherche d'adresse automatiquement
//                         searchAddress();
//                     } else {
//                         alert("Aucune ville trouvée pour ce code postal");
//                     }
//                 })
//                 .catch(error => {
//                     console.error('Erreur lors de la recherche de ville par code postal :', error);
//                     alert("Une erreur s'est produite lors de la recherche de ville par code postal");
//                 });
//         } else if (postalCode.length > 5) {
//             // Afficher une alerte si le code postal dépasse 5 chiffres
//             alert("Le code postal doit comporter exactement 5 chiffres.");
//         }
//     });

//     function searchAddress() {
//         const address = document.getElementById("search_geographicalArea").value;
//         console.log(address)
//         const material = document.getElementById("material-bio-select").value;
//         console.log(material)
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

//                     // Vérifier si des annonces correspondantes ont été trouvées
//                     const announces = JSON.parse(document.getElementById("announces").dataset.announces);
//                     console.log(announces)
//                     let hasMatchingAnnounce = false;

//                     // Parcourir les annonces pour vérifier s'il y a des correspondances
//                     announces.forEach(announce => {
//                         if (announce.material.material === material && announce.geographicalArea === address && announce.type === 'donner') {
//                             const marker = L.marker([announce.latitude, announce.longitude], {
//                                 icon: myIcon
//                             }).addTo(map)
//                             console.log(marker);
                            

//                             const popupContent = `
//                             <div>
//                                 <h6>${announce.material.material}</h6>
//                                 <p>Date: ${announce.createdAt.substring(0, 10)}</p>
//                                 <p>${announce.description}</p>
//                                 <a href="./annonce-detail.html"><p>Voir l'annonce</p></a>
//                             </div> `;

//                             // Ajouter une popup au marqueur pour afficher l'adresse
//                             marker.bindPopup(popupContent, {
//                                 className: 'custom-popup',
//                             });

//                             marker.on('click', function () {
//                                 this.openPopup();
//                             });

//                             hasMatchingAnnounce = true;
//                         }
//                     });

//                     if (!hasMatchingAnnounce) {
//                         // Aucune annonce correspondante n'a été trouvée
//                         alert("Aucune annonce ne correspond à votre recherche.");
//                     } else {
//                         map.setView([lat, lon], 13);
//                     }
//                 } else {
//                     alert("Adresse non trouvée");
//                 }
//             })
//             .catch(error => {
//                 console.error('Erreur lors de la recherche d\'adresse :', error);
//                 alert("Une erreur s'est produite lors de la recherche d'adresse");
//             });
//     }
// });
