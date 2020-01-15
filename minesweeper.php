<!DOCTYPE html>
<html lang="fr">
<?php $page = 'jeu';?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Academy | Démineur</title>

    <style>
     * { padding: 0; margin: 0; }
     div.jeu { background: #eee no-repeat center center; display: block; margin: 0 auto; border-style: solid; height: 640px; width: 916px; box-sizing: unset;}
     button { display: block; margin: auto; }
    </style>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/minesweeper.css" type="text/css" rel="stylesheet" />

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
            <!-- <?php
                // connexion à la base de données
                $db_username = 'root';
                $db_password = 'admindb';
                $db_name     = 'jeux-academy';
                $db_host     = 'localhost';
                $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
                        or die('Connexion à la base de données impossible.');

                // On récupère l'id du joueur
                $sql = "SELECT id FROM users where pseudo = '".$_SESSION['pseudo']."'";
                $result = mysqli_query($db,$sql);
                $value = mysqli_fetch_array($result);
                $id = $value[0];

                // On regarde le niveau du joueur
                $requete = "SELECT niveau FROM casse_briques_users where id_joueur = '".$id."'";
                $exec_requete = mysqli_query($db,$requete);
                $reponse = mysqli_fetch_array($exec_requete);
                $niveau = $reponse[0];

                // Si le joueur n'a pas encore joué au jeu
                if(isset($resultat)) {
                    // On ajoute ses infos dans la table du jeu dans la db
                    $requete = "INSERT INTO casse_briques_users(id_joueur,niveau) VALUES ('".$id."',1)";
                }
                
                $requete = "SELECT map FROM casse_briques_settings WHERE id = '".$niveau."'";
                $result = mysqli_query($db,$requete);
                $value = mysqli_fetch_array($result);
                $map = $value[0];

                mysqli_close($db); // fermer la connexion            
            ?> -->
        </div>
        <!-- /.row -->
        
        <!-- <br/><canvas id="cassebriques" width="916" height="640"></canvas><br/> -->
        <br/>
        <div class="jeu">
            <div class="minesweeper">
                <div id="left" class="result"></div>
                <div class="game" id="plateau"></div>
                <div id="right" class="result"></div>
                
                <div class="options">
                    <div class="menus">
                        <div class="menu" onclick="MineSweeper.startGame('easy');">
                            <p>Niveau facile</p>
                        </div>
                        <div class="menu" onclick="MineSweeper.startGame('normal');">
                            <p>Niveau normal</p>
                        </div>
                        <div class="menu" onclick="MineSweeper.startGame('hard');">
                            <p>Niveau difficile</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        

    </div>
    <!-- /.container -->
    
    <!-- Footer -->
    <?php include 'footer.html';?>

    <!-- Scripts -->
    <script src="js/minesweeper.js"></script>
    <script>
    /* on load scripts */
    window.onload = function() {
        MineSweeper.initialise();
    }
</script>
</body>

</html>
