$(document).ready(() => {
    let scanner;
    var x;
    //la fonction suivante permet l'ouverture du scanner
    $(".scan").click(function () {
        //ferme tout le reste sur la page
        $('.container').css('display','none');
        $(".scan-container").css('display','block');
        $("#retour").css('display','block');
        //on démarreles caméra avec leur configuration
        var constraints = {video: {facingMode: "environment"}}
        navigator.mediaDevices.getUserMedia(constraints);
        scanner = new Instascan.Scanner(
            {
                video: document.getElementById('preview'),
                mirror: false
            }
        );
        //on ajoute le scan de QRcode à la caméra
        scanner.addListener('scan', function(content) {7
            //on envoie le code du QRcode au php
            sendQRcode(content).then(function (value) {
                //si il est bon on envoie l'utilisateur courant sur la prochaine vue
                if (value == "1"){
                    scanner.stop();
                    clearInterval(x);
                    document.location.href='./routeur.php?Game=displayGame';
                } else if (value == "2"){
                    document.location.href='./routeur.php?Game=displayGame&error=1';
                }
            });


        });
        //on affiche en priorité la caméra de dos du téléphone (ne marche pas sur Iphone)
        Instascan.Camera.getCameras().then(cameras => {
            if(cameras[1]){
                scanner.start(cameras[1]);
            } else if (cameras[0]) {
                scanner.start(cameras[0]);
            } else {
                console.error("Please enable Camera!");
            }
        });
        x = setInterval(function () {
            $(".scan-container").css('height',$("#preview").height());
        },100)
    });

    //intervale permettant de vérifier si la partie éxiste toujours
    setInterval(function () {
        refreshGame().then(function (value) {
            console.log(value);
            if (value == "0"){
                document.location.href='./routeur.php?Game=finirGame';
            } else if (value == "1") {
                document.location.href = './routeur.php?Game=displayGame';
            } else if (value == "2") {
                document.location.href = './routeur.php?Utilisateur=displayPreLobby&error=4';
            }
        });
    },500);



    $('.suivante').click(function () {
        $("#reponse").val('');
        $('.scan').css('display','block');
        $('.enigme').css('height','20rem');
        $('#enigme-text').html('L\'énigme suivante bien détaillé');
        $('#reponse').css('display','block');
        $('.suivante').css('display','none');
        $('.container').css('height','40rem');
    });

    $('#retour').click(function () {
        $('.container').css('display','block');
        $(".scan-container").css('display','none');
        $("#retour").css('display','none');
        scanner.stop();
        clearInterval(x);
    });

    $(".acceuil").click(function ()  {
        document.location.href = './../../index.html';
    });

    //fonction permettant d'envoyer les données de géolocalisation en base
    function maPosition(position) {
        console.log(position.coords.longitude,position.coords.latitude);
        upDateLocalisation(position.coords.longitude,position.coords.latitude);
    }

    if(navigator.geolocation){
        //on vérifie si l'utilisateur courant est le chef du groupe
        getChef().then(function (value) {
            if(value == "1"){
                //watchposition() apelle maPosition à chaque fois que la position de l'utilisateur courant change
                var id = navigator.geolocation.watchPosition(maPosition);
            }
        });
    }

});