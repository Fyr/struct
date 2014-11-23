<div class="col-md-12 col-sm-12 col-xs-12 mutant-title">
    <div class="col-md-9 col-sm-9 col-xs-12">
        <div class="page-title"><?=Hash::get($user, 'ChatUser.name')?></div>
        <div class="user-spec"><?=Hash::get($user, 'Profile.skills')?></div>
        <!--div class="user-menu page-menu">
            <div class="btn-group add-to-favorites">
                <select class="formstyler" name="" id="">
                    <option value="0">В избранное</option>
                    <option value="1">Друзья</option>
                    <option value="2">Одноклассники</option>
                    <option value="3">Одногруппники</option>
                    <option value="4">Сотрудники</option>
                    <option value="5">Подруги</option>
                </select>
            </div>
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                    Отправить сообщение
                </button>
                <div class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <div class="dropdown-wrap">
                        <div class="dropdown-close">
                            <span class="glyphicons circle_remove"></span>
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
                                            <button class="btn btn-default"><span class="glyphicons send"></span></button>
                                        </div>
                                    </div>
                                </form>
                                <div class="comments-box-send-info bottom-info">
                                    <div class="comments-box-bottom-buttons">
                                        <a href="#" class="btn btn-default">
                                            <span class="glyphicons paperclip"></span>
                                        </a>
                                        <a href="#" class="btn btn-default">
                                            <span class="glyphicons facetime_video"></span>
                                        </a>

                                    </div>
                                    Для отправки сообщения нажмите Enter
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div-->
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="user-avatar taright">
<?
	$src = (Hash::get($user, 'Media.id')) ? $this->Media->imageUrl($user, 'thumb150x150') : '/img/no-photo.jpg';
?>
				<img style="width: 150px" src="<?=$src?>" alt="<?=Hash::get($user, 'ChatUser.username')?>" />

        </div>
    </div>
</div>
<div class="row user-info">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-4">
            <div class="user-adress">
                <div class="fs15"><?=Hash::get($user, 'Profile.live_place')?></div>
                <div class="fs13 text-grey"><?=Hash::get($user, 'Profile.live_country')?></div>
                <div class="fs15 mt10"><?=Hash::get($user, 'Profile.birthday')?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="user-education">
<?
	$university = Hash::get($user, 'Profile.university');
	$src = $this->Media->imageUrl(array('Media' => Hash::get($user, 'MediaUniversity')), 'thumb50x50');
	$src = ($src) ? $src : '/img/group-create-pl-image.jpg';
?>
                <img src="<?=$src?>" alt="<?=$university?>" style="width: 50px" />
                <div class="fs15"><?=$university?></div>
                <div class="fs13"><?=Hash::get($user, 'Profile.speciality')?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="vp10">
                <div class="fs15 mt10"><?=Hash::get($user, 'Profile.phone')?></div>
                <div class="fs15 mt10">
                    <a href="mailto:<?//Hash::get($user, 'ChatUser.username')?>"><?//Hash::get($user, 'ChatUser.username')?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?
	if ($aAchiev = Hash::get($user, 'ProfileAchievement')) {
		$aContainer = array('', '', '');
		$i = 0;
		foreach($aAchiev as $j => $achiev) {
			$aContainer[$i].= $this->element('profile_achiev', array('achiev' => $achiev, 'hide' => ($j >= 3)));
			$i++;
			if ($i >= 3) {
				$i = 0;
			}
		}
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12">
            <div class="subheading"><?=__('Achievements')?></div>
        </div>
    </div>
</div>
<div class="row profile-achievs">
    <div class="col-md-12 col-sm-12 col-xs-12">
<?
		foreach($aContainer as $container) {
?>
        <div class="col-md-4 col-sm-6 col-xs-12 mb10">
        	<?=$container?>
        </div>
<?
		}
?>
    </div>
</div>
<?
	}
?>
<div class="row mb40">
<?
	if (count($aAchiev) > 3) {
?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="morelink">
                <a href="javascript:void(0)" onclick="$('.profile-achievs .can-hide').toggle(); return false;">
                    <span class="morelink-text can-hide"><?=__('Show more')?></span>
                    <span class="morelink-text can-hide" style="display: none;"><?=__('Collapse')?></span>
                    <span class="glyphicon glyphicons repeat"></span>
                </a>
            </div>
        </div>
    </div>
<?
	}
?>
</div>
<?
	if ($aGroups) {
		
		$aContainer = array('', '', '');
		$i = 0;
		foreach($aGroups as $j => $group) {
			$aContainer[$i].= $this->element('profile_groups', array('group' => $group, 'hide' => ($j >= 3)));
			$i++;
			if ($i >= 3) {
				$i = 0;
			}
		}
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12">
            <div class="subheading">Группы</div>
        </div>
    </div>
</div>
<div class="row profile-groups">
    <div class="col-md-12 col-sm-12 col-xs-12">
<?
		foreach($aContainer as $container) {
?>
        <div class="col-md-4 col-sm-6 col-xs-12">
        	<?=$container?>
        </div>
<?
		}
?>
        </div>
    </div>
</div>
<div class="row mb40 profile-groups">
<?
		if (count($aGroups) > 3) {
?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12">
            <div class="morelink">
                <a href="javascript:void(0)" onclick="$('.profile-groups .can-hide').toggle(); return false;">
                    <span class="morelink-text can-hide"><?=__('Show more')?></span>
                    <span class="morelink-text can-hide" style="display: none;"><?=__('Collapse')?></span>
                    <span class="glyphicon glyphicons repeat"></span>
                </a>
            </div>
        </div>
    </div>
<?
		}
?>
</div>
<?
	}
?>

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