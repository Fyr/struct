$(function () {
    $('.group-hide-view input[type="checkbox"]').each(function(){
        $(this).change(function(){
            if($(this).is(':checked')){
                $(this).parent().removeClass('checkedOut');
                $(this).parent().addClass('checkedIn');
            }else{
                $(this).parent().addClass('checkedOut');
                $(this).parent().removeClass('checkedIn');
            }
        });
        $(this).change();
    });
    $('.group-hide-view input[type="checkbox"]').change();

    $('.gallery-add-list .add-video').on('click', function(){
       $(this).parent().parent().parent().parent().find('.drop-add-video').addClass('open');
    });
    $('.drop-add-video .close-block').on('click', function(){
       $(this).parent().removeClass('open');
    });
});