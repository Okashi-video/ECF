<?php

  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}


$avisId = $_POST['avis_id'];


$query = "DELETE FROM avis WHERE id = $avisId";


if ($conn->query($query) === TRUE) {
    echo "L'avis a été supprimé avec succès.";
} else {
    echo "Erreur lors de la suppression de l'avis : " . $conn->error;
}


$conn->close();
?>
