const nav = document.getElementById("nav");

window.addEventListener("scroll", () => {
    if (window.scrollY >= 100) {
        nav.classList.add("nav_black")
    } else {
        nav.classList.remove("nav_black")
    }
})

function redirectToAnotherPage() {
    window.location.href = "recherche_film.html";
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

document.addEventListener('DOMContentLoaded', function () {
    function redirectToHome() {
        window.location.href = 'index.html';
    }

    function animateElement(element) {
        element.classList.add('animate');
    }

    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    var elementsToAnimate = document.querySelectorAll('.input, h1, select');

    elementsToAnimate.forEach(function (element) {
        if (isElementInViewport(element)) {
            animateElement(element);
        }
    });

    var addForm = document.getElementById('add-form');

    if (addForm) {
        addForm.addEventListener('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(addForm);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_movie.php', true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    redirectToHome();
                } else {
                    console.error('Erreur:', xhr.status, xhr.statusText);
                }
            };
            xhr.send(formData);
        });
    }

    var backButton = document.getElementById('add-movie-button');

    if (backButton) {
        backButton.addEventListener('click', redirectToHome);
    }
});

function changeTab(tabName) {
    var tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => {
        tab.style.display = 'none';
    });

    var selectedTab = document.getElementById(tabName);
    if (selectedTab) {
        selectedTab.style.display = 'block';
    }

    if (tabName === 'films') {
        loadMovies();
    } else if (tabName === 'series') {
        loadSeries(); // Assurez-vous d'avoir une fonction loadSeries définie pour charger les séries
    }

    // Rafraîchir la page
    window.location.reload();
}

function loadMovies() {
    var genre = document.getElementById('genre').value;
    var titre = document.getElementById('titre').value;
    var tri = document.getElementById('tri').value;
    var ordre = document.getElementById('ordre').value;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('resultats-films').innerHTML = xhr.responseText;
            } else {
                console.error('Error:', xhr.status, xhr.statusText);
            }
        }
    };

    // Modifiez la requête pour prendre en compte les options de tri
    xhr.open('POST', 'connexion.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('genre=' + encodeURIComponent(genre) + '&titre=' + encodeURIComponent(titre) + '&tri=' + tri + '&ordre=' + ordre);
}

function redirectToAccueil() {
    window.location.href = 'index.html';
}

function redirectToAjoutFilm() {
    window.location.href = 'ajout.html';
}

function redirectToSeries() {
    window.location.href = 'recherche_serie.html';
}

function redirectToFilm() {
    window.location.href = 'recherche_film.html';
}