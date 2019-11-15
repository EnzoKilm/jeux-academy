<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Academy | Casse briques</title>

    <style>
     * { padding: 0; margin: 0; }
     canvas { background: #eee no-repeat center center; display: block; margin: 0 auto; border-style: solid; }
     button { display: block; margin: auto; }
    </style>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/79706d8da0.js" crossorigin="anonymous"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-gamepad"></i> Jeux Academy</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Accueil</a>
                </li>
                <?php
                session_start();
                if(isset($_GET['deconnexion'])) { 
                if($_GET['deconnexion']==true) {
                    session_unset();
                    header("location:index.php");
                    }
                }
                else if(isset($_SESSION['pseudo'])) {
                    echo "<li class='nav-item'><a class='nav-link' href='profil.php'><i class='fas fa-user'></i> Profil</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='index.php?deconnexion=true'><i class='fas fa-sign-in-alt'></i> Déconnexion</a></li>";
                }
                else {
                    echo "<a class='nav-link' href='login.php'><i class='fas fa-sign-in-alt'></i> Connexion/inscription</a>";
                    header('Location: login.php');
                    session_unset();
                }
                ?>
            </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
            <div class="row">
            <?php
            // connexion à la base de données
            $db_username = 'root';
            $db_password = 'admindb';
            $db_name     = 'jeux-academy';
            $db_host     = 'localhost';
            $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
                    or die('Connexion à la base de données impossible.');

            $sql = "SELECT map FROM casse_briques_settings WHERE id='2'";
            $result = mysqli_query($db,$sql);
            $value = mysqli_fetch_array($result);
            //$map = $value->id;
            $resultat = $value[0];

            mysqli_close($db); // fermer la connexion            
            ?>
        </div>
        <!-- /.row -->
        
        <br/><canvas id="cassebriques" width="960" height="640"></canvas><br/>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Jeux Academy 2019</p>
        </div>
    <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <?php
    $fichierTxt = file_get_contents('map.txt');
    ?>
    <script>
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
        var x = canvas.width/2;
        var y = canvas.height-10-Math.random()*70-paddleHeight-ballRadius;
        var doubleX = 0;
        var doubleY = 0;
        var paddleX = (canvas.width-paddleWidth) / 2;
        var rightPressed = false;
        var leftPressed = false;
        var brickRowCount = 9;
        var brickColumnCount = 11;
        var brickTxt = <?php 
        echo json_encode($resultat);
        ?>;
        var brickWidth = 80;
        var brickHeight = 25;
        var brickPadding = 2;
        var brickOffsetTop = 30;
        var brickOffsetLeft = 30;
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

        brickTxt = brickTxt.replace(/(\r\n|\n|\r)/gm,"X");

        var listeLigne = [];
        var ligne = "";
        for(var i = 0; i < brickTxt.length; i++) {
            if(brickTxt[i] == "X") {
                listeLigne.push(ligne);
                ligne = ""
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
        
        if(Math.round(Math.random()) == 0) {
            var start = "left";
        }
        else {
            var start = "right";
        }
        
        document.addEventListener("keydown", keyDownHandler, false);
        document.addEventListener("keyup", keyUpHandler, false);
        document.addEventListener("mousemove", mouseMoveHandler, false);
        document.addEventListener("click", commencer, false);
        
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
            if(e.key == "Right" ||e.key == "ArrowRight") {
                rightPressed = true;
            }
            else if(e.key == "Left" || e.key == "ArrowLeft") {
                leftPressed = true;
            }
        }
        
        function keyUpHandler(e) {
            if(e.key == "Right" ||e.key == "ArrowRight") {
                rightPressed = false;
            }
            else if(e.key == "Left" || e.key == "ArrowLeft") {
                leftPressed = false;
            }
        }
        
        function mouseMoveHandler(e) {
            var relativeX = e.clientX - canvas.offsetLeft;
            if(relativeX > 0 && relativeX < canvas.width) {
                paddleX = relativeX - paddleWidth/2;
            }
            else if(relativeX < 0) {
                paddleX = 0;
            }
            else if(relativeX > canvas.width) {
                paddleX = canvas.width-paddleWidth;
            }
        }
        
        function collisionDetection() {
            for(var c=0; c<brickColumnCount; c++) {
                for(var r=0; r<brickRowCount; r++) {
                    var b = bricks[c][r];
                    if(b.status == 9) {
                        if(x+ballRadius > b.x && x-ballRadius < b.x+brickWidth && y+ballRadius > b.y && y-ballRadius < b.y+brickHeight) {
                            dy = -dy;
                        }
                    }
                    else if(b.status >= 1 && b.status != 9) {
                        if(x+ballRadius > b.x && x-ballRadius < b.x+brickWidth && y+ballRadius > b.y && y-ballRadius < b.y+brickHeight) {
                            if(balleFeu == false) {
                                dy = -dy;
                                /*if(x+ballRadius > b.x && x+ballRadius < b.x+brickWidth && y+ballRadius == b.y || x+ballRadius > b.x && x+ballRadius < b.x+brickWidth && y+ballRadius == b.y+brickHeight) {
                                    dy = -dy;
                                }
                                else if(x+ballRadius == b.x && y+ballRadius > b.y && y+ballRadius < b.y+brickHeight || x+ballRadius == b.x+brickWidth && y+ballRadius > b.y && y+ballRadius < b.y+brickHeight) {
                                    dx = -dx;
                                }*/
                            }
                            b.status -= 1;
                            score++;
                            if(score == brickCount) {
                                alert("Bravo, vous avez gagné!");
                                document.location.reload();
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
                        }
                        else if(doubleX+ballRadius > b.x && doubleX-ballRadius < b.x+brickWidth && doubleY+ballRadius > b.y && doubleY-ballRadius < b.y+brickHeight) {
                            doubleDy = -doubleDy;
                            b.status -= 1;
                            score++;
                            if(score == brickRowCount*brickColumnCount) {
                                alert("Bravo, vous avez gagné!");
                                document.location.reload();
                            }
                        }
                    }
                }
            }
        }
        
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
        
        function drawScore() {
            ctx.font = "16px Arial";
            ctx.fillStyle = "#0095DD";
            ctx.fillText("Score: "+score, 8, 20);
        }
        
        function drawLives() {
            ctx.font = "16px Arial";
            ctx.fillStyle = "#0095DD";
            ctx.fillText("Vies: "+lives, canvas.width-60, 20);
        }
        
        function drawCompteur() {
            var tailleCompteur = 200;
            ctx.font = tailleCompteur+"px Arial";
            ctx.fillStyle = "#000000";
            ctx.fillText(compteur, canvas.width/2-tailleCompteur/4, canvas.height/2+tailleCompteur/4);
        }
        
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
        
        function drawPaddle() {
            ctx.beginPath();
            ctx.rect(paddleX, canvas.height-paddleHeight, paddleWidth, paddleHeight);
            ctx.fillStyle = "#0095DD";
            ctx.fill();
            ctx.closePath();
        }

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
        
            if(balleFeu == true) {
                tempsFinFeu = new Date();
                var tempsDiffFeu = tempsFinFeu - tempsDepartFeu;
                if(tempsDiffFeu >= 7500) {
                    balleFeu = false;
                }
            } 
        
            if(start == "left") {
                dx = -dx;
                start = "";
            } 
            else if(start == "right") {
                dx = dx;
                start = "";
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
                }
            }
        
            if(powerupFalling == true) {
                powerupY += powerupDY;
            }
            
            if(x + dx > canvas.width-ballRadius || x + dx < ballRadius) {
                dx = -dx;
            }
            else if(doubleX + dx > canvas.width-ballRadius || doubleX + doubleDx < ballRadius) {
                doubleDx = -doubleDx;
            }
        
            if(y + dy < ballRadius) {
                dy = -dy;
            } else if(y + dy + ballRadius/2 > canvas.height - paddleHeight) {
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
                    }
                }
            }
            if(doubleY + doubleDy < ballRadius) {
                doubleDy = -doubleDy;
            } else if(doubleY + doubleDy + ballRadius/2 > canvas.height - paddleHeight) {
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
</body>

</html>
