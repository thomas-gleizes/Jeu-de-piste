//toutes les requêtes ajax ci-dessous respecte le MVC

//requête ajax permettant de récupérer les membre connecté du groupe
async function getMember(){
    var result;
    await $.ajax({
        url : '../controller/routeur.php',
        type : 'GET',
        data : 'Ajax=refreshLobby' ,
        dataType : 'text',
        success : function(resultat, statut){
            result = resultat;
        },
    });
    return result;
}

//requête ajax permettant de récupérer les membre invité du groupe
async function getInvit(){
    var result;
    await $.ajax({
        url : '../controller/routeur.php',
        type : 'GET',
        data : 'Ajax=refreshInvit' ,
        dataType : 'text',
        success : function(resultat, statut){
            result = resultat;
        },
    });
    return result;
}

//requête ajax permettant qui permet de vérifier si l'utilisateur courant est le créateur du groupe courant
async function getCreateur() {
    var result;
    await $.ajax({
        url : '../controller/routeur.php',
        type : 'GET',
        data : 'Ajax=getCreateur',
        dataType : 'text',
        success : function(resultat, statut){
            result = resultat;
        },
    });
    return result;
}

//requête ajax permettant de récupéré les invitations
async function getMyInvit(){
    var result;
    await $.ajax({
        url : '../controller/routeur.php',
        type : 'GET',
        data : 'Ajax=refreshPreLobby' ,
        dataType : 'text',
        success : function(resultat, statut){
            result = resultat;
        },
    });
    return result;
}

//requête ajax permettant de vérifier si l'utilisateur actuelle n'a pas été renvoyer du groue
// ou alors que le groupe courant n'a pas été supprimé
async function getState(){
    var result;
    await $.ajax({
        url : '../controller/routeur.php',
        type : 'GET',
        data : 'Ajax=getStateGame' ,
        dataType : 'text',
        success : function(resultat, statut){
            result = resultat;
        },
    });
    return result;
}

//requête ajax similaire à celle ci-dessus mais pas utilisé dans la meme page
async function refreshGame(){
    var result;
    await $.ajax({
        url : '../controller/routeur.php',
        type : 'GET',
        data : 'Ajax=refreshGame' ,
        dataType : 'text',
        success : function(resultat, statut){
            result = resultat;
        },
    });
    return result;
}

//fonction permettant d'envoyer le code du QRcode scanné dans le php qui va faire toutes les vérification nécessaire avec
async function sendQRcode(QRcode) {
    var result;
    await $.ajax({
        url : '../controller/routeur.php',
        type : 'GET',
        data : 'Ajax=validerQRcode&QRcode='+QRcode,
        dataType : 'text',
        success : function(resultat, statut){
            result = resultat;
        },
    });
    return result;
}

//requête ajax permettant de récupéré le nom de tout les groupes avec leurs géolocalisation
async function refreshLocalisation(){
    var result;
    await $.ajax({
        url : '../controller/routeur.php',
        tyoe : 'GET',
        data : 'Ajax=getLocalisation',
        dataType : 'text',
        success : function (resultat, statut){
            result = resultat;
        }
    });
    return result;
}

//requête ajax permettant d'envoyer vers la base de données les données de géolocalisation de l'utilisateur courant
function upDateLocalisation(longitude, latitude){
    $.ajax({
        url : '../controller/routeur.php',
        tyoe : 'GET',
        data : 'Ajax=updateLocalisation&longitude='+longitude+'&latitude='+latitude,
        dataType : 'text',
        success : function (resultat, statut){
        }
    });
}

//requête ajax permettant de vérifier si l'utilisateur courant est le chef du groupe
async function getChef() {
    var result;
    await $.ajax({
        url : '../controller/routeur.php',
        type : 'GET',
        data : 'Ajax=getChef',
        dataType : 'text',
        success : function(resultat, statut){
            result = resultat;
        },
    });
    return result;
}

