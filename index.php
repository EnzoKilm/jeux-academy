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
    <link rel="icon" href="images/favicon.ico" />

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/79706d8da0.js" crossorigin="anonymous"></script>
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
                <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                        <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="First slide">
                        </div>
                        <div class="carousel-item">
                        <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Second slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
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
                            echo '<div class="card-footer"><small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small></div>';
                            echo '</div></div>';
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
                            echo '<div class="card-footer"><small class="text-muted"></small></div>';
                            echo '</div></div>';
                        }
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
    
    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fontawesome.js"></script>
</body>

</html>
