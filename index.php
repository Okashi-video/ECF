<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Garage V.Parrot</title>
  
  <meta name="description" content="Site internet du Garage V. Parrot ">
  <meta name="keywords" content="garage, qualité, fiable">
  <meta name="author" content="Vincent Parrot">
  

  <link rel="canonical" href="https://furyx.fr/">
  
  <meta name="language" content="fr">
  
 
  


  <link rel="stylesheet" href="menu.css">
  <link rel="stylesheet" href="menustyle.css">

  <style>

.section-services {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-top: 20px;
  margin-bottom: 40px;
}

.section-services h2 {
  color: #333;
  margin-top: 30px;
  text-align: center;
}

.section-services ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.section-services li {
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  justify-content: center; /* Ajout de la propriété pour centrer le contenu horizontalement */
  background-color: #f8f8f8;
  border-radius: 10px;
  padding: 15px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
  width: 450px;
}

.section-services li:hover {
  transform: translateY(-5px);
  background-color: #e0e0e0;
}

.section-services li strong {
  color: #333;
  font-weight: bold;
  margin-right: 10px;
}

.section-services li span {
  color: #555;
}







.section-avis {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-top: 40px;
  margin-bottom: 40px;
  background-color: #F0F2F5;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.1),
              -8px -8px 16px rgba(255, 255, 255, 0.7);
}

.section-avis h2 {
  color: #333;
  margin-top: 30px;
  text-align: center;
}

.section-avis .carousel {
  width: 500px;
  max-width: 700px;
  background-color: #F0F2F5;
  border-radius: 10px;
  padding: 20px;
  box-shadow: inset 6px 6px 12px rgba(0, 0, 0, 0.1),
              inset -6px -6px 12px rgba(255, 255, 255, 0.7);
  position: relative; /* Ajout de la position relative */
}

.section-avis .carousel-item {
  text-align: center;
  padding: 20px;
}

.section-avis .carousel-item li {
  margin-bottom: 10px;
  color: #333;
}

.section-avis .carousel-control-prev,
.section-avis .carousel-control-next {
  width: 40px;
  height: 40px;
  background-color: #adbbd1;
  border-radius: 50%;
  color: #333;
  font-size: 20px;
  line-height: 40px;
  text-align: center;
  opacity: 0.8;
  box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1),
              -4px -4px 8px rgba(255, 255, 255, 0.7);
  position: absolute; /* Ajout de la position absolue */
  top: 50%; /* Placement au centre vertical */
  transform: translateY(-50%); /* Décalage de 50% vers le haut */
}

.section-avis .carousel-control-prev {
  left: -80px; /* Placement à gauche */
}

.section-avis .carousel-control-next {
  right: -80px; /* Placement à droite */
}

.section-avis .carousel-control-prev:hover,
.section-avis .carousel-control-next:hover {
  opacity: 1;
}


  </style>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">

</head>

<body>	



<?php include("menu.html"); ?>




  <?php

  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

  $conn = new mysqli($servername, $username, $password, $dbname);


  if ($conn->connect_error) {
      die("La connexion a échoué: " . $conn->connect_error);
  }


  $hoursQuery = "SELECT * FROM opening_hours";
  $hoursResult = $conn->query($hoursQuery);
  $opening_hours = array();
  $fermeAffiche = false;

  while ($row = $hoursResult->fetch_assoc()) {
      $start_time = ($row['start_time'] === '00:00:00') ? 'Fermé' : date('H:i', strtotime($row['start_time']));
      $end_time = ($row['end_time'] === '00:00:00') ? 'Fermé' : date('H:i', strtotime($row['end_time']));
      
      if ($start_time === 'Fermé' && $end_time === 'Fermé' && !$fermeAffiche) {
          $opening_hours[$row['day']] = array(
              "start_time" => 'Fermé',
              "end_time" => ''
          );
          $fermeAffiche = true;
      } else {
          if ($start_time === $end_time) {
              $opening_hours[$row['day']] = array(
                  "start_time" => 'Fermé',
                  "end_time" => $end_time
              );
          } else {
              $opening_hours[$row['day']] = array(
                  "start_time" => $start_time,
                  "end_time" => $end_time
              );
          }
      }
  }


  $conn->close();
  ?>




  <div class="section-services">
  
  <h2>Liste des services de réparation automobile</h2>
  
  <?php

  $conn = new mysqli($servername, $username, $password, $dbname);


  if ($conn->connect_error) {
      die("La connexion a échoué: " . $conn->connect_error);
  }


  $servicesQuery = "SELECT * FROM services";
  $servicesResult = $conn->query($servicesQuery);

  if ($servicesResult->num_rows > 0) {
      echo "<ul>";
      while ($row = $servicesResult->fetch_assoc()) {
          echo "<li><strong>   " . $row["service_name"] . "</strong></li>";
          echo "<li> <span> Prix : " . $row["service_price"] . " € </span></li>";
          echo "<br>";
      }
      echo "</ul>";
  } else {
      echo "Aucun service trouvé.";
  }


  $conn->close();
  ?>

