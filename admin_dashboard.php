<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: login.php");
    exit();
}

  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $service_name = $_POST['service_name'];
    $service_price = $_POST['service_price'];

    $updateQuery = "UPDATE services SET service_price = $service_price WHERE service_name = '$service_name'";
    if ($conn->query($updateQuery) === true) {
        $success_message = "Le service a été modifié avec succès.";
    } else {
        $error_message = "Une erreur est survenue lors de la modification du service.";
    }
}

if (isset($_POST['add'])) {
    $service_name = $_POST['new_service_name'];
    $service_price = $_POST['new_service_price'];


    $insertQuery = "INSERT INTO services (service_name, service_price) VALUES ('$service_name', $service_price)";
    if ($conn->query($insertQuery) === true) {
        $success_message = "Le service a été ajouté avec succès.";
    } else {
        $error_message = "Une erreur est survenue lors de l'ajout du service.";
    }
}


if (isset($_POST['delete'])) {
    $service_name = $_POST['delete_service_name'];


    $deleteQuery = "DELETE FROM services WHERE service_name = '$service_name'";
    if ($conn->query($deleteQuery) === true) {
        $success_message = "Le service a été supprimé avec succès.";
    } else {
        $error_message = "Une erreur est survenue lors de la suppression du service.";
    }
}


$servicesQuery = "SELECT * FROM services";
$servicesResult = $conn->query($servicesQuery);


if (isset($_POST['update_hours'])) {
    $opening_hours = array();


    for ($i = 1; $i <= 7; $i++) {
        $day = "day" . $i;
        $start_time = $_POST[$day . "_start"];
        $end_time = $_POST[$day . "_end"];
        $opening_hours[$i] = array("start_time" => $start_time, "end_time" => $end_time);
    }


    $updateHoursQuery = "UPDATE opening_hours SET start_time = CASE day";
    $updateHoursQuery .= " WHEN 1 THEN '{$opening_hours[1]['start_time']}'";
    $updateHoursQuery .= " WHEN 2 THEN '{$opening_hours[2]['start_time']}'";
    $updateHoursQuery .= " WHEN 3 THEN '{$opening_hours[3]['start_time']}'";
    $updateHoursQuery .= " WHEN 4 THEN '{$opening_hours[4]['start_time']}'";
    $updateHoursQuery .= " WHEN 5 THEN '{$opening_hours[5]['start_time']}'";
    $updateHoursQuery .= " WHEN 6 THEN '{$opening_hours[6]['start_time']}'";
    $updateHoursQuery .= " WHEN 7 THEN '{$opening_hours[7]['start_time']}'";
    $updateHoursQuery .= " END, end_time = CASE day";
    $updateHoursQuery .= " WHEN 1 THEN '{$opening_hours[1]['end_time']}'";
    $updateHoursQuery .= " WHEN 2 THEN '{$opening_hours[2]['end_time']}'";
    $updateHoursQuery .= " WHEN 3 THEN '{$opening_hours[3]['end_time']}'";
    $updateHoursQuery .= " WHEN 4 THEN '{$opening_hours[4]['end_time']}'";
    $updateHoursQuery .= " WHEN 5 THEN '{$opening_hours[5]['end_time']}'";
    $updateHoursQuery .= " WHEN 6 THEN '{$opening_hours[6]['end_time']}'";
    $updateHoursQuery .= " WHEN 7 THEN '{$opening_hours[7]['end_time']}'";
    $updateHoursQuery .= " END";

    if ($conn->query($updateHoursQuery) === true) {
        $success_message = "Les horaires d'ouverture ont été mis à jour avec succès.";
    } else {
        $error_message = "Une erreur est survenue lors de la mise à jour des horaires d'ouverture.";
    }
}


$hoursQuery = "SELECT * FROM opening_hours";
$hoursResult = $conn->query($hoursQuery);
$opening_hours = array();

