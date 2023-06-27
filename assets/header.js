let header = document.getElementById("qsa-logo");
let prevScrollpos = window.pageYOffset;
let dispearScroll = 50;
// Gérer l'événement de défilement
window.onscroll = function() {
    let currentScrollPos = window.pageYOffset;
    // Comparer les positions de défilement précédente et actuelle
    if (currentScrollPos > dispearScroll) {
        // L'utilisateur est en train de faire défiler vers le haut
        header.style.display = 'none';
    } else {
        // L'utilisateur est en train de faire défiler vers le bas
        header.style.display = 'block';
    }
    prevScrollpos = currentScrollPos;
}

document.addEventListener("DOMContentLoaded", function(event) {
    let currentScrollPos = window.pageYOffset;
    // Comparer les positions de défilement précédente et actuelle
    if (currentScrollPos > dispearScroll) {
        // L'utilisateur est en train de faire défiler vers le haut
        header.style.display = 'none';
    } else {
        // L'utilisateur est en train de faire défiler vers le bas
        header.style.display = 'block';
    }
    prevScrollpos = currentScrollPos;
});