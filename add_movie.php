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
$type = isset($_POST['tri']) ? $_POST['tri'] : '';
$titre = isset($_POST['titre']) ? $_POST['titre'] : '';
$dateSortie = isset($_POST['dateSortie']) ? $_POST['dateSortie'] : '';
$realisateur = isset($_POST['realisateur']) ? $_POST['realisateur'] : '';
$genre = isset($_POST['genre']) ? $_POST['genre'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$note = isset($_POST['note']) ? $_POST['note'] : '';
$duree = isset($_POST['duree']) ? $_POST['duree'] : '';

// Vérifier si le paramètre "type" est défini
if ($type === '') {
    echo "Le paramètre 'type' n'est pas défini.";
    exit();
}

// Échapper les valeurs pour éviter les injections SQL
$type = mysqli_real_escape_string($conn, $type);
$titre = mysqli_real_escape_string($conn, $titre);
$dateSortie = mysqli_real_escape_string($conn, $dateSortie);
$realisateur = mysqli_real_escape_string($conn, $realisateur);
$genre = mysqli_real_escape_string($conn, $genre);
$description = mysqli_real_escape_string($conn, $description);
$note = mysqli_real_escape_string($conn, $note);
$duree = mysqli_real_escape_string($conn, $duree);
$saisons = mysqli_real_escape_string($conn, $duree);


// Construire la requête SQL en fonction du type (film ou série)
if ($type === 'film') {
    $sql = "INSERT INTO films (titre, dateSortie, realisateur, genre, description, note, duree) VALUES ('$titre', '$dateSortie', '$realisateur', '$genre', '$description', '$note', '$duree')";
} elseif ($type === 'serie') {
    $sql = "INSERT INTO series (titre, dateSortie, realisateur, genre, description, note, saisons) VALUES ('$titre', '$dateSortie', '$realisateur', '$genre', '$description', '$note', '$saisons')";
} else {
    echo "Type non reconnu.";
    exit();
}

$result = $conn->query($sql);

// Vérifier les résultats de la requête
if ($result === false) {
    echo "Erreur dans la requête SQL: " . $conn->error;
} else {
    echo "Élément ajouté avec succès.";
}

// Fermer la connexion après utilisation
$conn->close();
?>
