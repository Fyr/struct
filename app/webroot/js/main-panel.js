$(function() {

    $('.logo-icon').css({backgroundSize: "cover"});

    // click panel icon jobs
    $('.main-panel-list a').on('click', function(){
        var panel_list = $('.main-panel-dropdown .dropdown-panel'),
            main_panel_li = $('.main-panel-list li'),
            number_click = $(this).parent().index();
        if($(this).parent().hasClass('open')){
            main_panel_li.removeClass('open');
            panel_list.removeClass('dropdown-open');
        }else{
            if($('.main-panel-list li.open').length > 0){
                main_panel_li.removeClass('open');
                $(this).parent().addClass('open');
                panel_list.removeClass('dropdown-open');
                setTimeout(function() {
                    var number_find = $('.main-panel-list li.open').index();
                    panel_list.eq(number_find).addClass('dropdown-open');
                }, 650)
            }else{
                main_panel_li.removeClass('open');
                $(this).parent().addClass('open');
                panel_list.removeClass('dropdown-open');
                panel_list.eq($(this).parent().index()).addClass('dropdown-open');
            }
        }
        $(document).on('touchstart click', function(event){
            if ($(event.target).closest($('.main-panel')).length) return true;
                main_panel_li.removeClass('open');
                panel_list.removeClass('dropdown-open');
                setTimeout(function() {
                    main_panel_li.removeClass('open');
                    panel_list.removeClass('dropdown-open');
                }, 650);
            event.stopPropagation();
        });
    });

    // event resize window service menu fixed
    var windows_height = $(window).height(),
        panel_menu_height = $('.main-panel-wrapper .user-image').height() +
                            $('.main-panel-wrapper .main-panel-list').height()+
                            ($('.main-panel-wrapper .service-menu').height()+90);
    if(panel_menu_height >= windows_height){
        $('.main-panel-wrapper .service-menu').removeClass('service-menu-fixed');
    }else{
        $('.main-panel-wrapper .service-menu').addClass('service-menu-fixed');
    }
    $( window ).resize(function() {
        var windows_height = $(window).height(),
            panel_menu_height = $('.main-panel-wrapper .user-image').height() +
                $('.main-panel-wrapper .main-panel-list').height()+
                ($('.main-panel-wrapper .service-menu').height()+90);
        if(panel_menu_height >= windows_height){
            $('.main-panel-wrapper .service-menu').removeClass('service-menu-fixed');
        }else{
            $('.main-panel-wrapper .service-menu').addClass('service-menu-fixed');
        }
    });


    window.scrollBy(0, 1);

//    hide menu list
	$('.main-panel-list li:nth-child(4),.main-panel-list li:nth-child(5),' +
    '.main-panel-list li:nth-child(6),.main-panel-list li:nth-child(7),' +
    '.main-panel-list li:nth-child(8),.main-panel-list li:nth-child(10)').hide();
});