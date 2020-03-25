<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Editeur JS</title>
</head>
<body>
  <div class="container">
    <div class="containerEditor" method="post">
      <h2>Ecrivez votre code JS</h2>
      <form class="editCode" action="editor.php">
        <input type="submit" value='run'>
        <textarea id="codeUser" name="codeUser" rows="40" cols="50"></textarea>
      </form>
    </div>

    <div class="containerRendu">
      <h2>Rendu</h2>
      <div class="containerPrint">
        <canvas id="cassebriques" width="916" height="640"></canvas>
        <script>
          var canvas = document.getElementById("cassebriques");
          var ctx = canvas.getContext("2d");
        </script>
        <?php
        if (isset($_REQUEST['codeUser'])){
          echo "<script>".$_REQUEST['codeUser']."</script>";
        }
        ?>
        <!-- Code à écrire dans la page web pour tester
          ctx.beginPath();
          ctx.rect(500, 500, 75, 10);
          ctx.fillStyle = "#0095DD";
          ctx.fill();
          ctx.closePath();
         -->
      </div>
    </div>
  </div>
</body>
</html>