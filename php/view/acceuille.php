<?php

if (!isset($_GET['Utilisateur'])){
    header("Location:./../../index.html");
}

if (session_status() == PHP_SESSION_NONE) {
    session_name("nabzveanzbe");
    session_start();
}

if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin'] == 1) {
        header('Location:./routeur.php?Admin=displayViewAdmin');
    }
}

if (isset($_SESSION['groupe'])) {
    if ($_SESSION['groupe'] != 0) {
        header("Location:./routeur.php?Groupe=DisplayGroupe");
    }
}

if (isset($_SESSION['pseudo'])) {
    header("Location:./routeur.php?Utilisateur=displayPreLobby");
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Jeu de piste</title>
    <link href="../../css/index.css" rel="stylesheet" type="text/css">
    <link href="../../css/info.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="../../image/um.png"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../../javascript/ajax.js"></script>
    <script src="../../javascript/index.js"></script>
    <script src="../../javascript/acceuilCanvas.js"></script>
    <script src="../../javascript/info.js"></script>
</head>
<body>
<img id="um" src="../../image/um.png"/>
<img id="iut" src="../../image/iut.png"/>
<div class="container">
    <div class="leaderboard">
        <i id="quit" class="material-icons">clear</i>
        <h1 id="classement-titre">Classement</h1>
        <ol class="list">
            <?php
            if (isset($tab)){
                $nomGroupe = "nomGroupe";
                $score = "score";
                foreach ($tab as $value){
                    echo "<li class='list-group>'>
                            <h2> $value[$nomGroupe] - $value[$score] points</h2>
                          </li>";
                }
            } else {
                echo "<h3>Une erreur est survenue !</h3>";
            }
            ?>
        </ol>
    </div>
    <!-- <div class="under-container">
        <h1>Bienvenue !</h1>
        <input type="text" placeholder="Identifiant" id="iden" required/>
        <input type="password" placeholder="Mot de passe" required/>
        <button id="ok"><p>ok</p></button>
        <button id="classement"><i id="list" class="material-icons">list</i><p id="text">classement général</p></button>
    </div>-->
    <img id="treasure" src="../../image/treasure.png">
    <div id="intro"><p>Bienvenue sur la platforme du jeu de piste au travers de l'IUT !</p></div>
    <div class="under-container">

        <div id="choix" class="div open1">
            <h1> Connexion </h1>
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 3) {
                    echo "<h2   class='cachet'>Cette combinaison Login - Mot de passe n'éxiste pas !</h2>";
                }
            }
            ?>
            <form class='cache' method="post" action="../controller/routeur.php">
                <input type="text" placeholder="Pseudo" name="pseudo" required>
                <input type="password" placeholder="Password" name="mdp" required autocomplete="current-password">
                <input type="hidden" name="Utilisateur" value="connexion">
                <button type="submit"> Connexion</button>
            </form>
        </div>
        <div id="choix2" class="div open2">
            <h1> Inscription </h1>
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 1) {
                    echo "<h2 class='cache2t'> Les mot de passe ne correspond pas ! </h2>";
                } else if ($_GET['error'] == 2) {
                    echo "<h2 class='cache2t'> Ce pseudo existe déja ! </h2>";
                } else if ($_GET['error'] == 4) {
                    echo "<h2 class='cache2t'> Le pseudo est invalide ! </h2>";
                } else if ($_GET['error'] == 5) {
                    echo "<h2 class='cache2t'> Le mot de passe est trop court ! </h2>";
                } else if ($_GET['error'] == 6) {
                    echo "<h2 class='cache2t'> Vous ne pouvez pas utiliser d'emoji ! </h2>";
                } else if ($_GET['error'] == 7){
                    echo "<h2 class='cache2t'> Le pseudo est trop long !</h2>";
                }
            }
            ?>
            <form class='cache2' method="post" action="../controller/routeur.php">
                <input type="text" placeholder="Pseudo" name="pseudo" required>
                <input type="password" placeholder="Mot de passe" name="mdp1" required autocomplete="new-password">
                <input type="password" placeholder="Confirmez mot de passe" name="mdp2" required
                       autocomplete="new-password">
                <input type="hidden" name="Utilisateur" value="inscription">
                <button type="submit"> Inscription</button>
            </form>
        </div>

        <div id="classement">
            <h3> Classement</h3>
        </div>
        <button id="spectate"> Spectateur</button>
    </div>
</div>


<!-- partie à prendre pour avoir le bouton d'inforamtion-->
<div id="div-info">
    <p class="info-p">Cette acceuil est prévu pour jouer à un <br> jeu de chasse aux trésors dans tout l'IUT</p>
    <p class="info-p">cette application utilisera vos données de géolocalisation et votre caméra dans son fonctionnement</p>
    <i id="info1" class="material-icons">clear</i>
</div>
<button id="info-button" onclick=''><i id="info" class="material-icons">info</i></button>
<!---->


<!-- partie à prendre pour avoir le background animé-->
<canvas id="canvas"></canvas>
<!---->
</body>
</html>
