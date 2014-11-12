$(function () {
    $('.terms-of-use input[type="checkbox"]').each(function () {
        //$(this).removeAttr('checked');
        $(this).change(function () {
            if ($(this).is(':checked')) {
                $(this).parent().removeClass('checkedOut');
                $(this).parent().addClass('checkedIn');
            } else {
                $(this).parent().addClass('checkedOut');
                $(this).parent().removeClass('checkedIn');
            }
        });
        $(this).change();
    });
});