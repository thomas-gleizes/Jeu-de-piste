$(document).ready(() => {
    var bool = false;
    var bool2 = false;
    //fonctions d'ouverture des fenêtre de création et de choix de groupe
    $('.open1').click(function () {
        if (!bool){
            $("#choix").css('height','15rem');
            $("#choix2").css('height','2.8rem');
            $(".cache2").css('display','none');
            $( "#choix" ).removeClass( "open1");
            $( "#choix2" ).addClass( "open2");
            setTimeout( () =>{
                $(".cache").css('display','block');
            },200);
            bool = true;
            bool2 = false;
        }
    });

    $('.open2').click(function () {
        if (!bool2){
            $("#choix2").css('height','15rem');
            $( "#choix2" ).removeClass( "open2");
            $( "#choix" ).addClass( "open1");
            $("#choix").css('height','2.8rem');
            $(".cache").css('display','none');
            setTimeout( () =>{
                $(".cache2").css('display','block');
            },200);
            bool = false;
            bool2 = true;
        }
    });
    //

    var tabvalue = [];
    //intervale permettant de mettre à jour les invitations de l'utilisateurs courant
    setInterval(function () {
        getMyInvit().then(function (value) {
            var tab = value.split('$');
            if (!equals(tab,tabvalue)){
                $(".invit").remove();
                $(".empty").remove();
                tabvalue = tab;
                for (var i = 1; i < tabvalue.length; i++){
                    var tab2 = tab[i].split(',');
                    $("#choix").append(" <div class='invit cache'> <h4 class='nomGroupe'>" + escapeHtml(tab2[1]) + "</h4>" +
                        "<form method='post' action='./../controller/routeur.php'> <input type='hidden' name='Groupe' value='accepterInvit'> " +
                        "<input type='hidden' name='idGroupe' value='"+tab2[0]+"'>" +
                        "<button class='invited ed' type='submit'><i class='material-icons'>done</i></button> " +
                        "</form> <form method='post' action='./../controller/routeur.php'> <input type='hidden' name='Groupe' value='declineInvit'> " +
                        "<input type='hidden' name='idGroupe' value='"+tab2[0]+"'>" +
                        "<button class='invited ed' type='submit'><i class='material-icons'>clear</i></button> </form> </div>" );
                }
                if(bool){
                    $(".cache").css('display','block');
                }
                if (tab == ""){
                    $("#choix").append("<h4 class='empty cache'> Aucune invitation reçu !</h4>");
                }
            }

        });
    },2000);

    function equals(tab1,tab2){
        if (tab1.length == 0 && tab2.length == 0){
            return true;
        } else if (tab1.length!=tab2.length){
            return false;
        } else {
            for (var i = 0; i < tab1.length; i++) {
                if (tab1[i] != tab2[i]){
                    return false
                }
            }
            return true;
        }

    }
    //fonction équivalente à htmlSpecialChar en php
    function escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    //redirection vers la vue spectateur
    $("#spectate").click(function () {
        document.location.href='../view/map.php';
    });

});