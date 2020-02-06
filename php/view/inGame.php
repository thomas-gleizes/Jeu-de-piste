<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("nabzveanzbe");
    session_start();
}

if (!isset($_SESSION['pseudo'])) {
    header("Location:../../index.html");
}

if ($_SESSION['groupe'] == 0) {
    header("Location:../controller/routeur.php?Utilisateur=displayPreLobby");
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
    <script type="text/javascript" src="./../../librairie/instascan.min.js"></script>
    <script src="../../javascript/ajax.js"></script>
    <script src="./../../javascript/inGame.js"></script>
    <script src="./../../javascript/acceuilCanvas.js"></script>
    <script src="./../../javascript/info.js"></script>
</head>
<body>
<div class="container">
    <div class="under-container">
        <?php echo "<h1>" . htmlspecialchars($nomGroupe) . " - $nomParcours</h1>" ?>
        <div class="enigme">
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 1){
                    echo "<center><h2 style='color:red'> Mauvaise réponse ! Essayez encore ! </h2></center>";
                } else if ($_GET['error'] == 2){
                    echo "<center><h2> Mauvais QR code ! </h2></center>";
                } else if ($_GET['error'] == 3){
                    echo "<center><h2>Veillez revenir dans la zone de l'IUT</h2></center>";
                }
            }
            if ($statusPP == 1) {
                echo "<p id='enigme-text'> Pour accéder l'énigme numéro $idPP, rendez vous devant $localisation, <br> puis scanner le QR code </p>";
                if ($Chef == 1) {
                    echo "<button class=\"scan\"><i id =\"scan-icon\" class=\"material-icons\">crop_free</i><p>Activer le scanner</p></button>";
                } else {
                    echo "<p>En attende de scan du chef d'équipe...</p>";
                }

            } else {
                if (!empty($info)) echo "<p id='enigme-text' >  Informaton : " . $info . " <br></p>";
                echo "<p id='enigme-text'>Voici l'énigme numéro " . $idPP . " :  <br> " . $intitule . " </p>";
                if ($Chef == 1) {
                    echo "<form method=\"post\" action=\"./../controller/routeur.php\">
                            <input type=\"hidden\" name=\"Game\" value=\"validerReponse\">
                            <input type=\"hidden\" name=\"idEnigme\" value=' $idEnigme '>
                            <input id='reponse' type='text' name=\"reponse\" placeholder='votre réponse' required/>
                            <button type=\"submit\"> Envoyer votre Réponse </button>
                          </form>";
                } else {
                    echo "<p> En attende de la réponse du chef d'équipe...";
                }
            }

            ?>
        </div>

        <div class="info-groupe">
            <?php

            echo "<p>score du groupe: " . $score . " points</p>
                  <p>nombre de point de passage passer : " . $idPP . " sur " . $nbEnigmes . "</p>
                  <form method='post' action='./../controller/routeur.php'>
                      <input type='hidden' name='Utilisateur' value='leaveGroupe'>
                      <button type='submit'> Quitter </button>  
                  </form>";
            ?>
        </div>
    </div>
    <form method="post" action="./../controller/routeur.php">
        <input type="hidden" name="Utilisateur" value="disconect">
        <button type="submit">Déconnexion</button>
    </form>

</div>
<i id="retour" class="material-icons">arrow_back</i>
<div class="scan-container">
    <video id="preview" playsinline></video>
    <img id="scanpng" src="./../../image/scanIcon.png" alt="icone du scanner"/>
</div>

<div class="leave">

</div>

<!-- partie à prendre pour avoir le background animé-->
<canvas id="canvas"></canvas>
<!---->
</body>
</html>