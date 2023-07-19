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


$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des voitures d'occasion</title>


  <link rel="stylesheet" href="style2.css">
  

  <link rel="stylesheet" href="./style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>

    function filtrerVoitures(form) {
      var formData = $(form).serialize();
      $.ajax({
        url: "filtrer_voitures.php",
        type: "GET",
        data: formData,
        success: function(response) {
          $(".car-gallery").html(response);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }
  </script>
  
  <style>
  
  	body.dark p.blacktext {
    	color: #000;
	}
  
  </style>
  
  
</head>
<body>


<?php

include("menu.html");

?>



  <h1>Liste des voitures d'occasion</h1>
  

  <form action="filtrer_voitures.php" method="GET" onsubmit="event.preventDefault(); filtrerVoitures(this);">
    <label for="kiloMin">Kilométrage minimum :</label>
    <input type="number" name="kiloMin" id="kiloMin">
    <input type="number" name="kiloMax" id="kiloMax">
    <button type="submit">Filtrer par kilométrage</button>
    <a href="#" onclick="event.preventDefault(); $('form').trigger('reset'); filtrerVoitures(this.form);">Réinitialiser le filtre</a>
  </form>

  <form action="filtrer_voitures.php" method="GET" onsubmit="event.preventDefault(); filtrerVoitures(this);">
    <label for="prixMin">Prix minimum :</label>
    <input type="number" name="prixMin" id="prixMin">
    <input type="number" name="prixMax" id="prixMax">
    <button type="submit">Filtrer par prix</button>
    <a href="#" onclick="event.preventDefault(); $('form').trigger('reset'); filtrerVoitures(this.form);">Réinitialiser le filtre</a>
  </form>

  <form action="filtrer_voitures.php" method="GET" onsubmit="event.preventDefault(); filtrerVoitures(this);">
    <label for="anneeMin">Année minimum :</label>
    <input type="number" name="anneeMin" id="anneeMin">
    <input type="number" name="anneeMax" id="anneeMax">
    <button type="submit">Filtrer par année de mise en circulation</button>
    <a href="#" onclick="event.preventDefault(); $('form').trigger('reset'); filtrerVoitures(this.form);">Réinitialiser le filtre</a>
  </form>

  <div class="car-gallery">
    <?php while($row = $result->fetch_assoc()): ?>
      <a href="voiture.php?id=<?php echo $row['id']; ?>" class="car-card">
        <h3><?php echo $row['nom']; ?></h3>
        <img class="car-image" src="data:image/jpeg;base64,<?php echo base64_encode($row['image_principale']); ?>" alt="Image de la voiture">
        <p class="blacktext"><strong>Modèle:</strong> <?php echo $row['modele']; ?></p>
        <p class="blacktext"><strong>Année:</strong> <?php echo $row['annee']; ?></p>
        <p class="blacktext"><strong>Kilométrage:</strong> <?php echo $row['kilometrage']; ?> km</p>
        <p class="blacktext"><strong>Prix:</strong> <?php echo $row['prix']; ?> €</p>
      </a>
    <?php endwhile; ?>
  </div>

  <!-- Scripts JavaScript -->
  <script src="./script.js"></script>  
</body>
</html>
