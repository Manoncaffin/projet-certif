// SCRIPT MODALE
document.addEventListener("DOMContentLoaded", function () {
// Récupérer les éléments DOM nécessaires
const modal = document.getElementById("myModal");
const btn = document.getElementById("openModal");
const span = document.getElementsByClassName("close")[0];

// Ouvrir la modale lorsque le bouton est cliqué
btn.onclick = function () {
    modal.style.display = "block";
}

// Fermer la modale lorsque l'utilisateur clique sur le bouton de fermeture
span.onclick = function () {
    modal.style.display = "none";
}

// Fermer la modale lorsque l'utilisateur clique en dehors de celle-ci
window.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
});
// SCRIPT MODALE