$(document).ready(() => {
    var count = 0;
    var x = setInterval(() =>{
        if (count == 0)$('span').css('display', 'none'),count++;
        else if (count == 1)$('.span1').css('display', 'inline-block'),count++;
        else if (count == 2)$('.span2').css('display', 'inline-block'),count++;
        else if (count == 3)$('.span3').css('display', 'inline-block'),count = 0;
    },300);


    $('#ok').click(function () {
        var pseudo = $('#reponse').val();
        var groupe = $('#nom-groupe').html();
        invit(pseudo, groupe);
        $('#reponse').val('');
        $(".container2").css('display','none');
    });

    //fonction permettant de mettre à jour les informations des membre connecté ou invité en faisant des insertions dans le html
    var tabMember = [""];
    var tabInvit = [""];
    setInterval(async function () {
        await getState().then(function (value) {
            if (value == "1"){
                document.location.href='./routeur.php?Utilisateur=displayPreLobby&error=4';
            } else if (value == "0") {
                document.location.href = './routeur.php?Game=displayGame';
            }
        });
        var creator;
        //on vérifie si 'utilisateur courant est le créateur du groupe
        await getCreateur().then(function (value) {
            creator = value;
        });
        var count = 0;
        var change = false;
        var pseudo = $('#pseudo').val();
        var idGroupe = $("#idGroupe").val();
        //on récupère les membres connecté du groupe
        await getMember().then(function (value) {
            //on split une première fois le string reçue par la requête ajax
            var tab = value.split('$');
            //on vérifie s'il contient de nouvelles données
            if (!equals(tabMember,tab)){
                $(".invited").remove();
                $(".connected").remove();
                for (var i = 1; i < tab.length; i++){
                    var tab2 = tab[i].split(',');
                    //on affiche les nouvelles données différament pour le créateur et pour un membre du groupe normal
                    if (creator == "1") {
                        $(".tab").append("<li class='connected'> <h3> Connecté :  " + escapeHtml(tab2[1]) + "</h3><form class='form' method='post' action='./../controller/routeur.php'>" +
                            "<input type='hidden' name='Groupe' value='supprMembre'>" +
                            "<input type='hidden' name='idUtilisateur' value='" + tab2[0] + "'>" +
                            "<input type='hidden' name='idGroupe' value='" + idGroupe + "'>" +
                            "<button class='clear' type='submit'> <i class='material-icons'> clear </i></button>" +
                            "</form></li>");
                    } else {
                        $(".tab").append("<li class='connected'> <h3> Connecté :  " + escapeHtml(tab2[1]) + "</h3></li>");
                    }
                    count++;
                }
                change = true;
                tabMember = tab;
            }
        });
        //même principe mais pour le smembre invité du groupe
        await getInvit().then(function (value) {
            var tab = value.split('$');
            if (!equals(tabInvit,tab)) {
                $(".invited").remove();
                for (var i = 1; i < tab.length; i++) {
                    var tab2 = tab[i].split(',');
                    if (creator == "1") {
                        $(".tab").append("<li class='invited'> <h3> En attente :  " + escapeHtml(tab2[1]) + "</h3><form class='form' method='post' action='./../controller/routeur.php'>" +
                            "<input type='hidden' name='Groupe' value='supprMembre'>" +
                            "<input type='hidden' name='idUtilisateur' value='" + tab2[0] + "'>" +
                            "<input type='hidden' name='idGroupe' value='" + idGroupe + "'>" +
                            "<button class='clear' type='submit'> <i class='material-icons'> clear </i></button>" +
                            "</form></li>");
                    } else {
                        $(".tab").append("<li class='invited'> <h3> En attente :  " + escapeHtml(tab2[1]) + "</h3></li>");
                    }
                    count++;
                }
                tabInvit = tab;
                change = true;
            }
        });

        if (change) {
            //on complète avec le form d'invitation pour le créateur et avec "en attente de joueur" pour un memebre normal
            $(".invitable").remove();
            if (creator == "0") {
                while (count < 4) {
                    $(".tab").append("<li class='invitable'> <h2> En attende de joueur ... </h2></li>");
                    count++;
                }
            } else {
                while (count < 4){
                    $(".tab").append("<li class='invitable'> " +
                        "<form class='form' method='post' action='./../controller/routeur.php'> " +
                        "<input type='hidden' name='Groupe' value='invite'> " +
                        "<input class='name' type='text' name='pseudo' required> " +
                        "<button class='invit-button' type='submit'>Inviter <i class='material-icons'>submit</i></button> " +
                        "</form> </li>");
                    count++;
                }
            }
        }


    },2000);

    function equals(tab1,tab2){
        if (tab1.length == 0 && tab2.length == 0){
            return true;
        } else if (tab1.length!=tab2.length){
            return false;
        }else {
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
});