function toggleMaterialSelect() {
    const classification = document.querySelector('#research_form_classification');
    const materialBioSelect = document.querySelector('#material-bio-select');
    const materialGeoSelect = document.querySelector('#material-geo-select');
    const materialLabel = document.querySelector('#material-label');
  
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
  
  // Appel de la fonction au chargement de la page
  toggleMaterialSelect();
  
  // Ajoutez un écouteur d'événements sur le changement de valeur de classification
  classification.addEventListener('change', toggleMaterialSelect);