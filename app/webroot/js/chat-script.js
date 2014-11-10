$(document).ready(function () {

    $(window).resize(function() {

        var dialogHeight = $(window).height() - $(".bottom").height();
        $(".dialog").height(dialogHeight);

    });

    var dialogHeight = $(window).height() - $(".bottom").height();
    $(".dialog").height(dialogHeight);

    //$(".dialog").scrollTop($(".innerDialog").height() - $(".dialog").height() + 97);


});