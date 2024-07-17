// SCRIPT OPEN MENU-BURGER / HIDDEN SCROLLING-TEXT
document.addEventListener("DOMContentLoaded", function () {
    const burgerMenuButton = document.querySelector('.burger-menu-button');
    const burgerMenu = document.querySelector('.burger-menu');
    const container = document.getElementById('container');

    burgerMenuButton.addEventListener('click', function () {
        burgerMenu.classList.toggle('open');

        if (burgerMenu.classList.contains('open')) {
            container.style.display = 'none'; // Masquer le conteneur lorsque le menu burger est ouvert
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-xmark"></i>'; // Modifier le contenu du bouton pour afficher la croix
        } else {
            container.style.display = 'block'; // Réafficher le conteneur lorsque le menu burger est fermé
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-bars"></i>'; // Modifier le contenu du bouton pour afficher les barres du menu
        }
    });

    const navLinks = document.querySelectorAll('.links a');

    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            burgerMenu.classList.remove('open');
            container.style.display = 'block'; // Réafficher le conteneur lorsque le menu burger est fermé
            burgerMenuButton.innerHTML = '<i class="fa-solid fa-bars"></i>'; // Réinitialiser le contenu du bouton pour afficher les barres du menu
        });
    });
});
// SCRIPT OPEN MENU-BURGER / HIDDEN SCROLLING-TEXT