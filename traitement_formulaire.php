<?php

  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}


$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$objet = $_POST['objet'];
$message = $_POST['message'];


$insertQuery = "INSERT INTO contact_messages (nom, prenom, email, telephone, objet, message) VALUES ('$nom', '$prenom', '$email', '$telephone', '$objet', '$message')";

if ($conn->query($insertQuery) === true) {

    echo "Votre message a été envoyé avec succès.";
} else {
    
    echo "Une erreur est survenue lors de l'envoi du message. Veuillez réessayer plus tard.";
}


$conn->close();
?>
