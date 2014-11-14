$(function() {

    $('.datetimepicker').datetimepicker({
        pickTime: false
    });

    /*
    $('.toggle-dotted-line').on('click', function(){
        $('.toggle-dotted-btn').fadeOut('fast');
        $(this).parent().parent().parent().find('.toggle-dotted-cont').stop(true, false).slideDown();
    });
	*/

    $('.time span').on('touchstart click', function(event){
        $('.add-event-time').removeClass('open-plus');
        $(this).parent().find('add-event-time').addClass('open-plus');
        $('.add-event-block').removeClass('open').css({'top':$(this).offset().top}).addClass('open');

        //$(window).on('touchstart click', function(event){
        //    if ($(event.target).closest($('.add-event-block, .time span')).length) return true;
        //        $('.add-event-block').removeClass('open');
        //    event.stopPropagation();
        //});
    });
    $('.add-event-block .close-block').on('touchstart click', function(){
        $(this).parent().removeClass('open');
    });

    $('.row-day-events .day-calendar').on('click', function(){
       $(this).parent().parent().find('.time-line-list').stop(true,false).slideToggle('slow');
    });

});