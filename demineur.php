<?php
    $title = 'Démineur';
?>
<link href="css/demineur.css" type="text/css" rel="stylesheet" />

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

<?php
    // On met les infos des cookies dans un tableau
    $cookieInfos = array();
    // On récupère les infos des cookies et on reset les cookies       sec  min  hr
    if (isset($_COOKIE['win'])) {
        $win = true;
        setcookie("win", "", time() + 60 * 60 * 24);
        $cookieInfos[0] = $win;
    }
    if (isset($_COOKIE['loose'])) {
        $loose = true;
        setcookie("loose", "", time() + 60 * 60 * 24);
        $cookieInfos[1] = $loose;
    }
    if (isset($_COOKIE['bombs_exploded'])) {
        $bombs_exploded = $_COOKIE['bombs_exploded'];
        setcookie("bombs_exploded", "", time() + 60 * 60 * 24);
        $cookieInfos[2] = $bombs_exploded;
    }
    if (isset($_COOKIE['bombs_defused'])) {
        $bombs_defused = $_COOKIE['bombs_defused'];
        setcookie("bombs_defused", "", time() + 60 * 60 * 24);
        $cookieInfos[3] = $bombs_defused;
    }

    // On met à jour la base de données
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
    $requete = "SELECT id FROM demineur_users where id_joueur = '".$id."'";
    $exec_requete = mysqli_query($db,$requete);
    $reponse = mysqli_fetch_array($exec_requete);
    $id_demineur = $reponse[0];

    // Si le joueur n'a pas encore joué au jeu
    if(isset($id_demineur) == null) {
        // On ajoute ses infos dans la table du jeu dans la db
        $requete = "INSERT INTO demineur_users(win,loose,bombs_exploded,bombs_defused,id_joueur,vote) VALUES (0,0,0,0,$id,NULL)";
        $db->query($requete);
    }
    
    // On récupère les stats du joueur
    $requete = "SELECT * FROM demineur_users WHERE id_joueur = $id";
    $exec_requete = mysqli_query($db,$requete);
    $reponse = mysqli_fetch_array($exec_requete);
    $dbInfos = array();
    // 0:id / 1:win / 2:loose / 3:bombs_exploded / 4:bombs_defused / 5:id_joueur / 6:vote
    for ($i = 0; $i < count($reponse)/2-2; $i++) {
        $dbInfos[] = $reponse[$i];
    }
    
    // On additionne les anciennes stats avec les nouvelles
    for ($i = 1; $i < 5; $i++) {
        if (isset($cookieInfos[$i])) {
            $dbInfos[$i] += $reponse[$i];
        }
    }

    // On met à jour les infos de la base de donnés
    $db->query("UPDATE demineur_users SET win=".$dbInfos[0].", loose=".$dbInfos[1].", bombs_exploded=".$dbInfos[2].", bombs_defused=".$dbInfos[3]." WHERE id_joueur = ".$_SESSION['id']."");

    mysqli_close($db); // fermer la connexion
    
    if (isset($win)) {
        unset($win);
    } else {
        unset($loose);
    }
?>

<!-- Scripts -->
<script src="js/minesweeper.js"></script>
<script>
    /* on load scripts */
    window.onload = function() {
        MineSweeper.initialise();
    }
