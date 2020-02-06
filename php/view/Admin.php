<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("nabzveanzbe");
    session_start();
}

if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin'] != 1) {
        header("Location:./../../index.html");
    }
} else {
    header("Location:./../../index.html");
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="icon" type="image/png" href="./../../image/um.png"/>
    <link href="../../css/Admin.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Oswald|Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="./../../javascript/ajax.js"></script>
    <script src="./../../javascript/index.js"></script>
    <script src="./../../javascript/acceuilCanvas.js"></script>
    <script src="./../../javascript/info.js"></script>
</head>
<body>
<center>
    <h1> Vue Admin</h1>
    <?php
    $idParcours = "idParcours";
    $nomParcours = "nomParcours";

    $idEnigme = "idEnigme";
    $intitule = "intitule";
    $reponse = "reponse";

    if (isset($_GET['status'])) {
        if ($_GET['status'] == 1) {
            echo "<h2> Parcours créée ! </h2>";
        } else if ($_GET['status'] == 2) {
            echo "<h2> Enigme créée ! </h2>";
        } else if ($_GET['status'] == 3) {
            echo "<h2> Point de passage ! </h2>";
        } else if ($_GET['status'] == 4) {
            echo "<h2> Parcours suprimé !</h2>";
        }
    }
    ?>
    <div class="div">
        <h2> Générer un Qr code</h2>
        <form method='get' action='./../controller/routeur.php'>
            <input type='number' min="1" name='idPP' placeholder='id Point de passage'>
            <select name="idParcours">
                <?php
                foreach ($tabParcours as $value) {
                    echo "<option class='form' value='$value[$idParcours]'>$value[$nomParcours]</option>";
                }
                ?>
            </select>
            <input type='hidden' name='Admin' value='hashMe'>
            <button type='submit'>Hasher Code</button>
        </form>
        <?php
        if (isset($_GET['res'])) {
            echo "<h2 class='code'>Résultat : " . $_GET['res'] . "</h2>";
            echo "<center><img src='./../../image/QrCode.png'/></center>";
        }
        ?>
    </div>

    <div class="div">
        <h2>Généré un PDF</h2>
        <form method="post" action="./../controller/routeur.php">
            <input type="hidden" name="Admin" value="generatePdf">
            <select name="idParcours">
                <?php
                foreach ($tabParcours as $value) {
                    echo "<option class='form' value='$value[$idParcours]'>$value[$nomParcours]</option>";
                }
                ?>
            </select>
            <button class="pdf" type="submit">Générer</button>
        </form>
    </div>

    <div class="div">
        <h2> Gesion parcours</h2>
        <form method="post" action="./../controller/routeur.php">
            <input type="hidden" name="Admin" value="creeParcours">
            <input type="text" class="form" name="nomParcours" placeholder="Nom du parcours" required>
            <button type="submit"> Envoyer</button>
        </form>
        <form class="form" method="post" action="./../controller/routeur.php">
            <input type="hidden" name="Admin" value="supprParcours">
            <select name="idParcours">
                <?php
                foreach ($tabParcours as $value) {
                    echo "<option class='form' value='$value[$idParcours]'>$value[$nomParcours]</option>";
                }
                ?>
            </select>
            <button type="submit">Supprimer</button>
        </form>
    </div>

    <div class="div">
        <h2>Créer enigme</h2>
        <form method="post" action="./../controller/routeur.php">
            <input type="hidden" name="Admin" value="creeEnigme">
            <input type="text" name="intitule" placeholder="Intitulé de l'énigme" required>
            <input type="text" name="reponse" placeholder="Réponse de l'énigme" required>
            <button type="submit">Envoyer</button>
        </form>
    </div>

    <div class="div">
        <h2>Ajouter un point de passage</h2>
        <form method="post" action="./../controller/routeur.php">
            <input type="hidden" name="Admin" value="ajouterPP">
            <select name="idParcours">
                <?php
                foreach ($tabParcours as $value) {
                    echo "<option value='$value[$idParcours]'>$value[$nomParcours]</option>";
                }
                ?>
            </select>
            <select name="idEnigme">
                <?php
                foreach ($tabEnigmes as $item) {
                    echo "<option value='$item[$idEnigme]'> $item[$intitule] - $item[$reponse]</option>";
                }
                ?>
            </select>
            <input type="text" name="localisation" placeholder="Localisation du point de passage" required>
            <input type="text" name="info" placeholder="Information sur le point de passage">
            <button type="submit"> Envoyer</button>
        </form>
    </div>

    <div class="div">
        <form method="post" action="./../controller/routeur.php">
            <input type="hidden" name="Utilisateur" value="disconect">
            <button type="submit">Déconnexion</button>
        </form>
    </div>

</center>

<!-- partie à prendre pour avoir le background animé-->

<!---->
</body>
</html>