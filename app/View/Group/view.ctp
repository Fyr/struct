<?
	$this->Html->css(array('jquery.fancybox'), array('inline' => false));
	$this->Html->script(array('vendor/jquery/jquery-ui-1.10.3.custom.min', 'vendor/jquery/jquery.fancybox.pack'), array('inline' => false));
	
	$id = Hash::get($group, 'Group.id');
	$title = Hash::get($group, 'Group.title');
	$src = $this->Media->imageUrl($group, '50x');
	if (!$src) {
		$src = '/img/group-create-pl-image.jpg';
	}
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-10 col-sm-10 col-xs-10">
            <div class="page-title">
                <img style="width: 50px" alt="<?=$title?>" src="<?=$src?>">
                <?=$title?>
            </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2">
            <div class="group-menu page-menu taright">
                <!--a class="btn btn-default" href="#">
                    Попроситься в команду
                </a>
                <a class="btn btn-default" href="#">
                    Отправить сообщение
                </a-->
<?
	if ($canEdit) {
?>
                <a class="btn btn-default" href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'edit', $id))?>">
                    <span class="glyphicon glyphicon-wrench glyphicons wrench"></span>
                </a>
<?
	}
?>
            </div>
        </div>
    </div>
</div>

<div class="row mb40">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="fs15 group-desc">
                <?=Hash::get($group, 'Group.descr')?>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">            
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
                    	<span class="can-hide" style="display: inline;"><?=__('All addresses')?></span>
                    	<span style="display: none;" class="can-hide"><?=__('Collapse')?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?
	$aGroupGallery = Hash::get($group, 'GroupGallery');
	$aGroupGallery = ($aGroupGallery) ? $aGroupGallery : array();
	
	$aGroupVideo = Hash::get($group, 'GroupVideo');
	$aGroupVideo = ($aGroupVideo) ? $aGroupVideo : array();
	if ($aGroupGallery || $aGroupVideo) {
?>
<div class="col-md-12 col-sm-12 col-xs-12 galery-box">
<?
		foreach($aGroupVideo as $video) {
?>
	<div class="galery-box-item">
		<a rel="photoalobum" class="" href="<?=$video['url']?>" target="_blank"><img alt="" src="http://img.youtube.com/vi/<?=$video['video_id']?>/mqdefault.jpg"></a>
	</div>
<?
		}
		foreach($aGroupGallery as $media) {
			$src = $this->Media->imageUrl(array('Media' => $media), 'thumb200x113');
			$orig = $this->Media->imageUrl(array('Media' => $media), 'noresize');
?>
    <div class="galery-box-item">
		<a href="<?=$orig?>" class="fancybox" rel="photoalobum"><img src="<?=$src?>" alt="" /></a>
	</div>
<?
		}
?>
</div>
<?
	}
	$aGroupAchievement = Hash::get($group, 'GroupAchievement');
	if ($aGroupAchievement && Hash::get($aGroupAchievement, '0.url')) {
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"><div class="subheading"><?=__('Achievements')?></div></div>
</div>

<div class="row achieve-list">
	<div class="col-md-12 col-sm-12 col-xs-12">
<?
		foreach($aGroupAchievement as $i => $achieve) {
			$class = ($i > 2) ? 'can-hide' : '';
			$style = ($i > 2) ? 'style="display: none"' : '';
			$url = Hash::get($achieve, 'url');
?>
        <div class="col-md-4 mb10 <?=$class?>" <?=$style?>>
            <a href="<?=$url?>" class="fs15" target="_blank">
                <?=Hash::get($achieve, 'title');?>
            </a>
        </div>
<?
		}
?>
	</div>
</div>

<div class="row mb40 achieve-list">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="col-md-12">
			<div class="morelink">
				<a href="javascript::void(0)" onclick="$('.achieve-list .can-hide').toggle(); return false;">
					<span class="morelink-text can-hide"><?=__('Show more')?></span>
                    <span class="morelink-text can-hide" style="display: none"><?=__('Collapse')?></span>
                    <span class="glyphicon glyphicon-repeat glyphicons repeat"></span>
				</a>
			</div>
        </div>
	</div>
</div>
<?
	}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('.fancybox').fancybox({
		padding: 5
	});
});
</script>