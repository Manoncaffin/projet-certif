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
  const classification = document.querySelector('#search_form_classificationMaterial');
  const materialBio = document.querySelector('#search_form_materialBio');
  const materialBioLabel = document.querySelector('#search_form_materialBio-label');
  const materialGeo = document.querySelector('#search_form_materialGeo');
  const materialGeoLabel = document.querySelector('#search_form_materialGeo-label');

  // Masquer tous les champs
  materialBio.style.display = 'none';
  materialBioLabel.style.display = 'none';
  materialGeo.style.display = 'none';
  materialGeoLabel.style.display = 'none';

  // Afficher le champ correspondant au type de matériau sélectionné
  if (classification.value === '1') { // ID de la classification "Matériau bio-sourcé"
      materialBio.style.display = 'block';
      materialBioLabel.style.display = 'block';
  } else if (classification.value === '2') { // ID de la classification "Matériau géo-sourcé"
      materialGeo.style.display = 'block';
      materialGeoLabel.style.display = 'block';
  }
}