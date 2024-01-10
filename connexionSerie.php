<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: text/html; charset=UTF-8");

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "viewz";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les valeurs postées depuis le formulaire HTML
$genre = isset($_POST['genre']) ? $_POST['genre'] : '';
$titre = isset($_POST['titre']) ? $_POST['titre'] : '';
$tri = isset($_POST['tri']) ? $_POST['tri'] : ''; // Nouveau paramètre pour le tri
$ordre = isset($_POST['ordre']) ? $_POST['ordre'] : ''; // Nouveau paramètre pour l'ordre de tri

// Vérifier si le paramètre "genre" est défini
if ($genre === '') {
    echo "Le paramètre 'genre' n'est pas défini.";
    exit();
}

// Échapper les valeurs pour éviter les injections SQL
$genre = mysqli_real_escape_string($conn, $genre);

// Construire la requête SQL en fonction de la présence du titre et du genre
$sql = "SELECT * FROM series WHERE 1";

// Ajouter la condition pour le genre seulement s'il est différent de "tous"
if ($genre !== 'tous') {
    $sql .= " AND genre = '$genre'";
}

// Ajouter la condition pour le titre seulement s'il est spécifié
if (isset($_POST['titre']) && !empty($titre)) {
    $titre = mysqli_real_escape_string($conn, $titre);
    $sql .= " AND titre LIKE '%$titre%'";
}

// Ajouter les conditions pour le tri par note et/ou par durée
if ($tri === 'note' || $tri === 'saisons') {
    $sql .= " ORDER BY $tri $ordre";
}

$result = $conn->query($sql);

// Vérifier les résultats de la requête
if ($result === false) {
    echo "Erreur dans la requête SQL: " . $conn->error;
} else {
    if ($result->num_rows > 0) {
        // Afficher les résultats sous forme de paragraphes
        while ($row = $result->fetch_assoc()) {
            // Récupérer les informations du film
            $titreSaisons = isset($row['titre']) ? $row['titre'] : 'Titre non disponible';
            $genreSaisons = isset($row['genre']) ? $row['genre'] : 'Genre non disponible';
            $realisateur = isset($row['realisateur']) ? $row['realisateur'] : 'Réalisateur non disponible';
            $dateSortie = isset($row['dateSortie']) ? $row['dateSortie'] : 'Date de sortie non disponible';
            $saisons = isset($row['saisons']) ? $row['saisons'] : 'Durée non disponible';
            $note = isset($row['note']) ? $row['note'] : 'Note non disponible';
            $description = isset($row['description']) ? $row['description'] : 'Description non disponible';

            // Afficher les informations du film avec des sauts de ligne
            echo "<p>";
            echo "Titre: " . $titreSaisons . "<br>";
            echo "Genre: " . $genreSaisons . "<br>";
            echo "Réalisateur: " . $realisateur . "<br>";
            echo "Date de sortie: " . $dateSortie . "<br>";
            echo "saison(s): " . $saisons . " Minutes<br>";
            echo "Note: " . $note . "<br>";
            echo "Description: " . $description;
            echo "</p><hr>"; // Ajoute une ligne horizontale pour séparer les films
        }
    } else {
        echo "Aucun résultat trouvé.";
    }
}

// Fermer la connexion après utilisation
$conn->close();
?>
