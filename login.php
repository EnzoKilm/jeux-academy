<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="css/test_style.css" media="screen" type="text/css" />
    </head>
    <body>
        <div id="container">
            <!-- zone de connexion -->
            
            <div id="connexion">
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
            </div>

            <div id="inscription">
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
                        echo "<p style='color:green'>Inscription réussie, vous pouvez désormais vous connecter</p>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </body>
</html>