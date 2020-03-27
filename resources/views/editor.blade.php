@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="editor">
            <div class="card-header">Création du jeu</div>

            <div class="card-body">
                <div class="containerEditor" method="post">
                    <h2>Ecrivez votre code JS</h2>
                    <form class="editCode" action="{{ route('editor') }}">
                        <textarea id="codeUser" name="codeUser"></textarea>
                        <input type="submit" value='run'>
                    </form>
                </div>
            </div>
        </div>
        <div class="render">
            <div class="card-header">Rendu</div>

            <div class="card-body render-body">
                <canvas id="cassebriques" width="600" height="500"></canvas>
                <script>
                var canvas = document.getElementById("cassebriques");
                var ctx = canvas.getContext("2d");
                </script>
                <?php
                if (isset($_REQUEST['codeUser'])){
                echo "<script>".$_REQUEST['codeUser']."</script>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
@endsection
