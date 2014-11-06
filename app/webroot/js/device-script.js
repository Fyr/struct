$(document).ready(function () {

    $(window).resize(function() {
        messagesHeight = $(window).height() - 82;
        $("#allMessages").height(messagesHeight);

        var dialogHeight = $(window).height() - $(".bottom").height();
        $(".dialog").height(dialogHeight);

        var ordersHeight = $(window).height() - 230;
        $("#allOrders").height(ordersHeight);

        $("#menuBarScroll").height($(window).height());
    });

    var messagesHeight = $(window).height() - 82;
    $("#allMessages").height(messagesHeight);

    var dialogHeight = $(window).height() - $(".bottom").height();
    $(".dialog").height(dialogHeight);

    var ordersHeight = $(window).height() - 230;
    $("#allOrders").height(ordersHeight);

    $("#menuBarScroll").height($(window).height());



    $(".dialog").scrollTop($(".innerDialog").height() - $(".dialog").height() + 97);


});