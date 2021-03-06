<?php
    $title = 'Casse briques';
?>

<?php
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
    $requete = "SELECT niveau FROM cassebriques_users where id_joueur = '".$id."'";
    $exec_requete = mysqli_query($db,$requete);
    $reponse = mysqli_fetch_array($exec_requete);
    $niveau = $reponse[0];

    // Si le joueur n'a pas encore joué au jeu
    if(isset($niveau) == null) {
        // On ajoute ses infos dans la table du jeu dans la db
        $requete = "INSERT INTO cassebriques_users(niveau,id_joueur,vote) VALUES (1,'".$id."',NULL)";
        $db->query($requete);
    }
    
    $requete = "SELECT map FROM cassebriques_settings WHERE id = '".$niveau."'";
    $result = mysqli_query($db,$requete);
    $value = mysqli_fetch_array($result);
    $map = $value[0];

    mysqli_close($db); // fermer la connexion
?>

<canvas id="cassebriques" width="916" height="640"></canvas>

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script>
    // BALLE VA DANS BRIQUE INVINCIBLE
    // !! REFAIRE LE SYSTÈME DE BOUNCE !!
    var canvas = document.getElementById("cassebriques");
    var ctx = canvas.getContext("2d");
    var dx = 2.5;
    var dy = -5;
    var doubleDx = dx;
    var doubleDy = dy;
    var doubleBall = false;
    var ballRadius = 8;
    var ballStatus = "simple";
    var paddleHeight = 10;
    var paddleWidth = 75;
    var paddleX = (canvas.width-paddleWidth) / 2;
    var x = paddleX + paddleWidth/2;
    var y = canvas.height-2*paddleHeight;
    var doubleX = 0;
    var doubleY = 0;
    var rightPressed = false;
    var leftPressed = false;
    var spaceBarPressed = false;
    var brickRowCount = 9;
    var brickColumnCount = 11;
    var brickTxt = <?php 
    echo json_encode($map);
    ?>;
    var brickWidth = 80;
    var brickHeight = 25;
    var brickPadding = 2;
    var brickOffsetTop = 8;
    var brickOffsetLeft = 8;
    var brickCount = 0;
    var score = 0;
    var jouer = false;
    var compteur = 3;
    var lives = 3;
    var depart = false;
    var powerup = false;
    var powerupRadius = 12;
    var powerupDY = 1.5;
    var powerupX = 0;
    var powerupY = 0;
    var powerupFalling = false;
    var powerupStatus = 0;
    var balleFeu = false;
    var tempsDepartFeu = 0;
    var tempsFinFeu = 0;
    var start = true;
    var relativeX = 0;

    brickTxt = brickTxt.replace(/(\r\n|\n|\r)/gm,"X");

    var listeLigne = [];
    var ligne = "";
    for(var i = 0; i < brickTxt.length+1; i++) {
        if(brickTxt[i] == "X") {
            listeLigne.push(ligne);
            ligne = "";
        }
        else {
            ligne += brickTxt[i];
        }
    }
    listeLigne.push(ligne);

    var bricks = [];
    for(var c=0; c<brickColumnCount; c++) {
        bricks[c] = [];
        for(var r=0; r<brickRowCount; r++) {
            for(var i=0; i<=9; i++) {
                if(i == listeLigne[r][c]) {
                    bricks[c][r] = { x: 0, y: 0, status: i };
                    if(listeLigne[r][c] != 9) {
                        brickCount += i;
                    }
                }
            }
        }
    }

    // Aléatoire pour le lancement de la balle si le joueur ne bouge pas la raquette
    if(Math.round(Math.random()) == 0) {
        var direction = "left";
    }
    else {
        var direction = "right";
    }
    
    document.addEventListener("keydown", keyDownHandler, false);
    document.addEventListener("keyup", keyUpHandler, false);
    document.addEventListener("keyup", keyUpHandler, false);
    document.addEventListener("mousemove", mouseMoveHandler, false);
    
    // Compteur du début de partie
    function commencer() {
        if(jouer == false && depart == false) {
            depart = true;
            compteur = 3;
            var countdown = setInterval(function() {
                compteur--;
                if (compteur <= 0) clearInterval(countdown);
            }, 1000);
        }
    }
    
    function keyDownHandler(e) {
        if(e.key == "Right" || e.key == "ArrowRight" ||e.key == "d") {
            rightPressed = true;
            if(depart == false) {
                direction = "right"
            }
        }
        else if(e.key == "Left" || e.key == "ArrowLeft" ||e.key == "q") {
            leftPressed = true;
            if(depart == false) {
                direction = "left"
            }
        }
        else if(e.keyCode == 32) {
            spaceBarPressed = true;
        }
    }
    
    function keyUpHandler(e) {
        if(e.key == "Right" ||e.key == "ArrowRight" ||e.key == "d") {
            rightPressed = false;
            direction = "right"
        }
        else if(e.key == "Left" || e.key == "ArrowLeft" ||e.key == "q") {
            leftPressed = false;
            direction = "left";
        }
        else if(e.keyCode == 32) {
            spaceBarPressed = false;
        }
    }
    
    function mouseMoveHandler(e) {
        // Gestion de la position de la souris et comparaison avec l'ancienne position pour détecter si la raquette vas à gauche ou à droite
        var oldRelativeX = relativeX;
        relativeX = e.clientX - canvas.offsetLeft;
        if(oldRelativeX > relativeX) {
            direction = "left";
        }
        else {
            direction = "right";
        }
        
        // Déplacement de la raquette
        if(relativeX > 0 && relativeX < canvas.width) {
            paddleX = relativeX-paddleWidth/2;
        }
        else if(relativeX < 0) {
            paddleX = 0;
        }
        else if(relativeX > canvas.width) {
            paddleX = canvas.width-paddleWidth;
        }

        // Pour ne pas que la raquette dépasse de l'écran quand le curseur est au bord
        if(relativeX > canvas.width-paddleWidth/2) {
            paddleX = canvas.width-paddleWidth;
        }
        else if(relativeX < 0+paddleWidth/2) {
            paddleX = 0;
        }
    }
    
    // Détection des collisions entre la balle et les briques
    function collisionDetection() {
        for(var c=0; c<brickColumnCount; c++) {
            for(var r=0; r<brickRowCount; r++) {
                var b = bricks[c][r];
                if(b.status == 9) {
                    // if(x+ballRadius > b.x && x-ballRadius < b.x+brickWidth && y+ballRadius > b.y && y-ballRadius < b.y+brickHeight) {
                    //     dy = -dy;
                    // }
                    if(x+ballRadius/2 > b.x && x-ballRadius/2 < b.x+brickWidth && y+ballRadius/2 > b.y && y-ballRadius/2 < b.y+brickHeight) {
                        dy = -dy;
                    }
                    else if(doubleX+ballRadius/2 > b.x && doubleX-ballRadius/2 < b.x+brickWidth && doubleY+ballRadius/2 > b.y && doubleY-ballRadius/2 < b.y+brickHeight) {
                        doubleDy = -doubleDy;
                    }
                }
                else if(b.status >= 1 && b.status != 9) {
                    /*if(x+ballRadius/2 >= b.x && x-ballRadius/2 <= b.x+brickWidth && y+ballRadius/2 > b.y && y-ballRadius/2 < b.y+brickHeight) {
                        if(balleFeu == false) {
                            dy = -dy;
                            if(x+ballRadius > b.x && x+ballRadius < b.x+brickWidth && y+ballRadius == b.y || x+ballRadius > b.x && x+ballRadius < b.x+brickWidth && y+ballRadius == b.y+brickHeight) {
                                dy = -dy;
                            }
                            else if(x+ballRadius == b.x && y+ballRadius > b.y && y+ballRadius < b.y+brickHeight || x+ballRadius == b.x+brickWidth && y+ballRadius > b.y && y+ballRadius < b.y+brickHeight) {
                                dx = -dx;
                            }
                        }
                        b.status -= 1;
                        score++;
                        if(score == brickCount) {
                            window.location.replace("cassebriqueslvlup.php");
                        }
                        else {
                            if(Math.round(Math.random()) == 0 && powerupStatus == 0) {
                                powerupAleatoire = Math.floor(Math.random() * 3);
                                powerup = true;
                                powerupStatus = 1;
                                powerupX = b.x+brickWidth/2
                                powerupY = b.y+powerupRadius/2;
                                powerupFalling = true;
                                if(powerupAleatoire == 1 && doubleBall == false) {
                                    powerupType = "doubleBalle";
                                }
                                else if(powerupAleatoire == 2 && balleFeu == false) {
                                    powerupType = "balleFeu"
                                }
                                else {
                                    powerupType = "grandeRaquette"
                                }
                            } 
                        }
                    }*/

                    // A gauche
                    if(x+ballRadius >= b.x && x+ballRadius < b.x+brickWidth && y >= b.y && y+ballRadius <= b.y+brickHeight) {
                        dx = -dx;
                        b.status -= 1;
                        console.log("Gauche");
                    }
                    // A droite
                    else if(x <= b.x+brickWidth && x > b.x && y >= b.y && y+ballRadius <= b.y+brickHeight) {
                        dx = -dx;
                        b.status -= 1;
                        console.log("Droite");
                    }
                    // En haut ou en bas
                    else if(x+ballRadius/2 >= b.x && x-ballRadius/2 <= b.x+brickWidth && y+ballRadius >= b.y && y-ballRadius <= b.y+brickHeight) {
                        dy = -dy;
                        b.status -= 1;
                        console.log("Haut/bas");
                    }
                    // else 
                    // A gauche ou a droite
                    // else if() {
                    //     dx = -dx;
                    //     b.status -= 1;
                    //     console.log("Gauche/droite");
                    // }*/



                    else if(doubleX+ballRadius/2 > b.x && doubleX-ballRadius/2 < b.x+brickWidth && doubleY+ballRadius/2 > b.y && doubleY-ballRadius/2 < b.y+brickHeight) {
                        doubleDy = -doubleDy;
                        b.status -= 1;
                        score++;
                        if(score == brickCount) {
                            $_SESSION['cassebrique_win'] = true;
                            window.location.replace("cassebriqueslvlup.php");
                        }
                    }
                }
            }
        }
    }

    // Activation des powerups lorsqu'ils touchent la raquette
    function powerupActivation() {
        if(powerupX + powerupRadius/2 > paddleX && powerupX - powerupRadius/2 < paddleX + paddleWidth && powerupY + powerupRadius >= canvas.height - paddleHeight) {
            powerupStatus = 0;
            powerupX = 0;
            powerupY = 0;
            powerupFalling = false;
            if(powerupType == "grandeRaquette") {
                paddleWidth += 50;
            }
            else if(powerupType == "doubleBalle") {
                ballStatus = "double";
                creationDeuxiemeBalle = true;
            }
            else if(powerupType == "balleFeu") {
                balleFeu = true;
                tempsDepartFeu = new Date();
            }
        }
        else if(powerupY > canvas.height) {
            powerupStatus = 0;
            powerupX = 0;
            powerupY = 0;
        }
    }
    
    // Création/dessin des powerups
    function drawPowerUp(type) {
        if(powerupStatus == 1) {
            if(type == "grandeRaquette") {
                ctx.beginPath();
                powerupBall = ctx.arc(powerupX, powerupY, powerupRadius, 0, Math.PI*2);
                ctx.fillStyle = "#0101DF";
                ctx.fill();
                ctx.closePath();
            }
            else if(type == "doubleBalle") {
                ctx.beginPath();
                powerupBall = ctx.arc(powerupX, powerupY, powerupRadius, 0, Math.PI*2);
                ctx.fillStyle = "#FE2EF7";
                ctx.fill();
                ctx.closePath();
            }
            else if(type == "balleFeu") {
                ctx.beginPath();
                powerupBall = ctx.arc(powerupX, powerupY, powerupRadius, 0, Math.PI*2);
                ctx.fillStyle = "#FF6000";
                ctx.fill();
                ctx.closePath();
            }
        }
    }
    
    // Écriture du score
    function drawScore() {
        ctx.font = "24px Arial";
        ctx.fillStyle = "#0095DD";
        ctx.fillText("Score: "+score, 10, canvas.height-16);
    }
    
    // Écriture des vies
    function drawLives() {
        ctx.font = "24px Arial";
        ctx.fillStyle = "#0095DD";
        ctx.fillText("Balles: "+lives, canvas.width-100, canvas.height-16);
    }
    
    // Écriture du compteur (avant que la partie commence)
    function drawCompteur() {
        if(depart == true) {
            var tailleCompteur = 200;
            ctx.fillText(compteur, canvas.width/2, canvas.height/2+tailleCompteur/4);
        }
        else {
            var texteCompteur = "Appuyez sur la barre espace pour commencer";
            var tailleCompteur = 150;
            ctx.fillText(texteCompteur, canvas.width/2-texteCompteur.length*5.5, canvas.height/2+tailleCompteur/4);
        }
        ctx.fillStyle = "#000000";
        ctx.font = tailleCompteur+"px Arial";
    }
    
    // Dessin de la balle
    function drawBall() {
        ctx.beginPath();
        ctx.arc(x, y, ballRadius, 0, Math.PI*2);
        if(balleFeu == true)  {
            ctx.fillStyle = "#FF6000";
        }
        else {
            ctx.fillStyle = "#000000";
        }
        ctx.fill();
        ctx.closePath();
    
        if(ballStatus == "double") {
            if(creationDeuxiemeBalle == true) {
                doubleDx = -dx;
                doubleDy = dy;
                doubleBall = true;
                var ecartX = Math.floor(Math.random() * (150 - 40 + 1)) + 10;
                var ecartY = Math.floor(Math.random() * (130 - 40 + 1)) + 10;
                if(x + ecartX >= canvas.width) {
                    ecartX -= 2*ecartX;
                    doubleX = x + ecartX;
                }
                else {
                    ecartX += 2*ecartX;
                    doubleX = x + ecartX;
                }
                if(y - ecartY <= canvas.height) {
                    ecartY -= 2*ecartY;
                    doubleY = y + ecartY;
                }
                else {
                    ecartY += 2*ecartY;
                    doubleY = y + ecartY;
                }
                creationDeuxiemeBalle = false;
            }
            ctx.beginPath();
            ctx.arc(doubleX, doubleY, ballRadius, 0, Math.PI*2);
            ctx.fillStyle = "#DF01D7";
            ctx.fill();
            ctx.closePath();
        }
    }
    
    // Dessin de la raquette
    function drawPaddle() {
        ctx.beginPath();
        ctx.rect(paddleX, canvas.height-paddleHeight, paddleWidth, paddleHeight);
        ctx.fillStyle = "#0095DD";
        ctx.fill();
        ctx.closePath();
    }

    // Dessin des briques
    var brickNumbers = [1, 2, 3, 9]
    var brickColors = ["#F0F005", "#FF8000", "#FF0000", "#1E1E1D"]
    function drawBricks() {
        for(var c=0; c<brickColumnCount; c++) {
            for(var r=0; r<brickRowCount; r++) {
                if(brickNumbers.includes(bricks[c][r].status)) {
                    var brickX = (c*(brickWidth+brickPadding))+brickOffsetLeft;
                    var brickY = (r*(brickHeight+brickPadding))+brickOffsetTop;
                    bricks[c][r].x = brickX;
                    bricks[c][r].y = brickY;
                    ctx.beginPath();
                    ctx.rect(brickX, brickY, brickWidth, brickHeight);
                    ctx.fillStyle = brickColors[brickNumbers.indexOf(bricks[c][r].status)];
                    ctx.fill();
                    ctx.closePath();
                }
            }
        }
    }
    
    // Fonction de dessin principale
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawBricks();
        if(powerup == true) {
            drawPowerUp(powerupType);
        }
        drawBall();
        drawPaddle();
        drawScore();
        drawCompteur();
        drawLives();
        collisionDetection();
        powerupActivation();
    
        if(spaceBarPressed == true) {
            commencer();
        }
        
        if(balleFeu == true) {
            tempsFinFeu = new Date();
            var tempsDiffFeu = tempsFinFeu - tempsDepartFeu;
            if(tempsDiffFeu >= 7500) {
                balleFeu = false;
            }
        }
        
        
        
        if(start == true) {
            x = paddleX + paddleWidth/2;
            y = canvas.height-2*paddleHeight;
        }
        
        if(jouer == true) {
            x += dx;
            y += dy;
            if(ballStatus == "double") {
                doubleX += doubleDx;
                doubleY += doubleDy;
            }
        }
        else {
            if(compteur == 0) {
                jouer = true;
                compteur = "";
                start = false;
                // Direction de départ de la balle
                if(direction == "left") {
                    dx = -dx;
                } 
                else if(direction == "right") {
                    dx = dx;
                }
            }
        }
    
        // Descente du powerup
        if(powerupFalling == true) {
            powerupY += powerupDY;
        }
        
        // Si la balle sort de l'écran (largeur)
        if(x + dx > canvas.width-ballRadius || x + dx < ballRadius) {
            dx = -dx;
        }
        else if(doubleX + dx > canvas.width-ballRadius || doubleX + doubleDx < ballRadius) {
            doubleDx = -doubleDx;
        }
        
        // Si la balle sort de l'écran 
        if(y + dy < ballRadius) {
            dy = -dy;
        }
        // Si la balle sort de l'écran (longueur)
        else if(y + dy + ballRadius/2 > canvas.height - paddleHeight) {
            if(x > paddleX - ballRadius/2 && x < paddleX + paddleWidth + ballRadius) {
                dy = -dy;
            }   
            else {
                lives--;
                if(!lives) {
                    alert("Vous avez perdu");
                    document.location.reload();
                }
                else {
                    x = canvas.width/2;
                    y = canvas.height-10-Math.random()*70-paddleHeight-ballRadius;
                    dx = dx;
                    dy = -dy;
                    paddleX = (canvas.width-paddleWidth)/2;
                    start = true;
                    jouer = false;
                    depart = false;
                    commencer();
                }
            }
        }
        if(doubleY + doubleDy < ballRadius) {
            doubleDy = -doubleDy;
        }
        else if(doubleY + doubleDy + ballRadius/2 > canvas.height - paddleHeight) {
            if(doubleX > paddleX - ballRadius/2 && doubleX < paddleX + paddleWidth + ballRadius) {
                doubleDy = -doubleDy;
            }   
            else {
                ballStatus = "simple";
                doubleBall = false;
            }
        }
    
        if(rightPressed) {
            paddleX += 7;
            if (paddleX + paddleWidth > canvas.width) {
                paddleX = canvas.width - paddleWidth;
            }
        }
        else if(leftPressed) {
            paddleX -= 7;
            if (paddleX < 0) {
                paddleX = 0;
            }
        }
        requestAnimationFrame(draw);
    }
    
    draw();
</script>
<script>
    window.onkeydown = function(e) {
    if (e.keyCode == 32 && e.target == document.body) {
        e.preventDefault();
    }
    };
</script>