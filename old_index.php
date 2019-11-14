<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title>Jeux Academy | Accueil</title>
    <!-- Lien pour les icones -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!--https://fr.pngtree.com-->
    <link rel="icon" type="image/png" href="images/favicon.png" />
  </head>

  <body>

    <aside id="navigateur">
        <h4>Top jeux</h4><hr/>
        <h4>Top catégories</h4><hr/>
        <h4>Top joueurs</h4><hr/>
    </aside>

    <header>
      <h1>Jeux Academy</h1>
    </header>

    <div id="navbar">
        <ul>
            <li><a href="index.php">Accueil</a></li>
        </ul>
        <ul>
            <li>
                <form class="example" action="action_page.php">
                    <input type="text" placeholder="Recherche..." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </li>
        </ul>
        <ul>
            
            
            <!-- tester si l'utilisateur est connecté -->
            <?php
                session_start();
                if(isset($_GET['deconnexion'])) { 
                   if($_GET['deconnexion']==true) {  
                      session_unset();
                      header("location:index.php");
                    }
                }
                else if(isset($_SESSION['pseudo'])) {
                    $user = $_SESSION['pseudo'];
                    echo "Bonjour $user, vous êtes connectés";
                    echo "<li><a href='index.php?deconnexion=true'><span>Déconnexion</span></a></li>";
                }
                else {
                    echo "<li><a href='login.php'>Connexion</a></li>";
                }
            ?>
            
        </div>
        </ul>
    </div>

    <footer>

    </footer>

  </body>

  <!--<script type="text/javascript" src="js/file.js"></script>-->

</html>
