<?php
  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}


if (isset($_GET['id'])) {

    $carId = $conn->real_escape_string($_GET['id']);


    $query = "SELECT * FROM voitures WHERE id = $carId";
    $result = $conn->query($query);


    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
    } else {

        header("Location: erreur.php");
        exit();
    }
} else {
    
    header("Location: erreur.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détail de la voiture</title>



  <link rel="stylesheet" href="voiture.css">

</head>
<body>



<?php include("menu.html"); ?>
<div class="main">
<div class="container">



  <h1><?php echo $car['nom']; ?></h1>

  <div class="car-details">
    <img class="car-image" src="data:image/jpeg;base64,<?php echo base64_encode($car['image_principale']); ?>" alt="Image de la voiture">
    <p class="black"><strong>Modèle:</strong> <?php echo $car['modele']; ?></p>
    <p class="black"><strong>Année:</strong> <?php echo $car['annee']; ?></p>
    <p class="black"><strong>Kilométrage:</strong> <?php echo $car['kilometrage']; ?> km</p>
    <p class="black"><strong>Prix:</strong> <?php echo $car['prix']; ?> €</p>

   
    




    <div class="image-gallery">
        <?php
        $imagesSupplementaires = json_decode($car['images_supplementaires']);

        if (!empty($imagesSupplementaires)) {
          foreach ($imagesSupplementaires as $image) {
            echo '<div class="image-card">';
            echo '<img src="data:image/jpeg;base64,' . $image . '" alt="Image supplémentaire">';
            echo '</div>';
          }
        }
        ?>
      </div>



  </div>

  <h1>Contactez-nous</h1>
    <form method="post" action="traitement_formulaire.php">
        <label class="black" for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required><br>

        <label class="black" for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required><br>

        <label class="black" for="email">Adresse e-mail :</label>
        <input type="email" name="email" id="email" required><br>

        <label class="black" for="telephone">Numéro de téléphone :</label>
        <input type="tel" name="telephone" id="telephone" required><br>

        <label class="black" for="objet">Objet :</label>
        <input type="text" name="objet" id="objet" required value="<?php echo $car['nom'] . ' - ' . $car['modele']; ?>"><br>

        <label class="black" for="message">Message :</label>
        <textarea name="message" id="message" required></textarea><br>

        <input type="submit" name="envoyer" value="Envoyer">
    </form>


</div>


  <script src="script.js"></script>


      </div>
</body>
</html>

<?php

$conn->close();
?>