</script>
<script>
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
            c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    var MineSweeper = {
        name: 'MineSweeper',

        difficulties: {
            easy: {
                lines: 8,
                columns: 8,
                mines: 8,
            },
            normal: {
                lines: 12,
                columns: 12,
                mines: 16,
            },
            hard: {
                lines: 16,
                columns: 16,
                mines: 32,
            },
        },

        settings: {

        },

        game: {
            status: 0,
            field: new Array(),
        },

        initialise: function() {
            this.startGame('easy');
        },

        startGame: function(difficulty) {
            this.settings = this.difficulties[difficulty];
            this.drawGameBoard();
            this.resetGame();
        },

        drawGameBoard: function() {

            board = document.getElementById('plateau');
            board.innerHTML = '';

            var elements = document.getElementsByClassName('result');
            for (var i = 0, len = elements.length; i < len; i++) {
                elements[i].innerHTML = '';
                elements[i].style.backgroundColor = '#eeeeee';
                elements[i].style.borderWidth = '0';
            }

            border = document.createElement('table');
            border.setAttribute('oncontextmenu', 'return false;');
            field = document.createElement('tbody');
            border.appendChild(field);
            border.className = 'field';

            board.appendChild(border);

            for (i = 1; i <= this.settings['lines']; i++) {
                line = document.createElement('tr');

                for (j = 1; j <= this.settings['columns']; j++) {
                    cell = document.createElement('td');
                    cell.id = 'cell-'+i+'-'+j;
                    cell.className = 'cell';
                    cell.setAttribute('onclick', this.name+'.checkPosition('+i+', '+j+', true);');
                    cell.setAttribute('oncontextmenu', this.name+'.markPosition('+i+', '+j+'); return false;');
                    line.appendChild(cell);
                }
                field.appendChild(line);
            }
        },

        resetGame: function() {

            /* Creons le champ, vide */
            this.game.field = new Array();
            for (i = 1; i <= this.settings['lines']; i++) {
                this.game.field[i] = new Array();
                for (j = 1; j <= this.settings['columns']; j++) {
                    this.game.field[i][j] = 0;
                }
            }

            /* Ajoutons les mines */
            for (i = 1; i <= this.settings['mines']; i++) {
                /* On place la mine de facon aleatoire */
                x = Math.floor(Math.random() * (this.settings['columns'] - 1) + 1);
                y = Math.floor(Math.random() * (this.settings['lines'] - 1) + 1);
                while (this.game.field[x][y] == -1) {
                    x = Math.floor(Math.random() * (this.settings['columns'] - 1) + 1);
                    y = Math.floor(Math.random() * (this.settings['lines'] - 1) + 1);
                }
                this.game.field[x][y] = -1;

                /* On met a jour les donnees des cellules adjacentes */
                for (j = x-1; j <= x+1; j++) {
                    if (j == 0 || j == (this.settings['columns'] + 1))
                        continue;
                    for (k = y-1; k <= y+1; k++) {
                        if (k == 0 || k == (this.settings['lines'] + 1))
                            continue;
                        if (this.game.field[j][k] != -1)
                            this.game.field[j][k] ++;
                    }
                }
            }

            /* On definit le status au mode jeu */
            this.game.status = 1;
        },

        checkPosition: function(x, y, check) {
            /* Verifie si le jeu est en fonctionnement */
            if (this.game.status != 1)
                return;

            /* Verifie si la cellule a deja ete visitee */
            if (this.game.field[x][y] == -2) {
                return;
            }

            /* Verifie si la cellule est marquee */
            if (this.game.field[x][y] < -90) {
                return;
            }

            /* Verifie si la cellule est une mine */
            if (this.game.field[x][y] == -1) {
                document.getElementById('cell-'+x+'-'+y).className = 'cell bomb';
                document.getElementById('cell-'+x+'-'+y).innerHTML = '&#128163';
                /* On fait apparaître toutes les bombes */
                // On récupère les infos dans les cookies
                var exploded = 0
                var defused = 0
                for (i = 1; i <= this.settings['lines']; i++) {
                    for (j = 1; j <= this.settings['columns']; j++) {
                        if (this.game.field[i][j] == -1) {
                            document.getElementById('cell-'+i+'-'+j).innerHTML = '&#128163';
                            exploded++;
                        } else if (this.game.field[i][j] < -90) {
                            defused++;
                        }
                    }
                }
                document.cookie = "bombs_exploded="+exploded;
                document.cookie = "bombs_defused="+defused;
                this.displayLose();
                return;
            }

            /* Marque la cellule comme verifiee */
            document.getElementById('cell-'+x+'-'+y).className = 'cell clear';
            if (this.game.field[x][y] > 0) {
                /* On marque le nombre de mine des cases adjacentes */
                document.getElementById('cell-'+x+'-'+y).innerHTML = this.game.field[x][y];

                /* On marque la case comme visitee */
                this.game.field[x][y] = -2;
            } else if (this.game.field[x][y] == 0) {
                /* On marque la case comme visitee */
                this.game.field[x][y] = -2;

                /* On devoile les cases adjacentes */
                for (var j = x-1; j <= x+1; j++) {
                    if (j == 0 || j == (this.settings['columns'] + 1))
                        continue;
                    for (var k = y-1; k <= y+1; k++) {
                        if (k == 0 || k == (this.settings['lines'] + 1))
                            continue;
                        if (this.game.field[j][k] > -1) {
                            this.checkPosition(j, k, false);
                        }
                    }
                }
            }

            /* Lance la verification de la victoire si necessaire */
            if (check !== false)
                this.checkWin();
        },

        markPosition: function(x, y) {

            /* Verifie si le jeu est en fonctionnement */
            if (this.game.status != 1)
                return;

            /* Verifie si la cellule a deja ete visitee */
            if (this.game.field[x][y] == -2)
                return;

            if (this.game.field[x][y] < -90) {
                /* Retire le marquage */
                document.getElementById('cell-'+x+'-'+y).className = 'cell';
                document.getElementById('cell-'+x+'-'+y).innerHTML = '';
                this.game.field[x][y] += 100;

            } else {
                /* Applique le marquage */
                document.getElementById('cell-'+x+'-'+y).className = 'cell marked';
                document.getElementById('cell-'+x+'-'+y).innerHTML = '&#127988';
                this.game.field[x][y] -= 100;
            }
        },

        checkWin: function() {
            /* On verifie toutes les cases */
            for (var i = 1; i <= this.settings['lines']; i++) {
                for (var j = 1; j <= this.settings['columns']; j++) {
                    v = this.game.field[i][j];
                    if (v != -1 && v != -2 && v != -101)
                        return;
                }
            }

            /* Aucune case bloquante trouvee, on affiche la victoire */
            this.displayWin();
        },

        displayWin: function() {
            /* Affiche le resultat dans l'espace dedie, en couleur */
            var left = document.getElementById('left');
            left.innerHTML = '<p>Gagn&eacute;</p>';
            left.style.color = '#43b456';
            left.style.backgroundColor = '#55ce3d60';
            left.style.borderWidth = '0 2px 0 0';
            var right = document.getElementById('right');
            right.innerHTML = '<p>Gagn&eacute;</p>';
            right.style.color = '#43b456';
            right.style.backgroundColor = '#55ce3d60';
            right.style.borderWidth = '0 0 0 2px';

            /* Defini l'etat de la partie a termine */
            this.game.status = 0;
            document.cookie = "win=true";
        },

        displayLose: function() {
            /* Affiche le resultat dans l'espace dedie, en couleur */
            var left = document.getElementById('left');
            left.innerHTML = '<p>Perdu</p>';
            left.style.color = '#CC3333';
            left.style.backgroundColor = '#d12d2d60';
            left.style.borderWidth = '0 2px 0 0';
            var right = document.getElementById('right');
            right.innerHTML = '<p>Perdu</p>';
            right.style.color = '#CC3333';
            right.style.backgroundColor = '#d12d2d60';
            right.style.borderWidth = '0 0 0 2px';

            /* Defini l'etat de la partie a termine */
            this.game.status = 0;
            document.cookie = "loose=true";
        },
    };
</script>