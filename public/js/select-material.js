// // SCRIPT SELECT MATERIAL
// document.addEventListener("DOMContentLoaded", function () {
// const classificationSelect = document.getElementById('search_classification');
// const materialGeoSelect = document.getElementById('material-geo-select');
// const materialBioSelect = document.getElementById('material-bio-select');
// const materialGeoLabel = document.querySelector('.material-select-geo');
// const materialBioLabel = document.querySelector('.material-select-bio');

// classificationSelect.addEventListener('change', function () {
//     if (this.value === 'Matériau géo-sourcé') {
//         materialGeoSelect.style.display = 'block';
//         materialBioSelect.style.display = 'none';
//         materialGeoLabel.style.display = 'block';
//         materialBioLabel.style.display = 'none';
//     } else if (this.value === 'Matériau bio-sourcé') {
//         materialGeoSelect.style.display = 'none';
//         materialBioSelect.style.display = 'block';
//         materialGeoLabel.style.display = 'none';
//         materialBioLabel.style.display = 'block';
//     } else {
//         materialGeoSelect.style.display = 'none';
//         materialBioSelect.style.display = 'none';
//         materialGeoLabel.style.display = 'none';
//         materialBioLabel.style.display = 'none';
//     }
// });
// });
// // SCRIPT SELECT MATERIAL

// Sélectionner les éléments HTML
const classificationSelect = document.querySelector('#search_form_classification');
const materialSelect = document.querySelector('#search_form_material');

// Masquer le champ "material" par défaut
materialSelect.style.display = 'none';

// Ajouter un écouteur d'événement sur le champ "classification"
classificationSelect.addEventListener('change', function() {
  // Vérifier si l'option "matériau géo-sourcé" est sélectionnée
  if (this.value === 'Matériau géo-sourcé') {
    // Afficher le champ "material"
    materialSelect.style.display = 'block';
  } else {
    // Masquer le champ "material"
    materialSelect.style.display = 'none';
  }
});