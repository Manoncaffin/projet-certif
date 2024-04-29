document.addEventListener("DOMContentLoaded", function () {
    const mainContent = document.getElementById('main-content');
    
    function setScrollbarHeight() {
        const windowHeight = window.innerHeight;
        const mainContentHeight = mainContent.clientHeight;
        if (mainContentHeight < windowHeight) {
            const scrollbarHeight = windowHeight - mainContentHeight;
            mainContent.style.paddingBottom = scrollbarHeight + 'px';
        } else {
            mainContent.style.paddingBottom = '0';
        }
    }

    // Appeler la fonction au chargement de la page et lors du redimensionnement de la fenêtre
    setScrollbarHeight();
    window.addEventListener('resize', setScrollbarHeight);
});