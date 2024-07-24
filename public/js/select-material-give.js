function toggleMaterialSelect() {
    const classification = document.querySelector('#give_classification');
    const materialBioSelect = document.querySelector('#material-bio-select');
    const materialGeoSelect = document.querySelector('#material-geo-select');
    const materialLabel = document.querySelector('#material-label');
    const addMaterialDiv = document.querySelector('#add');
  
    if (classification.value === '1') { 
        materialBioSelect.style.display = 'block';
        materialLabel.style.display = 'block';
        materialGeoSelect.style.display = 'none';
        materialGeoSelect.value = null;
        // console.log(materialGeoSelect.value);
    } else if (classification.value === '2') { 
        materialGeoSelect.style.display = 'block';
        materialLabel.style.display = 'block';
        materialBioSelect.style.display = 'none';
        materialBioSelect.value = null;
        // console.log(materialBioSelect.value);
  } else {
    materialBioSelect.style.display = 'block';
    materialLabel.style.display = 'block';
}
  
  materialBioSelect.addEventListener('change', function() {
    if (this.value === 'add-an-material-bio') {
      addMaterialDiv.style.display = 'block';
    } else {
      addMaterialDiv.style.display = 'none';
    }
  });
  
  materialGeoSelect.addEventListener('change', function() {
    if (this.value === 'add-an-material-geo') {
      addMaterialDiv.style.display = 'block';
    } else {
      addMaterialDiv.style.display = 'none';
    }
  });
  }
  
  toggleMaterialSelect();

  classification.addEventListener('change', toggleMaterialSelect);