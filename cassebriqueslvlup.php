<?php
session_start();
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
// On augmente le niveau auquel le joueur joue
$niveau++;

// On enregistre les changements
$requete = "UPDATE casse_briques_users SET niveau='".$niveau."' WHERE id_joueur='".$id."'";
$exec_requete = mysqli_query($db,$requete);

mysqli_close($db); // fermer la connexion

// On redirige le joueur vers le jeu
header("location:cassebriques.php");
?>