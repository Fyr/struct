<?
	$this->Html->css(array('jquery.fancybox'), array('inline' => false));
	$this->Html->script(array('vendor/jquery/jquery-ui-1.10.3.custom.min', 'vendor/jquery/jquery.fancybox.pack'), array('inline' => false));
?>
<div class="row">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-5 col-sm-5">
            <div class="page-title">
<?
	$id = Hash::get($group, 'Group.id');
	$title = Hash::get($group, 'Group.title');
	$src = $this->Media->imageUrl($group, '50x');
	if (!$src) {
		$src = '/img/group-create-pl-image.jpg';
	}
?>
                <img src="<?=$src?>" alt="<?=$title?>" style="width: 50px" /> <?=$title?>
            </div>
        </div>
        <div class="col-md-7 col-sm-7">
            <div class="group-menu page-menu taright">
                <a class="btn btn-default" href="#">
                    Попроситься в команду
                </a>
                <a class="btn btn-default" href="#">
                    Отправить сообщение
                </a>
<?
	if ($canEdit) {
?>
                <a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'edit', $id))?>" class="btn btn-default">
                    <span class="glyphicon glyphicon-wrench glyphicons wrench"></span>
                </a>
<?
	}
?>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.user-adress {
	padding: 10px 0 0 20px;
}
</style>
<div class="row mb40">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-9">
            <div class="fs15 group-desc">
                <?=Hash::get($group, 'Group.descr')?>
            </div>
        </div>
        <div class="col-md-3">
            
<?
	$aGroupAddress = Hash::get($group, 'GroupAddress');
	foreach($aGroupAddress as $i => $groupAddress) {
		$class = ($i > 0) ? 'can-hide' : '';
		$style = ($i > 0) ? 'style="display: none"' : '';
		$url = Hash::get($groupAddress, 'url');
		$email = Hash::get($groupAddress, 'email');
?>
			<div class="user-adress <?=$class?>" <?=$style?>>
                <div class="fs13"><?=Hash::get($groupAddress, 'address')?></div>
                <div class="fs13"><?=Hash::get($groupAddress, 'phone')?></div>
                <div class="fs13">
                    <a href="<?=$url?>" target="_blank"><?=$url?></a><br/>
                    <a href="mailto:<?=$email?>"><?=$email?></a>
                </div>
            </div>
<?
	}
?>
			<div class="user-adress" style="background-image: none">
                <div class="fs13 mt10">
                    <a href="javascript::void(0)" onclick="$('.user-adress.can-hide, .user-adress .can-hide').toggle(); return false;">
                    	<span class="can-hide"><?=__('All addresses')?></span>
                    	<span class="can-hide" style="display: none"><?=__('Collapse')?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?
	$aGroupGallery = Hash::get($group, 'GroupGallery');
	if ($aGroupGallery) {
?>
<div class="row mb40">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-12">
            <div class="galery-box clearfix">
<?
	foreach($aGroupGallery as $media) {
		$src = $this->Media->imageUrl(array('Media' => $media), 'thumb200x140');
		$orig = $this->Media->imageUrl(array('Media' => $media), 'noresize');
?>
                <div class="galery-box-item">
                	<a href="<?=$orig?>" class="fancybox" rel="photoalobum"><img src="<?=$src?>" alt=""  style="width: 100%" /></a>
                </div>
<?
	}
?>
                <!--div class="galery-box-item video-box">
                    <div class="dropdown">
                    	<button class="noStyles" type="button">
                            <img src="/img/temp/gal2.jpg" alt="" style="width: 100%"/>
                        </button>
                    </div>
                </div-->
                
            </div>
        </div>
    </div>
</div>
<?
	}
	$aGroupAchievement = Hash::get($group, 'GroupAchievement');
	if ($aGroupAchievement) {
?>
<div class="row">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-12">
            <div class="subheading"><?=__('Achievements')?></div>
        </div>
    </div>
</div>
<div class="row mb40 achieve-list">
    <div class="col-md-11 col-sm-10 col-xs-8">
<?
		foreach($aGroupAchievement as $i => $achieve) {
			$class = ($i > 2) ? 'can-hide' : '';
			$style = ($i > 2) ? 'style="display: none"' : '';
?>
        <div class="col-md-4 mb10 <?=$class?>" <?=$style?>>
            <a href="<?=Hash::get($achieve, 'url')?>" class="fs15" target="_blank">
                <?=Hash::get($achieve, 'title');?>
            </a>
        </div>
<?
		}
?>
		<div class="col-md-12">
            <div class="morelink">
                <a href="javascript::void(0)" onclick="$('.achieve-list.can-hide, .achieve-list .can-hide').toggle(); return false;">
                    <span class="morelink-text can-hide"><?=__('Show more')?></span>
                    <span class="morelink-text can-hide" style="display: none"><?=__('Collapse')?></span>
                    <span class="glyphicon glyphicons repeat"></span>
                </a>
            </div>
        </div>
    </div>
</div>
<?
	}
?>
<!--div class="row">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-12">
            <div class="subheading">Команда</div>
        </div>
    </div>
