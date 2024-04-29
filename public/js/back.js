// Ajoutez un gestionnaire d'événement au bouton de retour
document.getElementById("retourBtn").addEventListener("click", function() {
    // Retourne à la page précédente dans l'historique du navigateur
    window.history.back();
});