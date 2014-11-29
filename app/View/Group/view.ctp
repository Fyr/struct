<?
	$this->Html->css(array('jquery.fancybox'), array('inline' => false));
	$this->Html->script(array('vendor/jquery/jquery-ui-1.10.3.custom.min', 'vendor/jquery/jquery.fancybox.pack'), array('inline' => false));
	
	$groupID = Hash::get($group, 'Group.id');
	$title = Hash::get($group, 'Group.title');
	$src = $this->Media->imageUrl(Hash::get($group, 'GroupMedia'), 'thumb50x50');
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-5 col-sm-12 col-xs-12">
            <div class="page-title">
                <div class="page-title-group-image">
                    <img alt="<?=$title?>" src="<?=$src?>" />
                </div> <?=$title?>
            </div>
        </div>
        <div class="col-md-7 col-sm-12 col-xs-12">
            <div class="group-menu page-menu taright">
<?
	if (!$joined && !$isGroupAdmin) {
?>
                <a id="joinGroup" href="javascript:void(0)" class="btn btn-default" onclick="Group.join(<?=$groupID?>, <?=$currUserID?>)">
                    <?=__('Join this group')?>
                    <span class="joined hide"><?=__('Your invitation has been sent to group administrator')?></span>
                </a>
<?
	}
?>
                <!--div class="dropdown">
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
                <!--a class="btn btn-default" href="#">
                    <span class="glyphicons parents"></span>
                </a-->
                <a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'members', $groupID))?>" class="btn btn-default">
                    <?=__('Members')?>
                </a>
<?
	if ($isGroupAdmin) {
?>
                <a class="btn btn-default" href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'edit', $groupID))?>">
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
	<div class="galery-box-item video-box">
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
<?
	if (count($aGroupAchievement) > 3) {
?>
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
<?
	}
?>
</div>
<?
	}
?>
<div class="row">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-12">
            <div class="subheading"><?=__('Team')?></div>
        </div>
    </div>
</div>
<div class="row mb40">
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-12">
            <div class="units-list clearfix">
<?
	foreach($aMembers as $member) {
		$user = $aUsers[$member['GroupMember']['user_id']];
		$role = $member['GroupMember']['role'];
?>
                <div class="units-list-item">
                    <a href="<?=$this->html->url(array('controller' => 'User', 'action' => 'view', $user['User']['id']))?>">
                        <div class="units-list-item-image bb-aqua">
                            <img src="<?=$this->Media->imageUrl($user['UserMedia'], 'thumb100x100')?>" alt="<?=$user['User']['full_name']?>" style="width: 100px;" />
                        </div>
                        <div class="units-list-item-name">
                            <?=$user['User']['full_name']?>
                        </div>
                        <div class="units-list-item-spec">
                            <?=$role?>
                        </div>
                    </a>
                </div>
<?
	}
?>
            </div>
        </div>
    </div>
</div>
<?
	// if (in_array($currUserID, array_keys($aMembers)) || $groupID == Configure::read('Konstructor.groupID')) {
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12">
            <div class="subheading">
                <?=__('Projects')?>
<?
		if ($isGroupAdmin) {
?>
                <a class="btn btn-default" href="<?=$this->Html->url(array('controller' => 'Project', 'action' => 'edit', 'Project.group_id' => $groupID))?>">
                    <?=__('New project')?>
                </a>
<?
		}
?>
            </div>
        </div>
    </div>
</div>

<?
		$aContainer = array('', '', '');
		$i = 0;
		foreach($aProjects as $j => $project) {
			$aContainer[$i].= $this->element('group_projects', array('project' => $project, 'hide' => ($j >= 3)));
			$i++;
			if ($i >= 3) {
				$i = 0;
			}
		}
?>
<div class="row group-projects">
    <div class="col-md-11 col-sm-10 col-xs-8">
<?
		if ($aProjects) {
			foreach($aContainer as $container) {
?>
        <div class="col-md-4">
        	<?=$container?>
        </div>
<?
			}
		} else {
?>
		<div class="col-md-4">
        	<?=__('No projects yet')?>
        </div>
<?
		}
?>
    </div>
</div>
<div class="row mb40 group-projects">
<?
		if (count($aProjects) > 3) {
?>
    <div class="col-md-11 col-sm-10 col-xs-8">
        <div class="col-md-12">
            <div class="morelink">
                <a href="javascript:void(0)" onclick="$('.group-projects .can-hide').toggle(); return false;">
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
	// }
?>
<script type="text/javascript">
$(document).ready(function(){
	$('.fancybox').fancybox({
		padding: 5
	});
});
</script>