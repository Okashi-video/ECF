# ECF

# Instructions pour l'exécution en local

## Prérequis
- Serveur Web (par exemple, Apache)
- PHP
- MySQL

## Étape 1: Configuration de la base de données
1. Assurez-vous que votre serveur MySQL est en cours d'exécution.
2. Ouvrez le fichier `admin_dashboard.php` et `employe_dashboard.php`.
3. Recherchez les lignes suivantes dans les fichiers :
    ```php
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";
    ```
4. Modifiez les valeurs des variables `$servername`, `$username`, `$password` et `$dbname` selon votre configuration de base de données.

## Étape 2: Configuration du serveur Web
1. Placez tous les fichiers PHP dans le répertoire de votre serveur Web.

## Étape 3: Exécution des scripts
1. Assurez-vous que votre serveur Web et votre serveur MySQL sont en cours d'exécution.
2. Accédez à `admin_dashboard.php` dans votre navigateur pour accéder au tableau de bord administrateur.
3. Pour accéder au tableau de bord employé, accédez à `employe_dashboard.php` dans votre navigateur.



##Etape 4 : Création d’un compte administrateur
1.modifier la variable ‘$password’ du fichier ‘codegenmdphash.php’
2.Ouvrez le dans un navigateur, vous obtenez le hash à modifier dans la base de données 
3.Ouvrez la base de données puis éditer le nom d’utilisateur et le mot de passe que vous souhaitez dans la ligne et la table adéquate.
