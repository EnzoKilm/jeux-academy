        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="nav">
            <div class="container" id="nav">
                <a class="navbar-brand" href="index.php"><i class="fas fa-gamepad"></i> Jeux Academy</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <form id="searchForm" class="research" action="recherche.php">
                        <input type="search" name="recherche" id="recherche" placeholder="Rercherche">
                    </form>
                    <?php
                    if($page == 'index') {
                        echo '<li class="nav-item"><a class="nav-link active" href="index.php"><i class="fas fa-home"></i> Accueil</a></li>';
                    }
                    else {
                        echo '<li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home"></i> Accueil</a></li>';
                    }
                        
                    if(isset($_GET['deconnexion'])) { 
                        if($_GET['deconnexion']==true) {  
                            session_unset();
                            header("location:index.php");
                        }
                    }
                    else if(isset($_SESSION['pseudo'])) {
                        if($page == 'profil') {
                            echo '<li class="nav-item"><a class="nav-link active" href="profil.php?pseudo='.$_SESSION['pseudo'].'"><i class="fas fa-user"></i> Profil</a></li>';
                        }
                        else {
                            echo '<li class="nav-item"><a class="nav-link" href="profil.php?pseudo='.$_SESSION['pseudo'].'"><i class="fas fa-user"></i> Profil</a></li>';
                        }
                        
                        echo '<li class="nav-item"><a class="nav-link" href="index.php?deconnexion=true"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>';
                    }
                    else {
                        if($page == 'login') {
                            echo '<a class="nav-link active" href="login.php"><i class="fas fa-sign-in-alt"></i> Connexion/inscription</a>';
                        }
                        else if($page == 'jeu') {
                            $_SESSION['jeu_url'] = $_SERVER['REQUEST_URI'];
                            header('Location: login.php');
                        }
                        else {
                            echo '<a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Connexion/inscription</a>';
                        }
                        
                    }
                    ?>
                </ul>
                </div>
            </div>
        </nav>