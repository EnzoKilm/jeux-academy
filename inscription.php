<?php
if (isset($_POST['submit']))
{
    /* on test si le mdp contient bien au moins 6 caractère */
    if (strlen($_POST['mdp'])>=6)
    {
        /* on test si les deux mdp sont bien identique */
        if ($_POST['mdp']==$_POST['mdp'])
        {
            // On crypte le mot de passe
            $_POST['mdp']= md5($_POST['mdp']);
            // on se connecte à MySQL et on sélectionne la base
            $db_username = 'root';
            $db_password = 'admindb';
            $db_name     = 'jeux-academy';
            $db_host     = 'localhost';
            $db = new mysqli("$db_host","$db_username","$db_password","$db_name");
            $pseudo = mysqli_real_escape_string($db,htmlspecialchars($_POST['pseudo'])); 
            $mdp = mysqli_real_escape_string($db,htmlspecialchars($_POST['mdp']));
            $nom = mysqli_real_escape_string($db,htmlspecialchars($_POST['nom'])); 
            $prenom = mysqli_real_escape_string($db,htmlspecialchars($_POST['prenom']));
            $email = mysqli_real_escape_string($db,htmlspecialchars($_POST['email']));
            //On créé la requête
            $sql = "INSERT INTO users(pseudo,mdp,nom,prenom,email) VALUES ('".$pseudo."','".$mdp."','".$nom."','".$prenom."','".$email."')";
                
            /* execute et affiche l'erreur mysql si elle se produit */
            if(!$db->query($sql))
            {
                printf("Message d'erreur : %s\n", $db->error);
            }
            header('Location: login.php?success#inscription');
            // on ferme la connexion
            mysqli_close($db);
        }
        else echo "Les mots de passe ne sont pas identiques";
    }
    else echo "Le mot de passe est trop court !";
}
?>