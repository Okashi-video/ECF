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
  <title>Pannel employer</title>
  
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
    

    $(document).ready(function() {
      filtrerVoitures($('form').first());
    });
  </script>
</head>
<body>
 
 
  <h1>Liste des voitures d'occasion</h1>
  
 
  <form action="filtrer_voitures.php" method="GET" onsubmit="event.preventDefault(); filtrerVoitures(this);">
    <label for="kiloMin">Kilométrage minimum :</label>
    <input type="number" name="kiloMin" id="kiloMin">
    <label for="kiloMax">Kilométrage maximum :</label>
    <input type="number" name="kiloMax" id="kiloMax">
    <br><br>
    <button type="submit">Filtrer par kilométrage</button>
    <br><br>
    <a href="#" onclick="event.preventDefault(); $('form').trigger('reset'); filtrerVoitures(this.form);">Réinitialiser le filtre</a>
  </form>

  <form action="filtrer_voitures.php" method="GET" onsubmit="event.preventDefault(); filtrerVoitures(this);">
    <label for="prixMin">Prix minimum :</label>
    <input type="number" name="prixMin" id="prixMin">
    <label for="prixMax">Prix maximum :</label>
    <input type="number" name="prixMax" id="prixMax">
    <br><br>
    <button type="submit">Filtrer par prix</button>
    <br><br>
    <a href="#" onclick="event.preventDefault(); $('form').trigger('reset'); filtrerVoitures(this.form);">Réinitialiser le filtre</a>
  </form>

  <form action="filtrer_voitures.php" method="GET" onsubmit="event.preventDefault(); filtrerVoitures(this);">
    <label for="anneeMin">Année minimum :</label>
    <input type="number" name="anneeMin" id="anneeMin">
    <label for="anneeMax">Année maximum :</label>
    <input type="number" name="anneeMax" id="anneeMax">
    <br><br>
    <button type="submit">Filtrer par année de mise en circulation</button>
    <br><br>
    <a href="#" onclick="event.preventDefault(); $('form').trigger('reset'); filtrerVoitures(this.form);">Réinitialiser le filtre</a>
  </form>

  <div class="car-gallery">
 
  </div>










  <h2>Laissez un avis</h2>
<form action="ajouter_avis.php" method="POST" onsubmit="return validateForm();">
  <label for="nom">Nom :</label>
  <input type="text" name="nom" id="nom" required>

  <label for="commentaire">Commentaire :</label>
  <textarea name="commentaire" id="commentaire" required></textarea>

  <label for="note">Note :</label>
  <input type="number" name="note" id="note" min="1" max="5" required>

  <button type="submit">Envoyer l'avis</button>
</form>










  <?php

  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}


$query = "SELECT * FROM avis WHERE valide = 0";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>Avis en attente de validation</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "<h3>Avis de " . $row["nom"] . "</h3>";
        echo "<p>Commentaire : " . $row["commentaire"] . "</p>";
        echo "<p>Note : " . $row["note"] . "</p>";
        echo "<form action='valider_avis.php' method='POST'>";
        echo "<input type='hidden' name='avis_id' value='" . $row["id"] . "'>";
        echo "<button type='submit'>Valider l'avis</button>";
        echo "</form>";

        echo "<form action='supprimer_avis.php' method='POST'>";
        echo "<input type='hidden' name='avis_id' value='" . $row["id"] . "'>";
        echo "<button type='submit'>Supprimer l'avis</button>";
        echo "</form>";

    }
} else {
    echo "<p>Aucun avis en attente de validation.</p>";
}


$conn->close();
?>
<a href="logout.php">Se déconnecter</a>

 
  <script src="./script.js"></script>  
</body>
</html>
