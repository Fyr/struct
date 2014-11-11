            <div class="row">
                <div class="col-md-11 col-sm-10 col-xs-8 mutant-title">
                    <div class="col-md-9 col-sm-9">
                        <div class="page-title"><?=Hash::get($user, 'ChatUser.name')?></div>
                        <div class="user-spec"><?=Hash::get($user, 'Profile.skills')?></div>
                        <div class="user-menu page-menu">
                            <div class="btn-group">
                                <!--button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    В избранное <span class="halflings chevron-down"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Друзья</a></li>
                                    <li><a href="#">Одноклассники</a></li>
                                    <li><a href="#">Одногруппники</a></li>
                                    <li><a href="#">Сотрудники</a></li>
                                    <li><a href="#">Подруги</a></li>
                                </ul-->
                            </div>
                            <div class="dropdown">
                                <!--button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                    Отправить сообщение
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    <div class="dropdown-wrap">
                                        <div class="dropdown-close">
                                            <span class="glyphicon glyphicon-remove-sign"></span>
                                        </div>
                                        <div class="dropdown-body inner-content">
                                            <div class="comments-box-send">
                                                <img src="/img/temp/smallava1.jpg" alt="">
                                                <div class="comments-box-send-info">
                                                    Оставьте свой комментарий
                                                </div>
                                                <form>
                                                    <div class="comments-box-send-form">
                                                        <div class="comments-box-textarea">
                                                            <textarea rows="3"></textarea>
                                                        </div>
                                                        <div class="comments-box-submit">
                                                            <button class="btn btn-default"><span class="glyphicon glyphicon-send"></span></button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="comments-box-send-info bottom-info">
                                                    <div class="comments-box-bottom-buttons">
                                                        <a href="#" class="btn btn-default">
                                                            <span class="glyphicon glyphicon-paperclip"></span>
                                                        </a>
                                                        <a href="#" class="btn btn-default">
                                                            <span class="glyphicon glyphicon-facetime-video"></span>
                                                        </a>

                                                    </div>
                                                    Для отправки сообщения нажмите Enter
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div-->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="user-avatar taright">
<?
	$src = (Hash::get($user, 'Media.id')) ? $this->Media->imageUrl($user, '192x') : '/img/no-photo.jpg';
?>
                            <img src="<?=$src?>" alt="<?=Hash::get($user, 'ChatUser.username')?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row user-info">
                <div class="col-md-11 col-sm-10 col-xs-8">
                    <div class="col-md-4">
                        <div class="user-adress">
<?
	// $live_place = Hash::get($user, 'Profile.live_place');
	// list($town, $country) = explode(',', $live_place);
	$addr = Hash::get($user, 'Profile.live_place');
	if ($addr) {
?>
                            <div class="fs15"><?=$addr?></div>
<?
	}
