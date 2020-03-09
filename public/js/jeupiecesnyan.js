// On enlève le curseur
document.getElementById("center").style.cursor = "none";
document.getElementById("nyan").style.cursor = "none";
document.getElementById("nyan").style.cursor = "none";
document.querySelector("footer").style.cursor = "none";

// NyanCat
var posX = 100, posY = 100, px = 0, py = 0, an = false;
var nyan = $('.nyan');
var rainbow = null;
var altura = 800;
var largura = parseInt($('body').width());
var tamanhoTela = parseInt(largura/9);
var pilha = [];

function getRandomInt(min, max){ return Math.floor(Math.random() * (max - min + 1)) + min; }

$(document).on('mousemove', function( event ) {
  posX = event.pageX;
  posY = event.pageY;
})

for(var i = 0; i < tamanhoTela; i++)
{
  var rain = $('<div class="rainbow"/>').css('left', i*9+'px');
  $('body').append(rain);
}
rainbow = $('.rainbow');

function criarEstrela()
{
    var rand = getRandomInt(3, 14);
  var tempoDeVida = getRandomInt(5,10);
    var star = $('<div class="star"/>').css({
      width:rand+'px',
      height:rand+'px',
      left: largura-10+'px', 
      top: Math.floor((Math.random()*altura)+1), 
      '-webkit-transition': 'all '+tempoDeVida+'s linear',
      '-webkit-transform': 'translate(0px, 0px)'
    });
    $('body').append(star);
    
    window.setTimeout(function(){
      star.css({
        '-webkit-transform': 'translate(-'+largura+'px, 0px)'
      });
    }, getRandomInt(5,10)*10);  

  window.setTimeout(function(){star.remove();}, tempoDeVida*1000);
}

function moveNyan()
{
    var tamX = nyan.width()/2,
      tamY = nyan.height()/2;
    px += (posX - px - tamX) / 50;
    py += (posY - py - tamY) / 50;
 
    nyan.css({
      left: px + 'px',
      top: py + 'px'
    });

    ctx.fillStyle = "#0F4D8F";
    ctx.fillRect(px+2, py-56, 32, 32);
}
function peidaArcoIris()
{
  var qnt = Math.floor(nyan.position().left/9)+2;

  if(pilha.length >= qnt) pilha.pop();
  
  pilha.unshift(py);
  
  rainbow.hide();
  for(var i = 0; i < qnt; i++)
  {
    var am = (i%2);
    if(an) am = (i%2) ? 0 : 1 ;
    
    rainbow.eq(qnt-i).css({top: pilha[i]+am}).show();
  }
}

window.setInterval(function(){
  moveNyan();
  peidaArcoIris();
}, 10);

window.setInterval(function(){ criarEstrela(); }, 300);

window.setInterval(function(){ an = !an; }, 500);

var frame = 0;
window.setInterval(function(){   
  nyan.css({'background-position': 34*frame+'px'});
  frame++;
}, 100);


// Jeu pièces
var canvas = $("<canvas id='canvas' width='1520' height='600'></canvas>");

var mousex = 160,
    mousey = 120;

var finished = false;

var score = 0,
    coinslost = 0;

canvas.appendTo('#center');

var ctx = canvas.get(0).getContext("2d");

var keydown = [];

for(var i=0; i<128; i++)
{
  keydown[i] = false;
}

setInterval(function(){
  update();
  draw();
}, 100/60);

setInterval(function(){
  if(Math.random()>0.985)
  {
  addCoin();
  }
}, 100/30);

var player = {
  x: posX,
  y: posY,
  width: 32,
  height: 32,
  yspeed: 0
};

var gravity = .5;

function draw()
{
  if (finished==false)
  {
  ctx.clearRect(0,0,1520,600);
  
  coins.forEach(function(coin){
    if (coin.active)
    {
    coin.draw();
    }
  });
  

  ctx.fillStyle = "white";
  ctx.fillText("Score: " + score, 676, 50);
  ctx.font = "46px Bangers, cursive";
  ctx.fillText("Pièces perdues: " + coinslost, 625, 552);
  }
  else
  {
    ctx.clearRect(0,0,1520,600);
    ctx.fillText("Vous avez gagné avec " + finishedcoins + " pièces perdues!", 80, 120);
  }
  
}

var finishedcoins;

function update()
{
  if (finished)
  {
    exit;
  }
  if (score>=100)
  {
    finished = true;
    finishedcoins = coinslost;
  }
  gravity+=.5;
  
  coins.forEach(function(coin){
    if(coin.active)
    {
    coin.update();
    }
  });
  
}

var coins = [];

function addCoin()
{
  var coin = {
    active: true,
    x: 1600,
    y: Math.random()*550,
    width: 16,
    height: 8,
    gravity: 0.15,
    draw: function(){
      ctx.fillStyle = "yellow";
      ctx.beginPath();
    //   ctx.arc(this.x, this.y, 10, 0, 2 * Math.PI);
      var img = new Image();
      img.src="images/coin.png";
      ctx.drawImage(img, this.x, this.y, 26, 26);
      ctx.fill();
    },
    
    update: function(){
     
      this.gravity-=0.15;
      this.x+=this.gravity;
      
      if (this.gravity<-3)
      {
        this.gravity = -3;
      }
      
      if(collides(this,player))
      {
        score++;
        this.active = false;
      }
      
      if(this.x<0)
      {
        this.active = false;
        coinslost++;
      }
      
    }
  };
  
  coins.push(coin);
  
}

$(document).keypress(function(event){
  keydown[event.which] = true;
});

$(document).keyup(function(event){
  keydown[event.which] = false;
});

function collides(a, b) {
  
  if(b==player)
  {
    b = {

      x: px+2,
      y: py-56,
      width: player.width,
      height: player.height
    }
  }
  
  return a.x < b.x + b.width &&
         a.x + a.width > b.x &&
         a.y < b.y + b.height &&
         a.y + a.height > b.y;
}

$('#canvas').mousedown(function(e){
  if (gravity==0)
    {
      player.yspeed = 12;
    }
  
  addCoin();
});

$("#canvas").mousemove(function(e){

  mousex = e.pageX-this.offsetLeft;  
  mousey = e.pageY-this.offsetTop;
  
  player.x = e.pageX-this.offsetLeft;
  
});
