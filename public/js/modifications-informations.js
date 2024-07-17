// TEXT RGPD / ADD SECTOR ACTIVITY
const professionalInput = document.querySelector('#user_professional_1');
const individualInput = document.querySelector('#user_professional_0');

const rgpdTextDiv = document.querySelector('#text_rgpd');

const sectorActivityDiv = document.querySelector('.list_professionnal');

professionalInput.addEventListener('click', () => {
  if (professionalInput.checked) {
    rgpdTextDiv.style.display = 'block';
    sectorActivityDiv.style.display = 'block';
  } else {
    rgpdTextDiv.style.display = 'none';
    sectorActivityDiv.style.display = 'none';
  }
});

individualInput.addEventListener('click', () => {
    rgpdTextDiv.style.display = 'none';
    sectorActivityDiv.style.display = 'none';
  });
// TEXT RGPD / ADD SECTOR ACTIVITY
