$(document).ready(() => {
    //l'algorithme suivant permet l'ouverture des fenêtre de connexion et d'inscription
    var bool = false;
    var bool2 = false;
    $('.open1').click(function () {
        if (!bool){
            $("#choix").css('height','16rem');
            $("#choix2").css('height','2.8rem');
            $(".cache2").css('display','none');
            $(".cache2t").css('display','none');
            $( "#choix" ).removeClass( "open1");
            $( "#choix2" ).addClass( "open2");
            setTimeout( () =>{
                $(".cache").css('display','block');
                $(".cachet").css('display','block');
            },200);
            bool = true;
            bool2 = false;
        }
    });

    $('.open2').click(function () {
        if (!bool2){
            $("#choix2").css('height','18rem');
            $( "#choix2" ).removeClass( "open2");
            $( "#choix" ).addClass( "open1");
            $("#choix").css('height','2.8rem');
            $(".cache").css('display','none');
            $(".cachet").css('display','none');
            setTimeout( () =>{
                $(".cache2").css('display','block');
                $(".cache2t").css('display','block');
            },200);
            bool = false;
            bool2 = true;
        }
    });
    //

    $('#classement').click(function () {
        $('.leaderboard').css('display','block');
        $('.under-container').css('display','none');
        $('#treasure').css('display','none');
        $('#intro').css('display','none');
    })

    $('#quit').click(function () {
        $('.leaderboard').css('display','none');
        $('.under-container').css('display','block');
        $('#treasure').css('display','block');
        $('#intro').css('display','block');
    })

    $('#ok').click(function () {
        $(".container2").css('display','block');
        $("#id").val($("#iden").val());
    });

    $("#spectate").click(function () {
        document.location.href='../view/map.php';
    });

});