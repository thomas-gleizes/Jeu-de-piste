<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("nabzveanzbe");
    session_start();
}
if (!isset($_SESSION['pseudo'])) {
    header("Location:./../../index.html");
}

if ($_SESSION['admin'] == 1) {
    header("Location:./../controller/routeur.php?Admin=displayViewAdmin");
}

if ($_SESSION['groupe'] != 0) {
    header("Location:./../controller/routeur.php?Groupe=displayGroupe");
}

/*echo "pseudo : " . $_SESSION['pseudo'] . "<br>";
echo "idGroupe : " . $_SESSION['groupe'] . "<br>";
echo "Admin : " . $_SESSION['admin'];*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Sélection de groupe</title>
    <link href="../../css/preLobby.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="../../image/um.png"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../../javascript/ajax.js"></script>
    <script src="../../javascript/preLobby.js"></script>
    <script src="../../javascript/acceuilCanvas.js"></script>
</head>
<body>
    <div class="container">
        <?php
        echo "<h1>Bonjour " . htmlspecialchars($_SESSION['pseudo']) . " !</h1>";
        if (isset($_GET['error'])){
            if ($_GET['error'] == 3){
                echo "<h2> Vous n'avez pas été invité dans ce groupe ! </h2>";
            } else if ($_GET['error'] == 1){
                echo "<h2>Le nom de groupe est indisponnible !</h2>";
            } else if ($_GET['error'] == 2){
                echo "<h2> Le groupe a été supprimé !</h2>";
            } else if ($_GET['error'] == 4){
                echo "<h2> Vous avez été exclu du groupe !</h2>";
            } else if ($_GET['error'] == 5){
                echo "<h2> Le groupe est plein ! </h2>";
            } else if ($_GET['error'] == 6){
                echo "<h2> Le nom du groupe ne convient pas ! </h2>";
            }
        }
        ?>
        <div id="choix" class="div open1">
            <h1 >Rejoindre un groupe</h1>
            <p class="cache">Invitation:</p>
            <?php
                $idGroupe = "idGroupe";
                $nomGroupe = "nomGroupe";
                if (empty($tabInvit)){
                    echo "<h4 class='empty cache'> Aucune invitation reçue !</h4>";
                } else {
                    foreach ($tabInvit as $value){
                        echo "<div class='invit cache'>
                            <h4 class='nomGroupe'>".htmlspecialchars($value[$nomGroupe])."</h4>
                            <form method='post' action='./../controller/routeur.php'>
                                <input type='hidden' name='Groupe' value='accepterInvit'>
                                <input type='hidden' name='idGroupe' value='$value[$idGroupe]'>
                                <button class='invited' type='submit'><i class='material-icons'>done</i></button>
                            </form>
                            <form method='post' action='./../controller/routeur.php'>
                                <input type='hidden' name='Groupe' value='declineInvit'>   
                                <input type='hidden' name='idGroupe' value='$value[$idGroupe]'>                
                                <button class='invited' type='submit'><i class='material-icons'>clear</i></button>
                            </form>
                        </div>";
            }
        }
        ?>
    </div>
    <div id="choix2" class="div open2">
        <h1>Créer un groupe</h1>
        <p class="cache2"> Choisiez le nom de votre groupe.</p>
        <form method="post" action="./../controller/routeur.php">
            <input type="hidden" name="Groupe" value="creeGroupe"/>
            <input type="text" class="cache2" name="nomGroupe" required/>
            <button type="submit" class="cache2" id="ok">ok</button>
        </form>
    </div>
        <form method="post" action="./../controller/routeur.php">
            <input type="hidden" name="Utilisateur" value="disconect">
            <button type="submit">Déconnexion</button>
        </form>
        <button id="spectate"> Spectateur</button>
</div>
<!-- partie à prendre pour avoir le background animé-->
<canvas id="canvas"></canvas>
</body>
</html>
