<!DOCTYPE html>
<html lang="fr">
<?php session_start(); ?>
<?php $page = 'index';?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Academy | Accueil</title>
    
    <?php include 'head.html';?>
</head>

<body>
    <?php include 'nav.php';?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h1 class="my-4"><i class="fas fa-trophy"></i> Les tops</h1>
                <img src="images/trophee.png" alt="Trophée" id="trophee">
                <div class="list-group">
                <a href="#" class="list-group-item">Jeux</a>
                <a href="#" class="list-group-item">Joueurs</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">
                <div id="nouvaute" class="carousel slide my-4" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#nouvaute" data-slide-to="0" class="active"></li>
                        <li data-target="#nouvaute" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
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

                            // On récupère le nombre de jeux
                            $requete = "SELECT count(*) FROM jeux";
                            $exec_requete = mysqli_query($db,$requete);
                            $count_games = mysqli_fetch_array($exec_requete);

                            if ($count_games[0] >= 1) {
                                // On récupère les infos du premier jeu
                                // 0:id / 1:nom / 2:display_name / 3:developpeur / 4:description
                                $requete = "SELECT * FROM jeux WHERE id=".$count_games[0]."";
                                $execution_requete = mysqli_query($db,$requete);
                                $infos_jeu = mysqli_fetch_array($execution_requete);

                                // On affiche le premier jeu
                                echo '<div class="carousel-item active"><a href="jeu.php?jeu='.$infos_jeu[1].'"><img class="d-block img-fluid" src="images/miniatures/'.$infos_jeu[1].'.png" alt="'.$infos_jeu[2].'"></a></div>';

                                if ($count_games >= 2) {
                                    // On récupère les infos du deuxième jeu
                                    // 0:id / 1:nom / 2:display_name / 3:developpeur / 4:description
                                    $id_second_game = $count_games[0] - 1;
                                    $requete = "SELECT * FROM jeux WHERE id=".$id_second_game."";
                                    $execution_requete = mysqli_query($db,$requete);
                                    $infos_jeu = mysqli_fetch_array($execution_requete);

                                    // On affiche le deuxième jeu
                                    echo '<div class="carousel-item"><a href="jeu.php?jeu='.$infos_jeu[1].'"><img class="d-block img-fluid" src="images/miniatures/'.$infos_jeu[1].'.png" alt="'.$infos_jeu[2].'"></a></div>';
                                } else {
                                    echo '<div class="carousel-item"><img class="d-block img-fluid" src="images/miniatures/wip.png" alt="Travaux"></div>';
                                }
                            } else {
                                echo '<div class="carousel-item active"><img class="d-block img-fluid" src="images/miniatures/wip.png" alt="Travaux"></div>';
                            }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#nouvaute" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#nouvaute" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </div>

                <div class="row">
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

                        // On récupère les noms des jeux
                        $requete = "SELECT nom FROM jeux";
                        $exec_requete = mysqli_query($db,$requete);
                        $nb_games = 3;
                        while ($row = mysqli_fetch_array($exec_requete)) {
                            $nb_games -= 1;
                            if ($nb_games == 0) {
                                $nb_games = 3;
                            }
                            // On récupère les infos du jeu
                            // 0:id / 1:nom / 2:display_name / 3:developpeur / 4:description
                            $requete = "SELECT * FROM jeux WHERE nom='".$row[0]."'";
                            $execution_requete = mysqli_query($db,$requete);
                            $infos_jeu = mysqli_fetch_array($execution_requete);
                            
                            // On affiche le jeu
                            echo '<div class="col-lg-4 col-md-6 mb-4"><div class="card h-100">';
                            echo '<p class="card-image-jeu"><a href="jeu.php?jeu='.$infos_jeu[1].'">';
                            echo '<img class="card-img-top" src="images/miniatures/'.$infos_jeu[1].'.png" alt="'.$infos_jeu[2].'"></a></p>';
                            echo '<div class="card-body"><h4 class="card-title">';
                            echo '<a href="jeu.php?jeu='.$infos_jeu[1].'">'.$infos_jeu[2].'</a></h4>';
                            echo '<p class="card-text">'.$infos_jeu[4].'</p></div>';

                            // Affichage du nombre d'étoiles selon les votes des joueurs
                            $request = "SELECT vote FROM ".$row[0]."_users";
                            $requete_exec = mysqli_query($db,$request);

                            $notes_positives = 1;
                            $nombre_notes = 1;
                            while ($colonne = mysqli_fetch_array($requete_exec)) {
                                if ($colonne[0] == 1) {
                                    $notes_positives += 1;
                                    $nombre_notes += 1;
                                } else if ($colonne[0] == null) {
                                    $nombre_notes -= 1;
                                } else {
                                    $nombre_notes += 1;
                                }
                            }
                            $notes_positives /= $nombre_notes;
                            $etoiles = round($notes_positives*5, 1);

                            echo '<div class="card-footer"><div class="star-rating" title="'.$etoiles.'/5"><div class="back-stars">';
                            for ($i = 0; $i < 5; $i++) {
                                echo '<i class="fa fa-star" aria-hidden="true"></i>';
                            }
                            $etoiles_pourcent = $etoiles * 20;
                            $etoiles_pourcent = $etoiles_pourcent.'%';
                            echo '<div class="front-stars" style="width: '.$etoiles_pourcent.'">';
                            for ($i = 0; $i < 5; $i++) {
                                echo '<i class="fa fa-star" aria-hidden="true"></i>';
                            }
                            echo '</div></div></div></div></div></div>';
                        }

                        if ($nb_games == 3) {
                            $nb_games = 0;
                        }

                        for ($i = 0; $i < $nb_games; $i++) {
                            // On affiche le jeu
                            echo '<div class="col-lg-4 col-md-6 mb-4"><div class="card h-100">';
                            echo '<p class="card-image-jeu"><a href="#">';
                            echo '<img class="card-img-top" src="images/miniatures/wip.png" alt="Travaux"></a></p>';
                            echo '<div class="card-body"><h4 class="card-title">';
                            echo '<a href="#"><i class="fas fa-exclamation-triangle"></i> Coming soon <i class="fas fa-exclamation-triangle"></i></a></h4>';
                            echo '<p class="card-text">Nos développeurs te préparent de nouveaux jeux, patience!</p></div>';
                            echo '</div></div>';
                        }
                        
                        mysqli_close($db); // fermer la connexion
                    ?>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.col-lg-9 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include 'footer.html';?>
</body>

</html>
