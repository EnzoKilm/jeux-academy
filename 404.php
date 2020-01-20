<!DOCTYPE html>
<html lang="fr">
<?php session_start(); ?>
<?php $page = '404';?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Acadey | Erreur 404</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/79706d8da0.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'nav.php';?>

    <!-- Page Content -->
    <div class="error404">
        <h1>La page recherchée n'existe pas</h1>
    </div>

    <!-- Footer -->
    <?php include 'footer.html';?>
</body>

</html>
