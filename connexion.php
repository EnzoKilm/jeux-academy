<?php
session_start();
if(isset($_POST['pseudo']) && isset($_POST['mdp']))
{
    // connexion à la base de données
    $db_username = 'root';
    $db_password = 'admindb';
    $db_name     = 'jeux-academy';
    $db_host     = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
           or die('could not connect to database');
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $pseudo = mysqli_real_escape_string($db,htmlspecialchars($_POST['pseudo'])); 
    $mdp = mysqli_real_escape_string($db,htmlspecialchars($_POST['mdp']));
    $mdp= md5($mdp);
    
    if($pseudo !== "" && $mdp !== "") {
        $requete = "SELECT count(*) FROM users where 
              pseudo = '".$pseudo."' and mdp = '".$mdp."' ";
        $exec_requete = mysqli_query($db,$requete);
        $reponse      = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if($count!=0) // nom d'utilisateur et mot de passe correctes
        {
           $_SESSION['pseudo'] = $pseudo;
           header('Location: index.php');
        }
        else
        {
           header('Location: login.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
       header('Location: login.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: login.php');
}
mysqli_close($db); // fermer la connexion
?>