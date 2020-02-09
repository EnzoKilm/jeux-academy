<?php
    $title = 'Pong';
?>
<link href="css/pong.css" type="text/css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">

<div class="jeu">
    <main role="main">
        <div class="score">
            <p><?php echo $_SESSION['pseudo'];?> :  <em id="player-score"> 0 </em></p>
            <p>Ordinateur : <em id="computer-score">0</em></p>
        </div>
        <div class="canvas">
            <canvas id="canvas" width="640" height="480"></canvas>
        </div>
        <ul class="button">
            <li class="button1">
                <button id="start-game">Démarrer</button>
            </li>
            <li>
                <button id="stop-game">Arrêter</button>
            </li>
        </ul>
    </main>
</div>

<script>
    'use strict';

    var canvas;
    var game;
    var anim;

    const PLAYER_HEIGHT = 100;
    const PLAYER_WIDTH = 5;

    function draw(){
    var context = canvas.getContext('2d');

    //draw field
    context.fillStyle = '#b8e994';
    context.fillRect(0, 0, canvas.width, canvas.height);

    //Draw middle line
    context.strokeStyle = '#38ada9';
    context.beginPath();
    context.moveTo(canvas.width / 2, 0);
    context.lineTo(canvas.width / 2, canvas.height);
    context.stroke();

    // Draw players
    context.fillStyle = '#38ada9'
    context.fillRect(0, game.player.y, PLAYER_WIDTH, PLAYER_HEIGHT);
    context.fillRect(canvas.width - PLAYER_WIDTH, game.computer.y, PLAYER_WIDTH, PLAYER_HEIGHT);

    //Draw ball
    context.beginPath();
    context.fillStyle = '#38ada9';
    context.arc(game.ball.x, game.ball.y, game.ball.r, 0, Math.PI * 2, false);
    context.fill();
    }

    function collide(player){
    if(game.ball.y < player.y || game.ball.y > player.y + PLAYER_HEIGHT){
        game.ball.x = canvas.width / 2;
        game.ball.y = canvas.height / 2;
        game.player.y = canvas.height / 2 - PLAYER_HEIGHT / 2;
        game.computer.y = canvas.height / 2 - PLAYER_HEIGHT / 2;

        //reset speed of the ball
        game.ball.speed.x = 4;

        if (player == game.player) {
        game.computer.score++;
        document.querySelector('#computer-score').textContent = game.computer.score;
    } else {
        game.player.score++;
        document.querySelector('#player-score').textContent = game.player.score;
    }
    }
    else{
        game.ball.speed.x *= -1.05;
        changeDirection(player.y);
    }
    }

    function ballMove(){
    if (game.ball.y > canvas.height - game.ball.r || game.ball.y < game.ball.r){
        game.ball.speed.y *= -1;
    }
    game.ball.x += game.ball.speed.x;
    game.ball.y += game.ball.speed.y;

    if (game.ball.x > canvas.width - PLAYER_WIDTH) {
        collide(game.computer);
    }
    else if (game.ball.x < PLAYER_WIDTH) {
        collide(game.player);
    }
    }

    function changeDirection(playerPosition){
    var impact = game.ball.y - playerPosition - PLAYER_HEIGHT / 2;
    var ratio = 100 / (PLAYER_HEIGHT / 2);
    // Get a value between 0 and 10
    game.ball.speed.y = Math.round(impact * ratio / 20);
    }

    function play() {
    draw();

    computerMove();
    ballMove();

    anim = requestAnimationFrame(play);
    }

    function stop() {
    cancelAnimationFrame(anim);
    // Set ball and players to the center
    game.ball.x = canvas.width / 2;
    game.ball.y = canvas.height / 2;
    game.player.y = canvas.height / 2 - PLAYER_HEIGHT / 2;
    game.computer.y = canvas.height / 2 - PLAYER_HEIGHT / 2;
    // Reset speed
    game.ball.speed.x = 2;
    game.ball.speed.y = 2;
    // Init score
    game.computer.score = 0;
    game.player.score = 0;
    document.querySelector('#computer-score').textContent = game.computer.score;
    document.querySelector('#player-score').textContent = game.player.score;
    draw();
    }

    function playerMove(event) {
    // Get the mouse location in the canvas
    var canvasLocation = canvas.getBoundingClientRect();
    var mouseLocation = event.clientY - canvasLocation.y;
    game.player.y = mouseLocation - PLAYER_HEIGHT / 2;
    if (mouseLocation < PLAYER_HEIGHT / 2)
    {
        game.player.y = 0;
    }
    else if (mouseLocation > canvas.height - PLAYER_HEIGHT / 2)
    {
        game.player.y = canvas.height - PLAYER_HEIGHT;
    }
    }

    function computerMove() {
    game.computer.y += game.ball.speed.y * 0.80;
    }

    document.addEventListener('DOMContentLoaded', function(){
    canvas = document.getElementById('canvas');
    canvas.addEventListener('mousemove', playerMove);
    game = {
        player: {
        y: canvas.height / 2 - PLAYER_HEIGHT / 2,
        score: 0
        },
        computer: {
        y: canvas.height / 2 - PLAYER_HEIGHT / 2,
        score: 0
        },

        ball: {
        x: canvas.width / 2,
        y: canvas.height / 2,
        r: 5,
        speed: {
            x: 4,
            y: 4
        }

        }
    }

    draw();
    document.querySelector('#start-game').addEventListener('click', play);
    document.querySelector('#stop-game').addEventListener('click', stop);

    });
</script>