<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jeux-Academy') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Old head --}}
    <link rel="icon" href="images/favicon.ico" />

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- Css font awesome -->
    <link type="text/css" href="css/all.min.css" rel="stylesheet" />

    <link href="css/jeu.css" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" href="css/login.css" media="screen" type="text/css" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="nav">
        <div class="container" id="nav">
            <a class="navbar-brand" href="index.php"><i class="fas fa-gamepad"></i> Jeux Academy</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <form id="searchForm" class="research" action="{{ route('index') }}">
                    <input type="search" name="recherche" id="recherche" placeholder="Rercherche">
                </form>
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>

                        @if (Route::has('register'))
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        @endif
                    @endauth
                @endif
                <?php
                    // if($page == 'index') {
                    //     echo '<li class="nav-item"><a class="nav-link active" href="index.php"><i class="fas fa-home"></i> Accueil</a></li>';
                    // }
                    // else {
                    //     echo '<li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home"></i> Accueil</a></li>';
                    // }

                    // if(isset($_GET['deconnexion'])) {
                    //     if($_GET['deconnexion']==true) {
                    //         session_unset();
                    //         header("location:index.php");
                    //     }
                    // }
                    // else if(isset($_SESSION['pseudo'])) {
                    //     if($page == 'profil') {
                    //         echo '<li class="nav-item"><a class="nav-link active" href="profil.php?pseudo='.$_SESSION['pseudo'].'"><i class="fas fa-user"></i> Profil</a></li>';
                    //     }
                    //     else {
                    //         echo '<li class="nav-item"><a class="nav-link" href="profil.php?pseudo='.$_SESSION['pseudo'].'"><i class="fas fa-user"></i> Profil</a></li>';
                    //     }

                    //     echo '<li class="nav-item"><a class="nav-link" href="index.php?deconnexion=true"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>';
                    // }
                    // else {
                    //     if($page == 'login') {
                    //         echo '<a class="nav-link active" href="login.php"><i class="fas fa-sign-in-alt"></i> Connexion/inscription</a>';
                    //     }
                    //     else if($page == 'jeu') {
                    //         $_SESSION['jeu_url'] = $_SERVER['REQUEST_URI'];
                    //         header('Location: login.php');
                    //     }
                    //     else {
                    //         echo '<a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Connexion/inscription</a>';
                    //     }

                    // }
                ?>
            </ul>
            </div>
        </div>
    </nav>
</body>
</html>