while ($row = $hoursResult->fetch_assoc()) {
    $opening_hours[$row['day']] = array("start_time" => $row['start_time'], "end_time" => $row['end_time']);
}


if (isset($_POST['delete_message'])) {
    $message_id = $_POST['message_id'];


    $deleteMessageQuery = "DELETE FROM contact_messages WHERE id = $message_id";
    if ($conn->query($deleteMessageQuery) === true) {
        $success_message = "Le message a été supprimé avec succès.";
    } else {
        $error_message = "Une erreur est survenue lors de la suppression du message.";
    }
}


$messagesQuery = "SELECT * FROM contact_messages";
$messagesResult = $conn->query($messagesQuery);


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord administrateur</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tableau de bord administrateur</h1>
    <p>Bienvenue, Vincent Parrot (Administrateur)!</p>
  
  
    <?php if (isset($success_message)): ?>
        <p><?php echo $success_message; ?></p>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
  
   
    <h2>Modifier les services de réparation automobile</h2>
    <form method="post" action="">
        <label for="service_name">Nom du service :</label>
        <select name="service_name" id="service_name" required>
            <?php while ($service = $servicesResult->fetch_assoc()): ?>
                <option value="<?php echo $service['service_name']; ?>"><?php echo $service['service_name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="service_price">Prix du service :</label>
        <input type="number" name="service_price" id="service_price" required><br>

        <input type="submit" name="submit" value="Modifier le service">
    </form>

    
  
  
    <h2>Ajouter un nouveau service de réparation automobile</h2>
    <form method="post" action="">
        <label for="new_service_name">Nom du service :</label>
        <input type="text" name="new_service_name" id="new_service_name" required><br>

        <label for="new_service_price">Prix du service :</label>
        <input type="number" name="new_service_price" id="new_service_price" required><br>

        <input type="submit" name="add" value="Ajouter le service">
    </form>

  
  
    <h2>Supprimer un service de réparation automobile</h2>
    <form method="post" action="">
        <label for="delete_service_name">Nom du service :</label>
        <select name="delete_service_name" id="delete_service_name" required>
            <?php $servicesResult->data_seek(0); ?>
            <?php while ($service = $servicesResult->fetch_assoc()): ?>
                <option value="<?php echo $service['service_name']; ?>"><?php echo $service['service_name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <input type="submit" name="delete" value="Supprimer le service">
    </form>

  
  
  
    <h2>Modifier les horaires d'ouverture du magasin</h2>
    <form method="post" action="">
        <?php for ($i = 1; $i <= 7; $i++): ?>
            <label for="day<?php echo $i; ?>_start">Heure d'ouverture pour le jour <?php echo $i; ?>:</label>
            <input type="time" name="day<?php echo $i; ?>_start" id="day<?php echo $i; ?>_start" value="<?php echo $opening_hours[$i]['start_time']; ?>" required><br>

            <label for="day<?php echo $i; ?>_end">Heure de fermeture pour le jour <?php echo $i; ?>:</label>
            <input type="time" name="day<?php echo $i; ?>_end" id="day<?php echo $i; ?>_end" value="<?php echo $opening_hours[$i]['end_time']; ?>" required><br>
        <?php endfor; ?>

        <input type="submit" name="update_hours" value="Mettre à jour les horaires d'ouverture">
    </form>

   
  
    <h2>Messages de contact</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Adresse e-mail</th>
            <th>Numéro de téléphone</th>
            <th>Objet</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
        <?php while ($message = $messagesResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $message['nom']; ?></td>
                <td><?php echo $message['prenom']; ?></td>
                <td><?php echo $message['email']; ?></td>
                <td><?php echo $message['telephone']; ?></td>
                <td><?php echo $message['objet']; ?></td>
                <td><?php echo $message['message']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                        <input type="submit" name="delete_message" value="Supprimer">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="logout.php">Se déconnecter</a>
</body>
</html>
