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
    
    // On spécifie l'encodage qu'on reçoit
    $db -> set_charset("utf8");
    
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
        // 0:id / 1:nom / 2:display_name / 3:developpeur
        $requete = "SELECT * FROM jeux WHERE nom='".$nom_find[0]."'";
        $exec_requete = mysqli_query($db,$requete);
        $infos_jeu = mysqli_fetch_array($exec_requete);

        // On récupère des jeux aléatoires pour les afficher sur les côtés
        // On commence par récupérer le nombre de jeux
        $requete = "SELECT COUNT(*) FROM jeux";
        $exec_requete = mysqli_query($db,$requete);
        $nombre_jeux = mysqli_fetch_array($exec_requete); // nombre_jeux[0]

        $excluded_games = array();
        // On cherche le jeu actuel et on l'exclut de notre liste de jeux à afficher
        for ($i = $nombre_jeux[0]; $i > 0; $i--) {
            if ($i == $infos_jeu[0]) {
                array_push($excluded_games, $i);
            }
        }

        $random_games = array();
        // Pour chacun des quatres emplacements de jeux
        for ($i = 3; $i > 0; $i--) {
            $infos_random_game = array();
            $random_id = rand(1, $nombre_jeux[0]);
            // Si le nombre ne correspond pas au jeu actuel ou à un jeu déjà affiché
            if (!in_array($random_id, $excluded_games)) {
                // On récupère les infos du jeu
                // 0:id / 1:nom / 2:display_name / 3:developpeur
                $requete = "SELECT * FROM jeux WHERE id='".$random_id."'";
                $exec_requete = mysqli_query($db,$requete);
                $infos_jeu_random= mysqli_fetch_array($exec_requete);
                array_push($infos_random_game, $infos_jeu_random[1], $infos_jeu_random[2]);

                // On exclut l'id qui vient de tomber
                array_push($excluded_games, $random_id);

            } else if ($random_id - sizeof($excluded_games) == 0) {
                array_push($infos_random_game, 'wip', 'Coming soon');
            } else {
                array_push($infos_random_game, 'wip', 'Coming soon');
            }
            array_push($random_games, $infos_random_game);
        }
    }

    // Gestion des votes du jeu
    // if (isset($_REQUEST['vote'])) {
    //     if($_REQUEST['vote'] == 'up') {
    //         // On regarde si le joueur a déjà voté
    //         $requete = "SELECT * FROM $infos_jeu[2].'_users' WHERE id_joueur='".$_SESSION['id']."'";
    //         $exec_requete = mysqli_query($db,$requete);
    //         $joueur_vote = mysqli_fetch_array($exec_requete);
    //         echo $joueur_vote;
    //     }
    // }

    mysqli_close($db); // On ferme la connexion
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Academy | <?php echo $infos_jeu[2]; ?></title>
    <link rel="icon" href="images/favicon.ico" />

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
                        <a class="cercle" id="up" href="jeu.php?jeu=<?php echo $infos_jeu[1]; ?>&vote=up" title="Up">
                        <i class="far fa-thumbs-up"></i></a>
                    </li>
                    <li>
                        <a class="cercle" id="down" href="jeu.php?jeu=<?php echo $infos_jeu[1]; ?>&vote=down" title="Down">
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
                <a href="jeu.php?jeu=<?php echo $random_games[0][0]; ?>">
                    <img src="images/miniatures/<?php echo $random_games[0][0]; ?>.png">
                    <h4><?php echo $random_games[0][1]; ?></h4>
                </a>
            </div>
            <div class="jeu_random" id="middle">
                <a href="jeu.php?jeu=<?php echo $random_games[1][0]; ?>">
                    <img src="images/miniatures/<?php echo $random_games[1][0]; ?>.png">
                    <h4><?php echo $random_games[1][1]; ?></h4>
                </a>
            </div>
            <div class="jeu_random">
                <a href="jeu.php?jeu=<?php echo $random_games[2][0]; ?>">
                    <img src="images/miniatures/<?php echo $random_games[2][0]; ?>.png">
                    <h4><?php echo $random_games[2][1]; ?></h4>
                </a>
            </div>
        </div>
    </div>
    <!-- /.container -->
    
    <!-- Footer -->
    <?php include 'footer.html';?>
</body>

</html>
