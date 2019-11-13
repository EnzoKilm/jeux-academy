var canvas = document.getElementById("myCanvas");
var ctx = canvas.getContext("2d");
var x = canvas.width/2;
var y = canvas.height-20;
var dx = 2.5;
var dy = -2.5;
var ballRadius = 10;
var paddleHeight = 75;
var paddleWidth = 10;
var paddleRightY = (canvas.height-paddleHeight) / 2;
var paddleLeftY = (canvas.height-paddleHeight) / 2;
var upRightPressed = false;
var downRightPressed = false;
var upLeftPressed = false;
var downLeftPressed = false;
var scoreRight = 0;
var scoreLeft = 0;
var jouer = false;
var compteur = "Cliquez pour commencer";
var nombreCollisions = 0;
var depart = false;
var restart = false;

if(Math.round(Math.random()) == 0) {
    var start = "left";
}
else {
    var start = "right";
}

document.addEventListener("keydown", keyDownHandler, false);
document.addEventListener("keyup", keyUpHandler, false);
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
    else if(jouer == false && restart == true) {
        restart = false;
        compteur = 3;
        depart = true;
        var countdown = setInterval(function() {
            compteur--;
            if (compteur <= 0) clearInterval(countdown);
        }, 1000);
    }
}

function keyDownHandler(e) {
    if(e.key == "Up" ||e.key == "ArrowUp") {
        upRightPressed = true;
    }
    else if(e.key == "Down" || e.key == "ArrowDown") {
        downRightPressed = true;
    }
    else if(e.key == "z" || e.key == "Z") {
        upLeftPressed = true;
    }
    else if(e.key == "s" || e.key == "S") {
        downLeftPressed = true;
    }
}

function keyUpHandler(e) {
    if(e.key == "Up" ||e.key == "ArrowUp") {
        upRightPressed = false;
    }
    else if(e.key == "Down" || e.key == "ArrowDown") {
        downRightPressed = false;
    }
    else if(e.key == "z" || e.key == "Z") {
        upLeftPressed = false;
    }
    else if(e.key == "s" || e.key == "S") {
        downLeftPressed = false;
    }
}

function drawScore() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#FF0000";
    ctx.fillText("Score: "+scoreRight, canvas.width-(canvas.width)/3-scoreRight-"Score: ".length, 20);
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Score: "+scoreLeft, (canvas.width)/4-scoreRight-"Score: ".length, 20);
}

function drawCompteur() {
    if(depart == false) {
        ctx.font = "20px Arial";
        ctx.fillStyle = "#000000";
        ctx.fillText(compteur, canvas.width/2-4.5*compteur.length, canvas.height/2);
    }
    else {
        ctx.font = "20px Arial";
        ctx.fillStyle = "#000000";
        ctx.fillText(compteur, canvas.width/2-1, canvas.height/5);
    }
}

function drawBall() {
    ctx.beginPath();
    ctx.arc(x, y, ballRadius, 0, Math.PI*2);
    ctx.fillStyle = "#000000";
    ctx.fill();
    ctx.closePath();
}

function drawPaddle(position) {
    if(position == "left") {
        ctx.beginPath();
        ctx.rect(0, paddleLeftY, paddleWidth, paddleHeight)
        ctx.fillStyle = "#0095DD";
        ctx.fill();
        ctx.closePath();
    } else {
        ctx.beginPath();
        ctx.rect(canvas.width-paddleWidth, paddleRightY, paddleWidth, paddleHeight)
        ctx.fillStyle = "#FF0000";
        ctx.fill();
        ctx.closePath();
    }
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawBall();
    drawPaddle("left");
    drawPaddle("right");
    drawScore();
    drawCompteur();

    // CHANGEMENT DE CÔTÉ POUR LE DÉBUT D'UN NOUVEAU POINT
    if(start == "left") {
        dx = -dx;
        start = "";
    } 
    else if(start == "right") {
        dx = dx;
        start = "";
    }

    // LANCEMENT DU JEU
    if(jouer == true) {
        x += dx;
        y += dy;
    }
    else {
        if(compteur == 0) {
            jouer = true;
            compteur = "";
        }
    }

    // CHANGEMENT DE LA VITESSE DE LA BALLE
    for (var i = 0; i < nombreCollisions; i++) {
        if(i == 3) {
            if(dx > 0) {
                dx += 0.5;
                dy += 0.5;
            }
            else {
                dx -= 0.5;
                dy -= 0.5;
            }
        nombreCollisions -= 3;
        }
    }
    
    // COLLISION MUR HAUT ET BAS
    if(y + dy > canvas.height-1.01*ballRadius || y + dy < 1.01*ballRadius) {
        dy = -dy;
    }

    // COLLISION PADDLE A GAUCHE
    if(x + dx < ballRadius) {
        if(y > paddleLeftY - 2*ballRadius && y < paddleLeftY + paddleHeight + 2*ballRadius) {
            dx = -dx;
            nombreCollisions++;
        }
        else {
            scoreRight++;
            nombreRandom = Math.floor(Math.random() * Math.floor(canvas.height/2))
            x = canvas.width/2;
            nombreRandom = Math.floor(Math.random() * Math.floor(canvas.height/2))
            y = canvas.height/2;
            start = "right";
            if(scoreRight == 3) {
                alert("Fin de la partie");
                document.location.reload();
            }
            else {
                restart = true;
                jouer = false;
                nombreCollisions = 0;
                dx = 2;
                dy = -2;
                commencer();
            }
        }
    } 

    // COLLISION PADDLE A DROITE
    if(x + dx > canvas.width-ballRadius) {
        if(y > paddleRightY - 2*ballRadius && y < paddleRightY + paddleHeight + 2*ballRadius) {
            dx = -dx;
            nombreCollisions++;
        }
        else {
            scoreLeft++;
            nombreRandom = Math.floor(Math.random() * Math.floor(canvas.height/2))
            x = canvas.height/2+nombreRandom;
            nombreRandom = Math.floor(Math.random() * Math.floor(canvas.height/2))
            y = canvas.height/2+nombreRandom;
            start = "left";
            if(scoreLeft == 3) {
                alert("Fin de la partie");
                document.location.reload();
            }
            else {
                restart = true;
                jouer = false;
                nombreCollisions = 0;
                dx = 2;
                dy = -2;
                commencer();
            }
        }
    }

    // BOUGER PADDLE GAUCHE
    if(downLeftPressed) {
        paddleLeftY += 5;
        if (paddleLeftY + paddleHeight > canvas.height) {
            paddleLeftY = canvas.height - paddleHeight;
        }
    }
    else if(upLeftPressed) {
        paddleLeftY -= 5;
        if (paddleLeftY < 0) {
            paddleLeftY = 0;
        }
    }

    // BOUGER PADDLE DROITE
    if(downRightPressed) {
        paddleRightY += 5;
        if (paddleRightY + paddleHeight > canvas.height) {
            paddleRightY = canvas.height - paddleHeight;
        }
    }
    else if(upRightPressed) {
        paddleRightY -= 5;
        if (paddleRightY < 0) {
            paddleRightY = 0;
        }
    }
    requestAnimationFrame(draw);
}

draw();