// SCRIPT SELECT MATERIAL
document.addEventListener("DOMContentLoaded", function () {
const classificationSelect = document.getElementById('classification-select');
const materialGeoSelect = document.getElementById('material-geo-select');
const materialBioSelect = document.getElementById('material-bio-select');
const materialGeoLabel = document.querySelector('.material-select-geo');
const materialBioLabel = document.querySelector('.material-select-bio');

classificationSelect.addEventListener('change', function () {
    if (this.value === 'Matériau géo-sourcé') {
        materialGeoSelect.style.display = 'block';
        materialBioSelect.style.display = 'none';
        materialGeoLabel.style.display = 'block';
        materialBioLabel.style.display = 'none';
    } else if (this.value === 'Matériau bio-sourcé') {
        materialGeoSelect.style.display = 'none';
        materialBioSelect.style.display = 'block';
        materialGeoLabel.style.display = 'none';
        materialBioLabel.style.display = 'block';
    } else {
        materialGeoSelect.style.display = 'none';
        materialBioSelect.style.display = 'none';
        materialGeoLabel.style.display = 'none';
        materialBioLabel.style.display = 'none';
    }
});
});
// SCRIPT SELECT MATERIAL