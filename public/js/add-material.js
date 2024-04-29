// // SELECT AN MATERIAL NO PRESENT INTO THE LIST
// // Fonction pour basculer entre les options de matériaux bio-sourcés et géo-sourcés
// document.addEventListener("DOMContentLoaded", function () {
//     function toggleMaterialSelect() {
//         const classificationSelect = document.getElementById("classification-select");
//         const materialBioSelect = document.getElementById("material-bio-select");
//         const materialGeoSelect = document.getElementById("material-geo-select");
//         const newMaterialInput = document.getElementById("new-material");

//         if (classificationSelect.value === "Matériau bio-sourcé") {
//             materialBioSelect.style.display = "block";
//             materialGeoSelect.style.display = "none";
//         } else if (classificationSelect.value === "Matériau géo-sourcé") {
//             materialBioSelect.style.display = "none";
//             materialGeoSelect.style.display = "block";
//         }

//         // Cacher le champ d'entrée de matériau personnalisé
//         newMaterialInput.style.display = "none";
//     }

//     // Fonction pour afficher le champ d'entrée pour ajouter un nouveau matériau
//     function showCustomMaterialInput() {
//         const newMaterialInput = document.getElementById("new-material");
//         newMaterialInput.style.display = "block";
//     }

//     // Fonction pour basculer l'affichage de l'élément "Ajouter un matériau" en fonction de la sélection
//     function toggleMaterialElements(show) {
//         const addDiv = document.querySelector('.add');
//         addDiv.style.display = show ? 'block' : 'none';
//     }

//     // Ajouter des écouteurs d'événements pour les options "Ajouter un matériau"
//     materialBioSelect.addEventListener("change", function () {
//         if (materialBioSelect.value === "add-an-material-bio") {
//             showCustomMaterialInput();
//             toggleMaterialElements(true);
//         } else {
//             toggleMaterialElements(false);
//         }
//     });

//     materialGeoSelect.addEventListener("change", function () {
//         if (materialGeoSelect.value === "add-an-material-geo") {
//             showCustomMaterialInput();
//             toggleMaterialElements(true);
//         } else {
//             toggleMaterialElements(false);
//         }
//     });

//     // Appeler la fonction toggleMaterialSelect au chargement de la page
//     toggleMaterialSelect();
//     // SELECT AN MATERIAL NO PRESENT INTO THE LIST




//     // INPUT ADD MATERIAL
//     // Fonction pour afficher ou masquer la div add en fonction de la sélection de l'utilisateur
//     function toggleAddMaterialDiv(show) {
//         const addMaterialDiv = document.querySelector('.add');
//         addMaterialDiv.style.display = show ? 'block' : 'none';
//         const addButton = document.querySelector('.add input[type="submit"]');
//         addButton.style.display = show ? 'block' : 'none';
//     }

//     // Fonction pour gérer l'affichage de la div add lorsque l'utilisateur sélectionne "Ajouter un matériau" dans les listes déroulantes
//     function handleMaterialSelectChange(selectElement) {
//         if (selectElement.value === "add-an-material-bio" || selectElement.value === "add-an-material-geo") {
//             toggleAddMaterialDiv(true);
//         } else {
//             toggleAddMaterialDiv(false);
//         }
//     }

//     // Ajouter des écouteurs d'événements pour les changements de sélection dans les listes déroulantes
//     materialBioSelect.addEventListener("change", function () {
//         handleMaterialSelectChange(this);
//     });

//     materialGeoSelect.addEventListener("change", function () {
//         handleMaterialSelectChange(this);
//     });
// });
// // INPUT ADD MATERIAL


document.addEventListener("DOMContentLoaded", function () {
    const selectGeo = document.getElementById("material-geo-select");
    const selectBio = document.getElementById("material-bio-select");
    const addDiv = document.querySelector(".add");
    const addLabel = document.querySelector(".new-material");

    // Fonction pour afficher ou masquer la div "add" en fonction de la sélection
    function toggleAddDiv() {
        if (selectGeo.value === "add-an-material-geo" || selectBio.value === "add-an-material-bio") {
            addDiv.style.display = "block";
            addLabel.style.display = "block"; // Afficher le label
        } else {
            addDiv.style.display = "none";
            addLabel.style.display = "none"; // Masquer le label
        }
    }

    // Ajouter des écouteurs d'événements pour les changements de sélection dans les deux selects
    selectGeo.addEventListener("change", toggleAddDiv);
    selectBio.addEventListener("change", toggleAddDiv);

    // Appel initial pour s'assurer que la div est affichée correctement au chargement de la page
    toggleAddDiv();
});
