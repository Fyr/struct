$(function() {

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
                }, 1100)
            }else{
                main_panel_li.removeClass('open');
                $(this).parent().addClass('open');
                panel_list.removeClass('dropdown-open');
                panel_list.eq($(this).parent().index()).addClass('dropdown-open');
            }
        }
        $(document).click( function(event){
            if ($(event.target).closest($('.main-panel')).length) return true;
                main_panel_li.removeClass('open');
                panel_list.removeClass('dropdown-open');
                setTimeout(function() {
                    main_panel_li.removeClass('open');
                    panel_list.removeClass('dropdown-open');
                }, 1000);
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


    // проверяем поддержку position: fixed;[start]
    var isFixedSupported = (function(){
        var isSupported = null;
        if (document.createElement) {
            var el = document.createElement("div");
            if (el && el.style) {
                el.style.position = "fixed";
                el.style.top = "10px";
                var root = document.body;
                if (root && root.appendChild && root.removeChild) {
                    root.appendChild(el);
                    isSupported = (el.offsetTop === 10);
                    root.removeChild(el);
                }
            }
        }
        return isSupported;
    })();
    window.onload = function(){
        if (!isFixedSupported){
            // добавляем контекст для "старичков"
            document.body.className += ' no-fixed-supported';
            // имитируем position: fixed;
            //var topbar = document.getElementById('topbar');
            var bottombar = document.getElementsByClassName('main-panel');
            var bottomBarHeight = bottombar.offsetHeight;
            var windowHeight = window.innerHeight;
            // обрабатываем события touch и scroll
            window.ontouchmove = function(e) {
                if (event.target !== topbar){
                    topbar.style = "";
                }
            }
            window.onscroll = function(){
                var scrollTop = window.scrollY;
                //topbar.style.top = scrollTop + 'px';
                bottombar.style.bottom = (scrollTop + windowHeight - bottomBarHeight) + 'px';
            };
        }
        // первичный scroll
                window.scrollBy(0, 1);
        }
	
});