</div>



<div class="section-avis">
    <h2>Avis</h2>

    <?php

    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
      die("La connexion a échoué: " . $conn->connect_error);
    }



    $avisQuery = "SELECT * FROM avis WHERE valide = 1";
    $avisResult = $conn->query($avisQuery);

    if ($avisResult->num_rows > 0) {
      echo '<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">';
      $firstItem = true;
      while ($row = $avisResult->fetch_assoc()) {
        echo '<div class="carousel-item' . ($firstItem ? ' active' : '') . '">
                <li><strong>' . $row["nom"] . '</strong></li>
                <li><span>Commentaire : ' . $row["commentaire"] . '</span></li>
                <li><span>Note : ' . $row["note"] . '/5</span></li>
              </div>';
        $firstItem = false;
      }
      echo '</div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>';
    } else {
      echo "Aucun avis validé trouvé.";
    }

 
    $conn->close();
    ?>
  </div>




<div class="container">
  
  <div class="form-container">  


  <div class="test">

  
  <h2>Laissez un avis</h2>
  <form id="avis-form" action="ajouter_avis.php" method="POST" onsubmit="return validateForm();">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required>

    <label for="commentaire">Commentaire :</label>
    <textarea name="commentaire" id="commentaire" required></textarea>

    <label for="note">Note :</label>
    <input type="number" name="note" id="note" min="1" max="5" required>
<br>
    <button type="submit">Envoyer l'avis</button>
  </form>


  </div>

</div>


  <div class="form-container">


  <div class="test">


  <h1>Contactez-nous</h1>
<form id="contact-form" method="post" action="traitement_formulaire.php">
  <div class="form-row">
    <div class="form-column">
      <label for="nom">Nom :</label>
      <input type="text" name="nom" id="nom" required>
    </div>
    <div class="form-column">
      <label for="prenom">Prénom :</label>
      <input type="text" name="prenom" id="prenom" required>
    </div>
  </div>
  <div class="form-row">
    <div class="form-column">
      <label for="email">Adresse e-mail :</label>
      <input type="email" name="email" id="email" required>
    </div>
    <div class="form-column">
      <label for="telephone">Numéro de téléphone :</label>
      <input type="tel" name="telephone" id="telephone" required>
    </div>
  </div>
  <div class="form-row">
    <label for="objet">Objet :</label>
    <input type="text" name="objet" id="objet" required>
  </div>
  <div class="form-row">
    <label for="message">Message :</label>
    <textarea name="message" id="message" required></textarea>
  </div>
  <div class="form-row">
    <input type="submit" name="envoyer" value="Envoyer">
  </div>
</form>

</div>

  </div>
  
</div>


  <footer>
    <h3>Horaires d'ouverture</h3>
    <table>
      <?php for ($i = 1; $i <= 7; $i++): ?>
        <tr>
          <td><?php 
            switch ($i) {
              case 1:
                echo "Lun.";
                break;
              case 2:
                echo "Mar.";
                break;
              case 3:
                echo "Mer.";
                break;
              case 4:
                echo "Jeu.";
                break;
              case 5:
                echo "Ven.";
                break;
              case 6:
                echo "Sam.";
                break;
              case 7:
                echo "Dim.";
                break;
              default:
                echo "";
            }
          ?></td>
          <?php if ($opening_hours[$i]['start_time'] === 'Fermé'): ?>
            <td colspan="2"><?php echo $opening_hours[$i]['start_time']; ?></td>
          <?php else: ?>
            <td><?php echo $opening_hours[$i]['start_time']; ?></td>
            <td><?php echo $opening_hours[$i]['end_time']; ?></td>
          <?php endif; ?>
        </tr>
      <?php endfor; ?>
    </table>
    <p>Adresse : 123 rue du Magasin, Ville | Téléphone : 01 234 567 89 | Email : contact@example.com</p>
  </footer>


  <script src="script.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>



</body>
</html>
