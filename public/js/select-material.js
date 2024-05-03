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




function toggleMaterialSelect() {
  const classification = document.querySelector('#search_classification');
  const materialBioSelect = document.querySelector('#material-bio-select');
  const materialGeoSelect = document.querySelector('#material-geo-select');
  const materialLabel = document.querySelector('#material-label');

  // Masquer tous les champs
  materialBioSelect.style.display = 'none';
  materialGeoSelect.style.display = 'none';
  materialLabel.style.display = 'none';

  // Afficher le champ correspondant au type de matériau sélectionné
  if (classification.value === '1') { // ID de la classification "Matériau bio-sourcé"
      materialBioSelect.style.display = 'block';
      materialLabel.style.display = 'block';
  } else if (classification.value === '2') { // ID de la classification "Matériau géo-sourcé"
      materialGeoSelect.style.display = 'block';
      materialLabel.style.display = 'block';
  }
}