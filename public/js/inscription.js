// TEXTE RGPD
document.addEventListener("DOMContentLoaded", function () {
// Sélection des boutons radio
const radioButtons = document.querySelectorAll('input[name="user-type"]');
// Sélection du texte RGPD
const textRGPD = document.getElementById('text_rgpd');
// Fonction pour afficher ou masquer le texte RGPD en fonction de la sélection du bouton radio
function toggleTextRGPD() {
 if (document.getElementById('professionnel').checked) {
     textRGPD.style.display = 'block';
 } else {
     textRGPD.style.display = 'none';
 }
}
// Ajout d'un écouteur d'événements à chaque bouton radio
radioButtons.forEach(function (radioButton) {
 radioButton.addEventListener('change', toggleTextRGPD);
});
// Appel initial pour assurer que le texte RGPD est caché par défaut
toggleTextRGPD();
// TEXTE RGPD

// ADD SECTOR ACTIVITY
const particulierRadioButton = document.getElementById('particulier');
const professionnelRadioButton = document.getElementById('professionnel');
const radioProfessionnalContainer = document.querySelector('.radio_professionnal');

professionnelRadioButton.addEventListener('change', function () {
 if (this.checked) {
     radioProfessionnalContainer.style.display = 'block';
 } else {
     radioProfessionnalContainer.style.display = 'none';
 }
});
particulierRadioButton.addEventListener('change', function () {
 if (this.checked) {
     radioProfessionnalContainer.style.display = 'none';
 }
});
});
// ADD SECTOR ACTIVITY
