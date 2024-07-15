const classification = document.querySelector('#research_form_classification');

function toggleMaterialSelect() {
    const materialBioSelect = document.querySelector('#material-bio-select');
    const materialGeoSelect = document.querySelector('#material-geo-select');
    const materialLabel = document.querySelector('#material-label');
  
    if (classification) {
    // Afficher le champ correspondant au type de matériau sélectionné
    if (classification.value === '1') { // ID de la classification "Matériau bio-sourcé"
        materialBioSelect.style.display = 'block';
        materialLabel.style.display = 'block';
        materialGeoSelect.style.display = 'none';
    } else if (classification.value === '2') { // ID de la classification "Matériau géo-sourcé"
        materialGeoSelect.style.display = 'block';
        materialLabel.style.display = 'block';
        materialBioSelect.style.display = 'none';
    } else {
      materialBioSelect.style.display = 'block';
      materialLabel.style.display = 'block';
  }
  }
}
  
  // Appel de la fonction au chargement de la page
  toggleMaterialSelect();
  
  if (classification) {
  classification.addEventListener('change', toggleMaterialSelect);
  }