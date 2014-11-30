<?
	$user_id = Hash::get($user, 'User.id');
?>
<div class="col-md-12 col-sm-12 col-xs-12 mutant-title">
    <div class="col-md-9 col-sm-9 col-xs-12">
        <div class="page-title"><?=Hash::get($user, 'User.full_name')?></div>
        <div class="user-spec clearfix">
            <div class="spec"><?=Hash::get($user, 'User.skills')?></div>
<?
	if ($video = Hash::get($user, 'User.video_url')) {
?>
        	<div class="link-video">
                <a href="<?=$video?>" target="_blank"><span class="glyphicons play_button"></span><span class="t"><?=__('Video with me')?></span></a>
            </div>
<?
	}
?>
        </div>
        <div class="user-menu page-menu">
<?
	if ($currUserID != $user_id) {
?>
        	<a class="btn btn-default" href="<?=$this->Html->url(array('controller' => 'Chat', 'action' => 'index', $user_id))?>"><?=__('Send message')?></a>
<?
	}
?>

            <!--div class="btn-group add-to-favorites">
                <div style="display: inline-block; position: relative; z-index:100" class="jq-selectbox jqselect formstyler"><select id="" name="" class="formstyler" style="margin: 0px; padding: 0px; position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; opacity: 0;">
                    <option value="0">В избранное</option>
                    <option value="1">Друзья</option>
                    <option value="2">Одноклассники</option>
                    <option value="3">Одногруппники</option>
                    <option value="4">Сотрудники</option>
                    <option value="5">Подруги</option>
                </select><div style="position: relative" class="jq-selectbox__select"><div class="jq-selectbox__select-text">В избранное</div><div class="jq-selectbox__trigger"><div class="jq-selectbox__trigger-arrow"></div></div></div><div style="position: absolute; display: none;" class="jq-selectbox__dropdown"><ul style="position: relative; list-style: none; overflow: auto; overflow-x: hidden"><li class="selected sel" style="display: block; white-space: nowrap;">В избранное</li><li class="" style="display: block; white-space: nowrap;">Друзья</li><li class="" style="display: block; white-space: nowrap;">Одноклассники</li><li class="" style="display: block; white-space: nowrap;">Одногруппники</li><li class="" style="display: block; white-space: nowrap;">Сотрудники</li><li class="" style="display: block; white-space: nowrap;">Подруги</li></ul></div></div>
            </div>
            <div class="dropdown">
                <button data-toggle="dropdown" id="dropdownMenu1" type="button" class="btn btn-default dropdown-toggle">
                    Отправить сообщение
                </button>
                <div aria-labelledby="dropdownMenu1" role="menu" class="dropdown-menu">
                    <div class="dropdown-wrap">
                        <div class="dropdown-close">
                            <span class="glyphicons circle_remove"></span>
                        </div>
                        <div class="dropdown-body inner-content">
                            <div class="comments-box-send">
                                <img alt="" src="img/temp/smallava1.jpg">
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
                                        <a class="btn btn-default" href="#">
                                            <span class="glyphicons paperclip"></span>
                                        </a>
                                        <a class="btn btn-default" href="#">
                                            <span class="glyphicons facetime_video"></span>
                                        </a>

                                    </div>
                                    Для отправки сообщения нажмите Enter
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div-->
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="user-avatar taright">
			<img style="width: 150px" src="<?=$this->Media->imageUrl($user['UserMedia'], 'thumb200x200')?>" alt="<?=Hash::get($user, 'User.username')?>" />

        </div>
    </div>
</div>
<div class="row user-info">
    <div class="col-md-12 col-sm-12 col-xs-12 user-info-block">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="user-adress">
                <div class="fs15"><?=Hash::get($user, 'User.live_place')?></div>
<?
	$country = Hash::get($user, 'User.live_country');
?>
                <div class="fs13 text-grey"><?=(isset($aCountryOptions[$country])) ?$aCountryOptions[$country] : ''?></div>
                <div class="fs15 mt10"><?=$this->LocalDate->date(Hash::get($user, 'User.birthday'))?></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 user-info-block">
            <div class="user-education">
<?
	$university = Hash::get($user, 'User.university');
	$src = $this->Media->imageUrl(Hash::get($user, 'UniversityMedia'), 'thumb50x50');
	if ($university) {
		// echo $this->Html->image($src, array('alt' => $university, 'style' => 'width: 50px'));
?>
                <img src="<?=$src?>" alt="<?=$university?>" style="width: 50px" />
<?
	}
?>
                <div class="fs15"><?=$university?></div>
                <div class="fs13"><?=Hash::get($user, 'User.speciality')?></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 user-info-block">
            <div class="vp10">
                <div class="fs15 mt10"><?=Hash::get($user, 'User.phone')?></div>
                <div class="fs15 mt10">
                    <a href="mailto:<?//Hash::get($user, 'User.username')?>"><?//Hash::get($user, 'User.username')?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?
	if ($aAchiev = Hash::get($user, 'UserAchievement')) {
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
		$j = 0;
		foreach($aGroups as $group) {
			$aContainer[$i].= $this->element('profile_groups', array('group' => $group, 'hide' => ($j >= 3)));
			$j++;
			$i++;
			if ($i >= 3) {
				$i = 0;
			}
		}
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12">
            <div class="subheading"><?__('Groups')?></div>
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
    <div class="col-md-12 col-sm-12 col-xs-12">
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
    <div class="col-md-12 col-sm-12 col-xs-12">
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
    <div class="col-md-12 col-sm-12 col-xs-12">
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