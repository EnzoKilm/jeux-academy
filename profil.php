<!DOCTYPE html>
<html lang="fr">
<?php session_start(); ?>
<?php $page = 'profil';?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Academy | Profil</title>
    
    <?php include 'head.html';?>
</head>

<body>
    <?php include 'nav.php';?>

    <!-- On récupère les infos pour les afficher sur la page -->
    <?php
        // On récupère l'pseudo souhaité
        $pseudo = $_REQUEST['pseudo'];
        // Connexion à la bage de données
        $db_username = 'root';
        $db_password = '';
        $db_name     = 'jeux-academy';
        $db_host     = 'localhost';
        $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
                or die('Connexion à la base de données impossible.');
                            
        // On spécifie l'encodage qu'on reçoit
        $db -> set_charset("utf8");

        // Si le pseudo cherché est celui de l'utilisateur connecté
        if ($_SESSION['pseudo'] == $_REQUEST['pseudo']) {
            // On affiche son profil
            $pseudo = $_SESSION['pseudo'];
            include 'profil_content.php';
        } else {
            // On regarde si le pseudo est dans la base de données
            $requete = "SELECT pseudo FROM users";
            $exec_requete = mysqli_query($db,$requete);
            // On regarde chaque si le pseudo correspond au pseudo d'un membre
            while ($row = mysqli_fetch_array($exec_requete)) {
                if ($row[0] == $_REQUEST['pseudo']) {
                    $pseudo_find = $row;
                    break;
                }
            }
            // Si on a trouvé une correspondance
            if (isset($pseudo_find)) {
                // On affiche le profil
                include 'profil_content.php';
            } else {
                // Sinon on affiche un message d'erreur
                echo '<div id="main"><div class="fof"><h1>Erreur 404</h1><br/><h5>La personne recherchée n\'existe pas</h5></div></div>';
            }
        }
    ?>
    
    <!-- Footer -->
    <?php include 'footer.html';?>
</body>

</html>
