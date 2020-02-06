<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("nabzveanzbe");
    session_start();
}

if (!isset($_SESSION['pseudo'])) {
    header("Location:../../index.html");
}

if (!isset($nomParcours)) {
    header("Location:../../index.html");
}

/*echo "pseudo : " . $_SESSION['pseudo'] . "<br>";
echo "idGroupe : " . $_SESSION['groupe'] . "<br>";
echo "Admin : " . $_SESSION['admin'];*/

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>In Game</title>
    <link href="./../../css/inGame.css" rel="stylesheet" type="text/css">
    <link href="./../../css/info.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="./../../image/um.png"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="librairie/instascan.min.js"></script>
    <script src="./../../javascript/inGame.js"></script>
    <script src="./../../javascript/acceuilCanvas.js"></script>
    <script src="./../../javascript/info.js"></script>
</head>
<body>
<div class="container">
    <div class="under-container">
        <div class="enigme">
            <?php
            echo "<h1> Bravo vous avez fini le parcours \"$nomParcours\", avec un total de $score points !</h1>";

            if ($classement != 0) {
                echo "<h1>Vous avez fait un record ! <br> Vous êtes désormais inscrit dans le top $classement  du classement ! </h1>";
            }
            ?>
            <button class="acceuil">retour a l'acceuil</button>
        </div>
    </div>
</div>


<canvas id="canvas"></canvas>
</body>
</html>