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
    
    <?php include 'head.html';?>
</head>

<body>
    <?php include 'nav.php';?>

    <!-- Page Content -->
    <div id="container">
        <!-- zone de connexion -->
        
        <span class="divLeft">
            <form method="post" action="connexion.php" class="conn-form">
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
            <form method="post" action="inscription.php" class="conn-form">
                <h1>Inscription</h1>
                <?php
                if(isset($_GET['success'])) {
                    echo "<p class='success'>Inscription réussie, <br/>vous pouvez désormais vous connecter.</p>";
                }
                else if(isset($_GET['invalidname'])) {
                    echo "<p class='invalidname'>Le pseudo que vous avez indiqué est déjà pris.</p>";
                }
                else if(isset($_GET['incorrectrep'])) {
                    echo "<p class='incorrectrep'>Les mots de passe ne sont pas identiques.</p>";
                }
                else if(isset($_GET['court'])) {
                    echo "<p class='court'>Le mot de passe est trop court !</p>";
                }
                ?>
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
            </form>
        </span>
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include 'footer.html';?>
</body>

</html>
