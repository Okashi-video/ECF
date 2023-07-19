<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom = $_POST['nom'];
  $commentaire = $_POST['commentaire'];
  $note = $_POST['note'];


  $nom = filter_var($nom, FILTER_SANITIZE_STRING);
  $commentaire = filter_var($commentaire, FILTER_SANITIZE_STRING);

  if (empty($nom) || empty($commentaire) || empty($note)) {
    die("Veuillez remplir tous les champs obligatoires.");
  }

  if (!is_numeric($note) || $note < 1 || $note > 5) {
    die("La note doit être un nombre entre 1 et 5.");
  }


  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

  $conn = new mysqli($servername, $username, $password, $dbname);

  
  if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
  }


  $insertQuery = "INSERT INTO avis (nom, commentaire, note, valide) VALUES (?, ?, ?, 0)";
  $stmt = $conn->prepare($insertQuery);

 
  $stmt->bind_param("ssi", $nom, $commentaire, $note);
  if ($stmt->execute()) {
    echo "L'avis a été ajouté avec succès.";
  } else {
    echo "Erreur lors de l'ajout de l'avis : " . $stmt->error;
  }

 
  $stmt->close();
  $conn->close();
}
?>
