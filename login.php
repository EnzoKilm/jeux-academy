<!DOCTYPE html>
<html lang="fr">
<?php session_start(); ?>
<?php $page = 'login';?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Academy | Connexion/inscription</title>
    <link rel="icon" href="images/favicon.ico" />

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css" media="screen" type="text/css" />

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/79706d8da0.js" crossorigin="anonymous"></script>

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Import des éléments généraux du site -->
    <script> 
    $(function(){
    $("#footer").load("footer.html"); 
    });
    </script>
</head>

<body>
    <?php include 'nav.php';?>

    <!-- Page Content -->
    <div id="container">
        <!-- zone de connexion -->
        
        <span class="divLeft">
            <form method="post" action="connexion.php">
                <h1>Connexion</h1>
                
                <label><b>Pseudo</b></label>
                <input type="text" placeholder="Entrer le nom d'utilisateur" name="pseudo" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="mdp" required>

                <input type="submit" id='submit' value='Connexion' >
                <?php
                if(isset($_GET['erreur'])) {
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2)
                        echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
                }
                ?>
            </form>
        </span>

        <span class="divRight">
            <form method="post" action="inscription.php">
                <h1>Inscription</h1>
                <label><b>Pseudo</b></label>
                <input type="text" placeholder="Entrer votre pseudo" name="pseudo" required>
                <label><b>Nom</b></label>
                <input type="text" placeholder="Entrer votre nom" name="nom" required>
                <label><b>Prénom</b></label>
                <input type="text" placeholder="Entrer votre prénom" name="prenom" required>
                <label><b>Email</b></label>
                <input type="email" placeholder="Entrer votre email" name="email" required>
                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer un mot de passe" name="mdp" required>
                <label><b>Confirmation du mot de passe</b></label>
                <input type="password" placeholder="Entrer à nouveau le mot de passe" name="repmdp" required><br><br>
                <input type="submit" name="submit" value="Inscription">
                <?php
                if(isset($_GET['success'])) {
                    echo "<p style='color:green'>Inscription réussie, vous pouvez désormais vous connecter.</p>";
                }
                else if(isset($_GET['invalidname'])) {
                    echo "<p style='color:red'>Le pseudo que vous avez indiqué est déjà pris.</p>";
                }
                else if(isset($_GET['incorrectrep'])) {
                    echo "<p style='color:orange'>Les mots de passe ne sont pas identiques.</p>";
                }
                else if(isset($_GET['court'])) {
                    echo "<p style='color:orange'>Le mot de passe est trop court !</p>";
                }
                ?>
            </form>
        </span>
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include 'footer.html';?>

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>
