<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <p class="titre-profil">Jeux préférés</p>
            <div id="jeu-prefere" class="carousel slide my-4" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#jeu-prefere" data-slide-to="0" class="active"></li>
                    <li data-target="#jeu-prefere" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                    <img class="d-block img-fluid" src="images/miniatures/demineur.png" alt="Démineur">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block img-fluid" src="images/miniatures/cassebriques.png" alt="Casse briques">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#jeu-prefere" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Précédent</span>
                </a>
                <a class="carousel-control-next" href="#jeu-prefere" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Suivant</span>
                </a>
            </div>

            <p class="titre-profil">Amis</p>
            <div class="row">
                <?php
                    // Si on est sur un profil différent de celui du joueur connecté
                    if ($pseudo != $_SESSION['pseudo']) {
                        // On récupère l'id avec le pseudo
                        $requete = "SELECT id FROM users WHERE pseudo='".$_REQUEST['pseudo']."'";
                        $exec_requete = mysqli_query($db,$requete);
                        var_dump($exec_requete);
                        // $requete = "SELECT joueur_id FROM amis WHERE ami_id=";
                    } else {
                        // On regarde si la personne a des demandes
                        $users_demands = array();
                        $requete = "SELECT joueur_id FROM amis WHERE ami_id='".$_SESSION['id']."'";
                        $exec_requete = mysqli_query($db,$requete);
                        while ($row = mysqli_fetch_array($exec_requete)) {
                            $users_demands[] = $row[0];
                        }
                        // Si elle n'en a pas
                        if ($users_demands == []) {
                            echo '<div><p>Tu n\'as pas d\'amis</div>';
                        } else {
                            // Sinon on affiche chacune des demandes
                            for ($i = 0; $i < count($users_demands); $i++) {
                                $accepted_demand = array();
                                // On vérifie si la demande n'a pas déjà été acceptée (si l'utilisateur et le demandeur son amis)
                                $requete_accepted = "SELECT accepted FROM amis WHERE ami_id='".$_SESSION['id']."'";
                                $exec_requete_accepted = mysqli_query($db,$requete_accepted);
                                while ($row = mysqli_fetch_array($exec_requete_accepted)) {
                                    $accepted_demand[] = $row[0];
                                }
                                
                                if ($accepted_demand[$i] == 1) {
                                    $requete = "SELECT pseudo FROM users WHERE id='".$users_demands[$i]."'";
                                    $exec_requete = mysqli_query($db,$requete);
                                    $nom = mysqli_fetch_array($exec_requete);
                                    
                                    // On affiche le résumé du profil de l'ami
                                    echo '<div class="col-lg-4 col-md-6 mb-4"><div class="card h-100">';
                                    echo '<a href="profil.php?pseudo='.$nom[0].'" class="friend-profile"><img class="card-img-top" src="images/profil.png" alt="Image du profil"></a>';
                                    echo '<div class="card-body"><h4 class="card-title"><a href="profil.php?pseudo='.$nom[0].'">'.$nom[0].'</a></h4></div>';
                                    echo '<div class="card-footer"><small class="text-muted">Amis depuis le XX/XX/XXXX</small></div>';
                                    echo '</div></div>';
                                }
                            }
                        }
                    }                    
                ?>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->
        
        <div class="col-lg-3">
            <?php echo "<h1 class='my-4'>$pseudo</h1>"; ?>
            <img src="images/profil.png" alt="Profil" id="profil">
            <?php
                // Si on est sur un profil différent de celui du joueur connecté
                if ($pseudo != $_SESSION['pseudo']) {
                    // On check si le joueur a déjà été invité
                    $requete = "SELECT ami_id FROM amis WHERE joueur_id=".$_SESSION['id']."";
                    $exec_requete = mysqli_query($db,$requete);
                    while ($row = mysqli_fetch_array($exec_requete)) {
                        $requete = "SELECT id FROM users WHERE pseudo='".$_REQUEST['pseudo']."'";
                        $requete_exec = mysqli_query($db,$requete);
                        $test = mysqli_fetch_array($requete_exec);
                    }
                    // Si on a déjà envoyé une invitation au joueur
                    if (isset($test[0])) {
                        echo '<div class="list-group"><a href="#" class="list-group-item"><i class="fas fa-user-clock"></i> Invitation déjà envoyée</a></div>';
                    } else {
                        if(isset($_REQUEST['friend'])) {
                            if ($_REQUEST['friend'] == 'add') {
                                // On récupère l'id de l'ami et on l'ajoute à la table des demandes
                                $requete = "SELECT id FROM users WHERE pseudo='".$_REQUEST['pseudo']."'";
                                $exec_requete = mysqli_query($db,$requete);
                                $id_ami = mysqli_fetch_array($exec_requete);
                                $sql = "INSERT INTO amis(joueur_id,ami_id) VALUES ('".$_SESSION['id']."','".$id_ami[0]."')";
                                if(!$db->query($sql)) {
                                    printf("Message d'erreur : %s\n", $db->error);
                                }
                                echo '<div class="list-group"><a href="#" class="list-group-item"><i class="fas fa-user-clock"></i> Invitation déjà envoyée</a></div>';
                            }
                        } else {
                            echo '<div class="list-group"><a href="profil.php?pseudo='.$_REQUEST['pseudo'].'&friend=add" class="list-group-item"><i class="fas fa-user-plus"></i> Ajouter comme ami</a></div>';
                        }
                    }
                } else {
                    // Affichage des demandes en attente
                    echo '<div class="list-group">';
                    echo '<a href="#" class="list-group-item bold"><i class="fas fa-user"></i> Demandes d\'amis</a>';
                    // On regarde si la personne a des demandes
                    $users_demands = array();
                    $requete = "SELECT joueur_id FROM amis WHERE ami_id='".$_SESSION['id']."'";
                    $exec_requete = mysqli_query($db,$requete);
                    while ($row = mysqli_fetch_array($exec_requete)) {
                        $users_demands[] = $row[0];
                    }
                    // Si elle n'en a pas
                    if ($users_demands == []) {
                        echo '<div class="list-group-item item-container">';
                        echo '<div class="item-center"><p>Tu n\'as aucune demande d\'ami en attente';
                        echo '</div></div>';
                    } else {
                        // Sinon on affiche chacune des demandes
                        for ($i = 0; $i < count($users_demands); $i++) {
                            $accepted_demand = array();
                            // On vérifie si la demande n'a pas déjà été acceptée (si l'utilisateur et le demandeur son amis)
                            $requete_accepted = "SELECT accepted FROM amis WHERE ami_id='".$_SESSION['id']."'";
                            $exec_requete_accepted = mysqli_query($db,$requete_accepted);
                            while ($row = mysqli_fetch_array($exec_requete_accepted)) {
                                $accepted_demand[] = $row[0];
                            }
                            
                            // var_dump($accepted[$i]);
                            if ($accepted_demand[$i] == 0) {
                                $requete = "SELECT pseudo FROM users WHERE id='".$users_demands[$i]."'";
                                $exec_requete = mysqli_query($db,$requete);
                                $nom = mysqli_fetch_array($exec_requete);

                                echo '<div class="list-group-item item-container">';
                                echo '<div class="item-left"><p><a href="profil.php?pseudo='.$nom[0].'" class="bold">'.$nom[0].'</a> veut être ton ami</p></div>';
                                echo '<div class="item-right"><a href="#" class="plus"><i class="fas fa-plus-circle"></i></a><br/>';
                                echo '<a href="#" class="minus"><i class="fas fa-minus-circle"></i></a></div>';
                                echo '</div></div>';
                            } 
                        }
                        // On regardei le joueur n'a aucune demande en attente
                        foreach ($accepted_demand as $value) {
                            if ($value == 0) {
                                $no_demand = false;
                            }
                        }
                        // Si il n'en a pas on lui dit
                        if (!isset($no_demand)) {
                            echo '<div class="list-group-item item-container">';
                            echo '<div class="item-center"><p>Tu n\'as aucune demande d\'ami en attente</div>';
                            echo '</div></div>';
                        }
                    }                    
                }
            ?>
        </div>
        <!-- /.col-lg-3 -->
    </div>
    <!-- /.row -->

</div>
<!-- /.container -->