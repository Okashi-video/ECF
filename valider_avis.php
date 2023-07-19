<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $avisId = $_POST['avis_id'];


  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

  $conn = new mysqli($servername, $username, $password, $dbname);


  if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
  }


  $updateQuery = "UPDATE avis SET valide = 1 WHERE id = $avisId";
  if ($conn->query($updateQuery) === TRUE) {
    echo "L'avis a été validé avec succès.";
  } else {
    echo "Erreur lors de la validation de l'avis : " . $conn->error;
  }


  $conn->close();
}
?>
