$(document).ready(function()  {
    //permet le fonctionnement du bouton information grace à un attribut css clip-path
    $('#info-button').click( function() {
        $("#div-info").css('-moz-clip-path',  'circle(100% at 50% 50%)');
        $("#div-info").css('-webkit-clip-path',  'circle(100% at 50% 50%)');
        $("#div-info").css('clip-path',  'circle(100% at 50% 50%)');
    });
    $('#info1').click(function(){
        $("#div-info").css('-webkit-clip-path',  'circle(0% at 30px 93%)');
        $("#div-info").css('-moz-clip-path',  'circle(0% at 30px 93%)');
        $("#div-info").css('clip-path',  'circle(0% at 30px 93%)');
    });
});