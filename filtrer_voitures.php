<?php

  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}


$query = "SELECT id, nom, modele, annee, kilometrage, prix, image_principale FROM voitures WHERE 1=1";


$kiloMin = $_GET['kiloMin'] ?? null;
$kiloMax = $_GET['kiloMax'] ?? null;
$prixMin = $_GET['prixMin'] ?? null;
$prixMax = $_GET['prixMax'] ?? null;
$anneeMin = $_GET['anneeMin'] ?? null;
$anneeMax = $_GET['anneeMax'] ?? null;


if (!empty($kiloMin)) {
    $query .= " AND kilometrage >= $kiloMin";
}
if (!empty($kiloMax)) {
    $query .= " AND kilometrage <= $kiloMax";
}


if (!empty($prixMin)) {
    $query .= " AND prix >= $prixMin";
}
if (!empty($prixMax)) {
    $query .= " AND prix <= $prixMax";
}


if (!empty($anneeMin)) {
    $query .= " AND annee >= $anneeMin";
}
if (!empty($anneeMax)) {
    $query .= " AND annee <= $anneeMax";
}


$result = $conn->query($query);


if (!$result) {
    die("Erreur lors de l'exécution de la requête : " . $conn->error);
}


$output = '';
while ($row = $result->fetch_assoc()) {
    $output .= '<a href="voiture.php?id=' . $row['id'] . '" class="car-card">';
    $output .= '<h3>' . $row['nom'] . '</h3>';
    $output .= '<img class="car-image" src="data:image/jpeg;base64,' . base64_encode($row['image_principale']) . '" alt="Image de la voiture">';
    $output .= '<p><strong>Modèle:</strong> ' . $row['modele'] . '</p>';
    $output .= '<p><strong>Année:</strong> ' . $row['annee'] . '</p>';
    $output .= '<p><strong>Kilométrage:</strong> ' . $row['kilometrage'] . ' km</p>';
    $output .= '<p><strong>Prix:</strong> ' . $row['prix'] . ' €</p>';
    $output .= '</a>';
}


$conn->close();


echo $output;
?>
