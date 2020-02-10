<!DOCTYPE html>
<html lang="fr">
<?php session_start(); ?>
<?php $page = 'recherche';?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jeux Academy | Recherche : <?php echo $_REQUEST['recherche']; ?></title>
    <link rel="icon" href="images/favicon.ico" />

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/jeu.css" type="text/css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">
</head>

<body>
    <?php include 'nav.php';?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <?php echo $_REQUEST['recherche']; ?>
        </div>
    </div>
    <!-- /.container -->
    
    <!-- Footer -->
    <?php include 'footer.html';?>
</body>

</html>
