const classification = document.querySelector('#research_form_classification');

function toggleMaterialSelect() {
    const materialBioSelect = document.querySelector('#material-bio-select');
    const materialGeoSelect = document.querySelector('#material-geo-select');
    const materialLabel = document.querySelector('#material-label');
  
    if (classification) {
    if (classification.value === '1') {
        materialBioSelect.style.display = 'block';
        materialLabel.style.display = 'block';
        materialGeoSelect.style.display = 'none';
    } else if (classification.value === '2') { 
        materialGeoSelect.style.display = 'block';
        materialLabel.style.display = 'block';
        materialBioSelect.style.display = 'none';
    } else {
      materialBioSelect.style.display = 'block';
      materialLabel.style.display = 'block';
  }
  }
}
  
  toggleMaterialSelect();
  
  if (classification) {
  classification.addEventListener('change', toggleMaterialSelect);
  }