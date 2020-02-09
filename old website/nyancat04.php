<!DOCTYPE html>
<html lang="fr">
<?php session_start(); ?>
<?php $page = '404';?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Acadey | NyanCat cent quatre</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="css/nyancat04.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'nav.php';?>

    <!-- <audio autoplay loop>
        <source src="musiques/nyancat.mp3" type="audio/mpeg">
        Votre navigateur ne supporte pas la balise audio.
    </audio> -->

    <!-- Page Content -->
    <center id='center'></center>
    <div class="nyan" id="nyan">
    </div>

    <!-- Footer -->
    <?php include 'footer.html';?>

    <!-- <script src="js/nyancat04.js"></script> -->
    <!-- <script src="js/test.js"></script> -->
    <script src="js/jeupiecesnyan.js"></script>
</body>

</html>
