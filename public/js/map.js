document.addEventListener("DOMContentLoaded", function () {
    let searchTimeout;
    const map = L.map('map').setView([48.8566, 2.3522], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Déclarer une variable pour stocker la référence au marqueur précédent
    let previousMarker = null;



    document.getElementById("search_geographicalArea").addEventListener("input", function () {
        const postalCode = this.value.trim();

        // Déclencher la recherche si le code postal comporte exactement 5 chiffres
        if (postalCode.length === 5 && /^\d+$/.test(postalCode)) {
            // Annuler le délai précédent pour éviter les requêtes multiples pendant la saisie
            clearTimeout(searchTimeout);

            // Construire l'URL avec des paramètres de recherche spécifiques à la France et aux territoires d'outre-mer
            const url = 'https://nominatim.openstreetmap.org/search?format=json&postalcode=' + encodeURIComponent(postalCode) + '&countrycodes=FR,RE,GF,GP,MQ,YT';

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const city = data[0].display_name;
                        // Remplir le champ avec la ville trouvée
                        document.getElementById("search_geographicalArea").value = city;
                        // Déclencher la recherche d'adresse automatiquement
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
            // Afficher une alerte si le code postal dépasse 5 chiffres
            alert("Le code postal doit comporter exactement 5 chiffres.");
        }
    });

    function searchAddress() {
        const address = document.getElementById("search_geographicalArea").value;
        const material = document.getElementById("material-bio-select").value;
        const url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = data[0].lat;
                    const lon = data[0].lon;
                    const myIcon = L.icon({
                        iconUrl: '../images/marker.png',
                        iconSize: [50, 50],
                        iconAnchor: [22, 94],
                        popupAnchor: [3, -76],
                    });

                    // Créer un marqueur aux coordonnées trouvées
                    const marker = L.marker([lat, lon], {
                        icon: myIcon
                    }).addTo(map);

                    // Si un marqueur précédent existe, le supprimer de la carte
                    if (previousMarker !== null) {
                        map.removeLayer(previousMarker);
                    }

                    // Assigner le nouveau marqueur à la variable previousMarker
                    previousMarker = marker;

                    // Construire le contenu HTML du popup avec les informations de la publication
                    const popupContent = `
    <div>
        <h6>Bottes de paille</h6>
        <p>Date: 01/05/2024</p>
        <p>Bonjour, je donne 3 bottes de paille de blé destinés à la construction mais elles ont un taux d’humidité trop haut pour les utiliser.</p>
        <a href="./annonce-detail.html"><p>Voir l'annonce</p></a>
    </div>
    `;

                    // Ajouter une popup au marqueur pour afficher l'adresse
                    marker.bindPopup(popupContent, {
                        className: 'custom-popup',
                    });

                    // Définir un gestionnaire d'événements pour ouvrir le popup lors du clic sur le marqueur
                    marker.on('click', function () {
                        this.openPopup();
                    });

                    // Centrer la carte sur le marqueur
                    map.setView([lat, lon], 13);
                } else {
                    alert("Adresse non trouvée");
                }
            })
            .catch(error => {
                console.error('Erreur lors de la recherche d\'adresse :', error);
                alert("Une erreur s'est produite lors de la recherche d'adresse");
            });
    }
});

// document.addEventListener("DOMContentLoaded", function () {
//     let searchTimeout;
//     const map = L.map('map').setView([48.8566, 2.3522], 13);
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         maxZoom: 19,
//         attribution: '© OpenStreetMap contributors'
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
//             const url = 'https://nominatim.openstreetmap.org/search?format=json&postalcode=' + encodeURIComponent(postalCode) + '&countrycodes=FR';

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
//         const material = document.getElementById("material-bio-select").value;

//         // Envoyer une requête AJAX pour récupérer les annonces en fonction du matériau et de l'adresse
//         const xhr = new XMLHttpRequest();
//         xhr.open('GET', `/annonce-chercher?material=${material}&geographicalArea=${encodeURIComponent(address)}`, true);
//         xhr.setRequestHeader('Accept', 'application/json'); // Définir l'en-tête "Accept"
//         xhr.onload = function () {
//             if (xhr.status === 200) {
//                 // Réponse réussie, traiter les données JSON
//                 const announces = JSON.parse(xhr.responseText);
//                 if (announces.length > 0) {
//                     const lat = data[0].latitude;
//                     const lon = data[0].longitude;
//                     const myIcon = L.icon({
//                         iconUrl: '../images/marker.png',
//                         iconSize: [50, 50],
//                         iconAnchor: [22, 94],
//                         popupAnchor: [3, -76],
//                     });
//                     // Créer un marqueur aux coordonnées trouvées
//                     const marker = L.marker([lat, lon], {
//                         icon: myIcon
//                     }).addTo(map);
//                     // Si un marqueur précédent existe, le supprimer de la carte
//                     if (previousMarker !== null) {
//                         map.removeLayer(previousMarker);
//                     }
//                     // Assigner le nouveau marqueur à la variable previousMarker
//                     previousMarker = marker;
//                     // Construire le contenu HTML du popup avec les informations de la publication
//                     const popupContent = `
//             <div>
//                 <h6>${data[0].material.material}</h6>
//                 <p>Date: ${data[0].createdAt.format('dd/MM/yyyy')}</p>
//                 <p>${data[0].description}</p>
//                 <a href="/annonce/detail/${data[0].id}"><p>Voir l'annonce</p></a>
//             </div>
//             `;
//                     // Ajouter une popup au marqueur pour afficher l'adresse
//                     marker.bindPopup(popupContent, {
//                         className: 'custom-popup',
//                     });
//                     // Définir un gestionnaire d'événements pour ouvrir le popup lors du clic sur le marqueur
//                     marker.on('click', function () {
//                         this.openPopup();
//                     });
//                     // Centrer la carte sur le marqueur
//                     map.setView([lat, lon], 13);
//                 } else {
//                     alert("Aucune annonce ne correspond à votre recherche.");
//                 }
//             } else {
//                 // Réponse d'erreur, afficher un message d'erreur approprié
//                 // console.error(`Erreur ${xhr.status}: ${xhr.statusText}`);
//                 if (xhr.responseText.startsWith('<!DOCTYPE')) {
//                     // Réponse HTML d'erreur, extraire le message d'erreur si possible
//                     const parser = new DOMParser();
//                     const doc = parser.parseFromString(xhr.responseText, 'text/html');
//                     const message = doc.querySelector('.error-message')?.textContent;
//                     alert(message || `Une erreur s'est produite lors de la recherche d'adresse.`);
//                 } else {
//                     // Réponse d'erreur au format JSON ou texte brut, afficher le message d'erreur si possible
//                     const data = JSON.parse(xhr.responseText);
//                     const message = data.message || data.error || xhr.responseText;
//                     alert(`Une erreur s'est produite lors de la recherche d'adresse.`);
//                 }
//             }
//         };
//         xhr.onerror = function () {
//             console.error('Erreur lors de la recherche d\'adresse :', this.status);
//             alert("Une erreur s'est produite lors de la recherche d'adresse.");
//         };
//         xhr.send();
//     }
// });
