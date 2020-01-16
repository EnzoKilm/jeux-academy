<!DOCTYPE html>
<html lang="fr">
<?php $page = 'jeu';?>
<?php
    // connexion à la base de données
    $db_username = 'root';
    $db_password = 'admindb';
    $db_name     = 'jeux-academy';
    $db_host     = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
            or die('Connexion à la base de données impossible.');

    // On regarde si le jeu existe
    $requete = "SELECT nom FROM jeux";
    $exec_requete = mysqli_query($db,$requete);
    // On regarde chaque si le pseudo correspond au pseudo d'un membre
    while ($row = mysqli_fetch_array($exec_requete)) {
        if ($row[0] == $_REQUEST['jeu']) {
            $nom_find = $row;
            break;
        }
    }
    // Si on a pas trouvé une correspondance
    if (!isset($nom_find)) {
        // On affiche le profil
        header('Location: 404.php');
    } else {
        // On récupère les infos du jeu
        // 0:id / 1:nom / 2:display_name / 3:developpeur / 4:note_positive / 5:note_negative
        $requete = "SELECT * FROM jeux WHERE nom='".$nom_find[0]."'";
        $exec_requete = mysqli_query($db,$requete);
        $infos_jeu = mysqli_fetch_array($exec_requete);
    }
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Academy | Démineur</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/jeu.css" type="text/css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/79706d8da0.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'nav.php';?>

    <!-- Page Content -->
    <div class="container" id="game">
        <div class="infos_jeu">
            <div class="titre">
                <h1><?php echo $infos_jeu[2]; ?></h1>
                <hr/>
                <h2>par : <?php echo $infos_jeu[3]; ?></h2>
            </div>
            <div class="stats">
                <h3>Statistiques</h3>
                <hr/>
            </div>
            <div class="vote">
                <h4>Vote pour le jeu !</h4>
                <hr/>
                <ul class="rs">
                    <li>
                        <a class="cercle" id="up" target="_blank" href="#" title="Up">
                        <i class="far fa-thumbs-up"></i></a>
                    </li>
                    <li>
                        <a class="cercle" id="down" target="_blank" href="#" title="Down">
                        <i class="far fa-thumbs-down"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <br/>
        <?php include $_REQUEST['jeu'].'.php';?>
        <br/>
        <div class="autres_jeux">
            <div class="jeu_random">

            </div>
            <div class="jeu_random">

            </div>
            <div class="jeu_random">

            </div>
            <div class="jeu_random">

            </div>
        </div>
    </div>
    <!-- /.container -->
    
    <!-- Footer -->
    <?php include 'footer.html';?>
</body>

</html>
