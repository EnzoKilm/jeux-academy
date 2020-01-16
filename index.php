<!DOCTYPE html>
<html lang="fr">
<?php $page = 'index';?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Academy | Accueil</title>

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
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                        <p class="card-image-jeu"><a href="jeu.php?jeu=cassebriques"><img class="card-img-top" src="images/cassebriques.png" alt="Casse briques"></a></p>
                        <div class="card-body">
                            <h4 class="card-title">
                            <a href="cassebriques.php">Casse briques</a>
                            </h4>
                            <h5>Nouveau</h5>
                            <p class="card-text">Casse les briques à l'aide de la balle et de la raquette.</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                        <p class="card-image-jeu"><a href="jeu.php?jeu=demineur"><img class="card-img-top" src="images/demineur.png" alt="Démineur"></a></p>
                        <div class="card-body">
                            <h4 class="card-title">
                            <a href="demineur.php">Démineur</a>
                            </h4>
                            <h5>Nouveau</h5>
                            <p class="card-text">Dévoile toutes les cases mais évite de toucher une bombe...</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                        <p class="card-image-jeu"><a href="#"><img class="card-img-top" src="images/wip.jpg" alt="Travaux"></a></p>
                        <div class="card-body">
                            <h4 class="card-title">
                            <a href="#"><i class="fas fa-exclamation-triangle"></i> Coming soon <i class="fas fa-exclamation-triangle"></i></a>
                            </h4>
                            <h5></h5>
                            <p class="card-text">Nos développeurs te préparent de nouveaux jeux, patience!</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                        </div>
                        </div>
                    </div>
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
