// LOADER
document.addEventListener("DOMContentLoaded", function () {
    const loader = document.querySelector("#loader");
    let load = 0;
    setInterval(function () {
        loader.innerHTML = `${load} %`;
        if (load < 100) {
            load++;
        } else {
            setTimeout(function () {
                load = 0;
            }, 2000);
        }
    }, 50);

    // Redirection à la fin de l'animation en simulant une tâche longue
    setTimeout(function () {
        document.querySelector(".loading").style.display = "none";
        window.location.href = "./pages/accueil.html";
    }, 1500);
});
// LOADER