</div>
<div class="row mb40">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-12">
            <div class="units-list clearfix">
                <div class="units-list-item">
                    <a href="#">
                        <div class="units-list-item-image bb-aqua">
                            <img src="/img/temp/unit.png" alt="" />
                        </div>
                        <div class="units-list-item-name">
                            Рав Ягудин
                        </div>
                        <div class="units-list-item-spec">
                            Профессор
                        </div>
                    </a>
                </div>
                <div class="units-list-item">
                    <a href="#">
                        <div class="units-list-item-image bb-aqua">
                            <img src="/img/temp/unit.png" alt="" />
                        </div>
                        <div class="units-list-item-name">
                            Рав Ягудин
                        </div>
                        <div class="units-list-item-spec">
                            Профессор
                        </div>
                    </a>
                </div>
                <div class="units-list-item">
                    <a href="#">
                        <div class="units-list-item-image bb-aqua">
                            <img src="/img/temp/unit.png" alt="" />
                        </div>
                        <div class="units-list-item-name">
                            Рав Ягудин
                        </div>
                        <div class="units-list-item-spec">
                            Профессор
                        </div>
                    </a>
                </div>
                <div class="units-list-item">
                    <a href="#">
                        <div class="units-list-item-image bb-aqua">
                            <img src="/img/temp/unit.png" alt="" />
                        </div>
                        <div class="units-list-item-name">
                            Рав Ягудин
                        </div>
                        <div class="units-list-item-spec">
                            Профессор
                        </div>
                    </a>
                </div>
                <div class="units-list-item">
                    <a href="#">
                        <div class="units-list-item-image bb-aqua">
                            <img src="/img/temp/unit.png" alt="" />
                        </div>
                        <div class="units-list-item-name">
                            Рав Ягудин
                        </div>
                        <div class="units-list-item-spec">
                            Профессор
                        </div>
                    </a>
                </div>
                <div class="units-list-item">
                    <a href="#">
                        <div class="units-list-item-image bb-aqua">
                            <img src="/img/temp/unit.png" alt="" />
                        </div>
                        <div class="units-list-item-name">
                            Рав Ягудин
                        </div>
                        <div class="units-list-item-spec">
                            Профессор
                        </div>
                    </a>
                </div>
                <div class="units-list-item">
                    <a href="#">
                        <div class="units-list-item-image bb-aqua">
                            <img src="/img/temp/unit.png" alt="" />
                        </div>
                        <div class="units-list-item-name">
                            Рав Ягудин
                        </div>
                        <div class="units-list-item-spec">
                            Профессор
                        </div>
                    </a>
                </div>
                <div class="units-list-item">
                    <a href="#">
                        <div class="units-list-item-image bb-aqua">
                            <img src="/img/temp/unit.png" alt="" />
                        </div>
                        <div class="units-list-item-name">
                            Рав Ягудин
                        </div>
                        <div class="units-list-item-spec">
                            Профессор
                        </div>
                    </a>
                </div>
                <div class="units-list-item">
                    <a href="#">
                        <div class="units-list-item-image bb-aqua">
                            <img src="/img/temp/unit.png" alt="" />
                        </div>
                        <div class="units-list-item-name">
                            Рав Ягудин
                        </div>
                        <div class="units-list-item-spec">
                            Профессор
                        </div>
                    </a>
                </div>
                <div class="units-list-item">
                    <a href="#">
                        <div class="units-list-item-image bb-aqua">
                            <img src="/img/temp/unit.png" alt="" />
                        </div>
                        <div class="units-list-item-name">
                            Рав Ягудин
                        </div>
                        <div class="units-list-item-spec">
                            Профессор
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-12">
            <div class="subheading">
                Проекты
                <a href="#" class="btn btn-default">
                    Новый проект
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-4">
            <div class="news-article group-type progect-type">
                <a href="#">
                    <div class="news-article-title">

                    </div>
                    <div class="news-article-title subtitle clearfix">
                        <div class="subtitle-image">
                            <img src="/img/temp/t_logo2.png" alt="" />
                        </div>
                        <div class="subtitle-body">
                            KONSTRUKTOR
                            <div class="subtitle-body-info ">
                                11 участников
                            </div>
                        </div>
                    </div>
                </a>
                <div class="news-article-pubdate">
                    Креативная среда
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="news-article group-type progect-type">
                <a href="#">
                    <div class="news-article-title">

                    </div>
                    <div class="news-article-title subtitle clearfix">
                        <div class="subtitle-image">
                            <img src="/img/temp/t_logo3.png" alt="" />
                        </div>
                        <div class="subtitle-body">
                            Yandex
                            <div class="subtitle-body-info ">
                                4 участника
                            </div>
                        </div>
                    </div>
                </a>
                <div class="news-article-pubdate">
                    Помогать людям решать задачи и достигать своих целей в жизни
                </div>
            </div>


        </div>
        <div class="col-md-4">
            <div class="news-article group-type progect-type bb-aqua">
                <span class="glyphicon-extended glyphicon-coins glyphicons coins"></span>
                <span class="glyphicon glyphicon-user glyphicons user"></span>
                <span class="glyphicon glyphicon-lock glyphicons lock"></span>
                <a href="#">
                    <div class="news-article-title">

                    </div>
                    <div class="news-article-title subtitle clearfix">
                        <div class="subtitle-image">
                            <img src="/img/temp/t_logo4.png" alt="" />
                        </div>
                        <div class="subtitle-body">
                            Qimini™ Deuce, wireless charger & powerbank
                            <div class="subtitle-body-info ">
                                139 участников
                            </div>
                        </div>
                    </div>
                </a>
                <div class="news-article-pubdate">
                    Карманное беспроводное зарядное устройство, которое заряжает ваш мобильный телефон без проводов.
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
</div>
<div class="row">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-12">
            <div class="subheading page-menu">
                Статьи
                <a href="#" class="btn btn-default edit-button">
                    <span class="glyphicon-extended glyphicon-pen glyphicons pencil"></span>
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
                        <span class="glyphicon glyphicon-comment glyphicons comments"></span> 8
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
                        <span class="glyphicon glyphicon-comment glyphicons comments"></span> 8
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
<script type="text/javascript">
$(document).ready(function(){
	$('.fancybox').fancybox({
		padding: 5
	});
});
</script>