?>
                            <div class="fs13 text-grey"><? // country?></div>
                            <div class="fs15 mt10"><?=Hash::get($user, 'Profile.birthday');?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="user-education">
                            <!--img src="/img/temp/t_logo.png" alt="" />
                            <div class="fs15"> МГТУ им. Н. Э. Баумана</div>
                            <div class="fs13">
                                Вычислительные машины,
                                комплексы, системы, сети
                            </div-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="vp10">
                            <div class="fs15 mt10"><!-- +7 909 307-26-25--></div>
                            <div class="fs15 mt10">
                                <!--a href="#"><?=Hash::get($user, 'ChatUser.username')?></a-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--div class="row">
                <div class="col-md-11 col-sm-10 col-xs-8">
                    <div class="col-md-12">
                        <div class="subheading">Достижения</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11 col-sm-10 col-xs-8 ">
                    <div class="col-md-4 mb10">
                        <a href="#" class="fs15">
                            Лауреат Нобелевской премии по физике 2014
                        </a>
                    </div>
                    <div class="col-md-4 mb10">
                        <a href="#" class="fs15">
                            Третье место в ежегодном марафоне в Бобруйске
                        </a>
                    </div>
                    <div class="col-md-4 mb10">
                        <a href="#" class="fs15">
                            Первое место в ежегодном конкурсе «Хак за 5 минут» 2014 в Москве
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mb40">
                <div class="col-md-11 col-sm-10 col-xs-8">
                    <div class="col-md-12">
                        <div class="morelink">
                            <a href="#">
                                <span class="morelink-text">Показать ещё</span>
                                <span class="glyphicon glyphicons repeat"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div-->
            <!--div class="row">
                <div class="col-md-11 col-sm-10 col-xs-8">
                    <div class="col-md-12">
                        <div class="subheading">Группы</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11 col-sm-10 col-xs-8">
                    <div class="col-md-4">
                        <div class="news-article group-type">
                            <a href="#">
                                <div class="news-article-title">
                                    Администратор
                                </div>
                                <div class="news-article-title subtitle clearfix">
                                    <div class="subtitle-image">
                                        <img src="/img/temp/t_logo1.png" alt="" />
                                    </div>
                                    <div class="subtitle-body">
                                        uWebDesign
                                        <div class="subtitle-body-info ">
                                            13 909 участников
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Практические советы начинающим программистам (Ruby, JSP, C++).
                            </div>
                        </div>
                        <div class="news-article group-type">
                            <a href="#">
                                <div class="news-article-title">
                                    Администратор
                                </div>
                                <div class="news-article-title subtitle clearfix">
                                    <div class="subtitle-image">
                                        <img src="/img/temp/t_logo1.png" alt="" />
                                    </div>
                                    <div class="subtitle-body">
                                        uWebDesign
                                        <div class="subtitle-body-info ">
                                            13 909 участников
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Практические советы начинающим программистам (Ruby, JSP, C++).
                            </div>
                        </div>
                        <div class="news-article group-type">
                            <a href="#">
                                <div class="news-article-title">
                                    Администратор
                                </div>
                                <div class="news-article-title subtitle clearfix">
                                    <div class="subtitle-image">
                                        <img src="/img/temp/t_logo1.png" alt="" />
                                    </div>
                                    <div class="subtitle-body">
                                        uWebDesign
                                        <div class="subtitle-body-info ">
                                            13 909 участников
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Практические советы начинающим программистам (Ruby, JSP, C++).
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="news-article group-type">
                            <a href="#">
                                <div class="news-article-title">
                                    Администратор
                                </div>
                                <div class="news-article-title subtitle clearfix">
                                    <div class="subtitle-image">
                                        <img src="/img/temp/t_logo1.png" alt="" />
                                    </div>
                                    <div class="subtitle-body">
                                        uWebDesign
                                        <div class="subtitle-body-info ">
                                            13 909 участников
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Практические советы начинающим программистам (Ruby, JSP, C++).
                            </div>
                        </div>
                        <div class="news-article group-type">
                            <a href="#">
                                <div class="news-article-title">
                                    Администратор
                                </div>
                                <div class="news-article-title subtitle clearfix">
                                    <div class="subtitle-image">
                                        <img src="/img/temp/t_logo1.png" alt="" />
                                    </div>
                                    <div class="subtitle-body">
                                        uWebDesign
                                        <div class="subtitle-body-info ">
                                            13 909 участников
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Практические советы начинающим программистам (Ruby, JSP, C++).
                            </div>
                        </div>
                        <div class="news-article group-type">
                            <a href="#">
                                <div class="news-article-title">
                                    Администратор
                                </div>
                                <div class="news-article-title subtitle clearfix">
                                    <div class="subtitle-image">
                                        <img src="/img/temp/t_logo1.png" alt="" />
                                    </div>
                                    <div class="subtitle-body">
                                        uWebDesign
                                        <div class="subtitle-body-info ">
                                            13 909 участников
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Практические советы начинающим программистам (Ruby, JSP, C++).
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="news-article group-type">
                            <a href="#">
                                <div class="news-article-title">
                                    Администратор
                                </div>
                                <div class="news-article-title subtitle clearfix">
                                    <div class="subtitle-image">
                                        <img src="/img/temp/t_logo1.png" alt="" />
                                    </div>
                                    <div class="subtitle-body">
                                        uWebDesign
                                        <div class="subtitle-body-info ">
                                            13 909 участников
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Практические советы начинающим программистам (Ruby, JSP, C++).
                            </div>
                        </div>
                        <div class="news-article group-type bb-pink">
                            <a href="#">
                                <div class="news-article-title">
                                    Администратор
                                </div>
                                <div class="news-article-title subtitle clearfix">
                                    <div class="subtitle-image">
                                        <img src="/img/temp/t_logo1.png" alt="" />
                                    </div>
                                    <div class="subtitle-body">
                                        uWebDesign
                                        <div class="subtitle-body-info ">
                                            13 909 участников
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Креативная среда
                            </div>
                        </div>
                        <div class="news-article group-type bb-aqua">
                            <span class="glyphicon glyphicon-user glyphicons user"></span>
                            <span class="glyphicon-extended glyphicon-coins glyphicons coins"></span>
                            <a href="#">
                                <div class="news-article-title">
                                    Администратор
                                </div>
                                <div class="news-article-title subtitle clearfix">
                                    <div class="subtitle-image">
                                        <img src="/img/temp/t_logo1.png" alt="" />
                                    </div>
                                    <div class="subtitle-body">
                                        uWebDesign
                                        <div class="subtitle-body-info ">
                                            13 909 участников
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Практические советы начинающим программистам (Ruby, JSP, C++).
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb40">
                <div class="col-md-11 col-sm-10 col-xs-8">
                    <div class="col-md-12">
                        <div class="morelink">
                            <a href="#">
                                <span class="morelink-text">Показать ещё</span>
                                <span class="glyphicon glyphicons repeat"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div-->
            <!--div class="row">
                <div class="col-md-11 col-sm-10 col-xs-8">
                    <div class="col-md-12">
                        <div class="subheading page-menu">
                            Статьи
                            <a href="#" class="btn btn-default edit-button">
                                Подписаться
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11 col-sm-10 col-xs-8">
                    <div class="col-md-4">
                        <div class="news-article">
                            <div class="dimention-link">
                                <a href="#">
                                    Политика
                                </a>
                            </div>
                            <a href="#">
                                <div class="news-article-title">
                                    Почему мировые лидеры хотят отказаться от борьбы с наркотиками
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Сегодня, 21:15
                            </div>
                        </div>
                        <div class="news-article bb-aqua">
                            <div class="dimention-link">
                                <a href="#">
                                    Политика
                                </a>
                            </div>
                            <a href="#">
                                <div class="news-article-title">
                                    Шпионские игры: 8 главных экранизаций романов Джонна Ле Карре
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Сегодня, 21:15
                                <div class="comments-num">
                                    <span class="glyphicons comments"></span> 8
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="news-article">
                            <div class="dimention-link">
                                <a href="#">
                                    Политика
                                </a>
                            </div>
                            <a href="#">
                                <div class="news-article-title">
                                    Новый iPhone 6 и часы Watch
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Сегодня, 21:15
                            </div>
                        </div>
                        <div class="news-article bb-green">
                            <div class="dimention-link">
                                <a href="#">
                                    Политика
                                </a>
                            </div>
                            <a href="#">
                                <div class="news-article-title">
                                    Как подростков ЮАР обучают межрасовой войне в националистических лагерях
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Сегодня, 21:15
                                <div class="comments-num">
                                    <span class="glyphicons comments"></span> 8
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="news-article">
                            <div class="dimention-link">
                                <a href="#">
                                    Политика
                                </a>
                            </div>
                            <a href="#">
                                <div class="news-article-img">
                                    <img src="/img/temp/t_img.jpg" alt="" />
                                </div>
                                <div class="news-article-title">
                                    Почему мировые лидеры хотят отказаться от борьбы с наркотиками
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Сегодня, 21:15
                            </div>
                        </div>
                        <div class="news-article bb-pink">
                            <div class="dimention-link">
                                <a href="#">
                                    Политика
                                </a>
                            </div>
                            <a href="#">
                                <div class="news-article-title">
                                    Стивен Хокинг заявил, что опыты с бозоном Хиггса уничтожат Вселенную
                                </div>
                            </a>
                            <div class="news-article-pubdate">
                                Сегодня, 21:15
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb40">
                <div class="col-md-11 col-sm-10 col-xs-8">
                    <div class="col-md-12">
                        <div class="morelink">
                            <a href="#">
                                <span class="morelink-text">Показать ещё</span>
                                <span class="glyphicon glyphicons repeat"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div-->
        </div>
        
        <div class="fixed-message">
        
            <!--div class="container">
                <div class="row">
                    <div class="col-md-11 col-sm-10 col-xs-8">
                        <div class="col-md-4 col-md-offset-8">
                            <div class="user-added">
                                <img src="/img/temp/smallava1.jpg" alt="" />
                                Варфаламей Константинопольский добавлен в ваши друзья.
                            </div>
                        </div>
                    </div>
                </div>
            </div-->