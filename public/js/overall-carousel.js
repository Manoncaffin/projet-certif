// SCRIPT OPEN MENU-BURGER / HIDDEN SCROLLING-TEXT
document.addEventListener("DOMContentLoaded", function () {
    const burgerMenuButton = document.querySelector('.burger-menu-button');
    const burgerMenu = document.querySelector('.burger-menu');
    const carousel = document.querySelector('.carousel');

    burgerMenuButton.addEventListener('click', function () {
        burgerMenu.classList.toggle('open');

        if (burgerMenu.classList.contains('open')) {
            carousel.style.display = 'none'; 
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-xmark"></i>'; // Modifier le contenu du bouton pour afficher la croix
        } else {
            carousel.style.display = 'block'; // Réafficher le conteneur lorsque le menu burger est fermé
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-bars"></i>'; // Modifier le contenu du bouton pour afficher les barres du menu
        }
    });

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