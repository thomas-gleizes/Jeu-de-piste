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
<html lang="en">
<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="UTF-8">
    <link>
    <title>Lobby</title>
    <link href="../../css/lobby.css" rel="stylesheet" type="text/css">
    <link href="../../css/info.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="../../image/um.png"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../../javascript/ajax.js"></script>
    <script src="../../javascript/lobby.js"></script>
    <script src="../../javascript/acceuilCanvas.js"></script>
</head>
<body>
<?php
echo "<input type='hidden' id='idGroupe' value='$idGroupe'>";
?>
<div class="container">
    <?php
    $pseudoMembre = "pseudoMembre";
    $idMembre = "idMembre";

    $pseudoInvit = "pseudoInvit";
    $idInvit = "idInvit";

    $i = 1;

    if (isset($_GET['error'])) {
        if ($_GET['error'] == 1) {
            echo "<h2>Pseudo inéxistant, veuillez verifer l'orthographe !</h2>";
        } else if ($_GET['error'] == 2) {
            echo "<h2>Vous ne pouvez pas inviter ce joueur !</h2>";
        } else if ($_GET['error'] == 3) {
            echo "<h2>Ce joueur est déjà dans votre groupe</h2>";
        } else if ($_GET['error'] == 4) {
            echo "<h2>Ce joueur est déjà invité dans le groupe !</h2>";
        } else if ($_GET['error'] == 5) {
            echo "<h2>Vous n'êtes pas autorisé à lancer la partie !</h2>";
        } else if ($_GET['error'] == 6) {
            echo "<h2>Une erreur est survenue ! </h2>";
        } else if ($_GET['error'] == 7) {
            echo "<h2>Vous ne pouvez inviter plus de joueur !</h2>";
        } else if ($_GET['error'] == 8) {
            echo "<h2> Le parcours sélectionné n'existe plus ! </h2>";
        }
    }

    echo "<h1 class='nom-groupe'>" . htmlspecialchars($nomGroupe) . " </h1>
                  <ol class='tab'>
                     <li> <h2> " . htmlspecialchars($_SESSION['pseudo']) . "</h2> </li>";

            foreach ($tabMembre as $value){
                if ($i >= 5) break;
                if ($createur == 1){
                    echo "<li class='connected'> <h3> Connecté : ".htmlspecialchars($value[$pseudoMembre])."</h3><form class='form'  method='post' action='./../controller/routeur.php'>
                            <input type='hidden' name='Groupe' value='supprMembre'>
                            <input type='hidden' name='idUtilisateur' value='$value[$idMembre]'>    
                            <button class='clear' type='submit'> <i class='material-icons'> clear </i></button>
                        </form>";
                } else {
                    echo "<li class='connected'> <h3> Connecté : ".htmlspecialchars($value[$pseudoMembre])."</h3>";
                }
                echo "</li>";
                $i += 1;
            }

            foreach ($tabInvit as $value){
                if ($i >= 5) break;
                echo "<li class='invited'> <h3> En attente : ".htmlspecialchars($value[$pseudoInvit])."</h3>";
                if ($createur == 1){
                    echo "<form class='form'  method='post' action='./../controller/routeur.php'>
                             <input type='hidden' name='Groupe' value='supprInvit'>
                             <input type='hidden' name='idUtilisateur' value='$value[$idInvit]'>    
                             <input type='hidden' name='idGroupe' value='$idGroupe'>  
                             <button class='clear' type='submit'> <i class='material-icons'> clear </i></button>
                          </form>";
                    }
                echo "</li>";
                $i += 1;
            }

    while ($i < 5) {
        $i += 1;

                if ($createur == 0){
                    echo "<li class='invitable'> <h2> En attende de joueur ... </h2></li>";
                } else {
                    echo "<li class='invitable'> 
                        <form class='form' method='post' action='./../controller/routeur.php'>
                            <input type='hidden' name='Groupe' value='invite'>
                            <input class='name' type='text' name='pseudo' required>
                            <button class='invit-button' type='submit'>Inviter <i class='material-icons'>submit</i></button>
                         </form>
                      </li>";
                }
            }
            echo "</ol>";
        ?>
        <div class="loading">
            <span class="span1"></span>
            <span class="span2"></span>
            <span class="span3"></span>
        </div>
        <?php

    $idParcours = "idParcours";
    $nomParcours = "nomParcours";


            if ($createur == 1){
                echo "<form method=\"post\" action=\"./../controller/routeur.php\">
                        <input type='hidden' name='Game' value='lancerGame'>
                        <h2>Choisissez votre parcours</h2>
                        <select class='parcour' name='idParcours'>";
                            foreach ($tabParcours as $item){
                                echo "<option value='$item[$idParcours]'> $item[$nomParcours]</option>";
                            }
                echo  " </select>
                        <button type=\"submit\" id=\"continuer\"> Continuer </button>
                      </form>
                      ";
            }

        ?>
    <form method='post' action='./../controller/routeur.php'>
        <input type='hidden' name='Utilisateur' value='leaveGroupe'>
        <button type='submit'> Quitter </button>
    </form>
    <div class="leave">
        <form method="post" action="./../controller/routeur.php">
            <input type="hidden" name="Utilisateur" value="disconect">
            <button type="submit">Déconnexion</button>
        </form>
    </div>
</div>

<!-- partie à prendre pour avoir le background animé-->
<canvas id="canvas"></canvas>
<!---->

</body>
</html>
