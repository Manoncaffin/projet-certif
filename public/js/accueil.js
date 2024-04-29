// SCRIPT TABLEAU MATÉRIAUX
document.addEventListener('DOMContentLoaded', function () {
    const toggleItems = document.querySelectorAll('.toggle-table');

    toggleItems.forEach(function (item) {
        item.addEventListener('click', function () {
            const sublistItems = this.parentElement.querySelectorAll('li:not(.toggle-table)');
            sublistItems.forEach(function (subitem) {
                subitem.classList.toggle('hidden');
            });

            // Ajouter ou supprimer la classe show-pointer pour basculer entre les icônes
            this.classList.toggle('show-pointer');
        });
    });
});
// SCRIPT TABLEAU MATÉRIAUX

// IMAGE HEADER
function ImageInitial(image) {
    image.src = "../images/brouette.webp";
}

function ImageChange(image) {
    image.src = "../images/brouette-pleine-droite.webp";
}

// IMAGE HEADER



