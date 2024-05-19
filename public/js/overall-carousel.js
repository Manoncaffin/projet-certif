// SCRIPT OPEN MENU-BURGER / HIDDEN SCROLLING-TEXT
document.addEventListener("DOMContentLoaded", function () {
    // Récupérer les éléments du menu burger et du menu burger lui-même
    const burgerMenuButton = document.querySelector('.burger-menu-button');
    const burgerMenu = document.querySelector('.burger-menu');
    const carousel = document.querySelector('.carousel');

    // Ajouter un gestionnaire d'événements pour l'ouverture et la fermeture du menu burger
    burgerMenuButton.addEventListener('click', function () {
        burgerMenu.classList.toggle('open');

        // Masquer ou afficher le conteneur en fonction de l'état du menu burger
        if (burgerMenu.classList.contains('open')) {
            carousel.style.display = 'none'; // Masquer le conteneur lorsque le menu burger est ouvert
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-xmark"></i>'; // Modifier le contenu du bouton pour afficher la croix
        } else {
            carousel.style.display = 'block'; // Réafficher le conteneur lorsque le menu burger est fermé
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-bars"></i>'; // Modifier le contenu du bouton pour afficher les barres du menu
        }
    });

    // Récupérer les éléments de la barre de navigation
    const navLinks = document.querySelectorAll('.links a');

    // Ajouter un gestionnaire d'événements pour la fermeture du menu burger lorsque l'utilisateur clique sur un lien de navigation
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            burgerMenu.classList.remove('open');
            carousel.style.display = 'block'; // Réafficher le conteneur lorsque le menu burger est fermé
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-bars"></i>'; // Réinitialiser le contenu du bouton pour afficher les barres du menu
        });
    });
});
// SCRIPT OPEN MENU-BURGER / HIDDEN SCROLLING-TEXT