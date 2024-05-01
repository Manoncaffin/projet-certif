// TEXT RGPD / ADD SECTOR ACTIVITY
// Sélectionnez l'élément input radio pour "Je suis un professionnel"
const professionalInput = document.querySelector('#registration_form_professional_1');
const individualInput = document.querySelector('#registration_form_professional_0');

// Sélectionnez le div contenant le texte à afficher
const rgpdTextDiv = document.querySelector('#text_rgpd');

// Sélectionnez le div contenant la liste déroulante
const sectorActivityDiv = document.querySelector('.list_professionnal');

// Ajoutez un écouteur d'événement sur le clic de l'input radio
professionalInput.addEventListener('click', () => {
  // Si l'input radio est sélectionné, affichez le texte et la liste déroulante
  if (professionalInput.checked) {
    rgpdTextDiv.style.display = 'block';
    sectorActivityDiv.style.display = 'block';
  } else {
    rgpdTextDiv.style.display = 'none';
    sectorActivityDiv.style.display = 'none';
  }
});

// Ajoutez un écouteur d'événement sur le clic de l'input radio "Je suis un particulier"
individualInput.addEventListener('click', () => {
    // Masquez le texte et la liste déroulante
    rgpdTextDiv.style.display = 'none';
    sectorActivityDiv.style.display = 'none';
  });
// TEXT RGPD / ADD SECTOR ACTIVITY
