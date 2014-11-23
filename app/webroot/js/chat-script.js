$(document).ready(function () {

    $(window).resize(function() {

        //var dialogHeight = $(window).height() - $(".bottom").height();
        //$(".dialog").height(dialogHeight);

        $('.dialog').css({'padding-bottom':$('.bottom').height()});

    });
    
    $('.dialog').css({'padding-bottom':$('.bottom').height()});

    //var dialogHeight = $(window).height() - $(".bottom").height();
    //$(".dialog").height(dialogHeight);

    //$(".dialog").scrollTop($(".innerDialog").height() - $(".dialog").height() + 97);




});