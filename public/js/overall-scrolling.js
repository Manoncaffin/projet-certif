// SCRIPT OPEN MENU-BURGER / HIDDEN SCROLLING-TEXT
document.addEventListener("DOMContentLoaded", function () {
    // Récupérer les éléments du menu burger et du menu burger lui-même
    const burgerMenuButton = document.querySelector('.burger-menu-button');
    const burgerMenu = document.querySelector('.burger-menu');
    const container = document.getElementById('container');

    // Ajouter un gestionnaire d'événements pour l'ouverture et la fermeture du menu burger
    burgerMenuButton.addEventListener('click', function () {
        burgerMenu.classList.toggle('open');

        // Masquer ou afficher le conteneur en fonction de l'état du menu burger
        if (burgerMenu.classList.contains('open')) {
            container.style.display = 'none'; // Masquer le conteneur lorsque le menu burger est ouvert
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-xmark"></i>'; // Modifier le contenu du bouton pour afficher la croix
        } else {
            container.style.display = 'block'; // Réafficher le conteneur lorsque le menu burger est fermé
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-bars"></i>'; // Modifier le contenu du bouton pour afficher les barres du menu
        }
    });

    // Récupérer les éléments de la barre de navigation
    const navLinks = document.querySelectorAll('.links a');

    // Ajouter un gestionnaire d'événements pour la fermeture du menu burger lorsque l'utilisateur clique sur un lien de navigation
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            burgerMenu.classList.remove('open');
            container.style.display = 'block'; // Réafficher le conteneur lorsque le menu burger est fermé
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-bars"></i>'; // Réinitialiser le contenu du bouton pour afficher les barres du menu
        });
    });
});
// À REVOIR : LE CONTAINER NE RÉAPPARAÎT PAS 
// SCRIPT OPEN MENU-BURGER / HIDDEN SCROLLING-TEXT