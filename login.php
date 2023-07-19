<?php

  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}


if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $password = $_POST['password'];


    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];


        if (password_verify($password, $hashedPassword)) {
            $userType = $row['user_type'];


            session_start();
            $_SESSION['user'] = $userType;
            if ($userType == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: employe_dashboard.php");
            }
            exit();
        }
    }


    $error_message = "Identifiants invalides. Veuillez réessayer.";
}


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de connexion</title>


    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1>Connexion</h1>
    <?php if(isset($error_message)): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="email">Adresse e-mail:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" name="submit" value="Se connecter">
    </form>
</body>
</html>

