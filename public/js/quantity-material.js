// SCRIPT QUANTITY
document.addEventListener("DOMContentLoaded", function () {
const select = document.getElementById("quantity-select");
const maxNumber = 1000; // Spécifiez ici le nombre maximum souhaité

for (let i = 1; i <= maxNumber; i++) {
    const option = document.createElement("option");
    option.text = i;
    option.value = i;
    select.appendChild(option);
}
});
// SCRIPT QUANTITY