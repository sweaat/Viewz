const nav = document.getElementById("nav");

window.addEventListener("scroll", () => {
    if (window.scrollY >= 100) {
        nav.classList.add("nav_black")
    } else {
        nav.classList.remove("nav_black")
    }
})

function redirectToAnotherPage() {
    window.location.href = "recherche.html";
}

const redirectButton = document.getElementById("redirectButton");
redirectButton.addEventListener("click", redirectToAnotherPage);

const logo = document.querySelector('.nav_logo');

// Ajouter un gestionnaire d'événements pour le clic sur le logo
logo.addEventListener('click', function() {
    // Rafraîchir la page
    location.reload();
});

function openTrailer(trailerLink) {
    window.open(trailerLink, '_blank');
}