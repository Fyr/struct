<?
	$groupID = Hash::get($group, 'Group.id');
	$title = Hash::get($group, 'Group.title');
	$src = $this->Media->imageUrl(Hash::get($group, 'GroupMedia'), 'thumb50x50');
?>
<div class="row header-group-create clearfix">
    <div class="group-page-title col-md-6 col-sm-6 col-xs-12">
        <div class="page-title-group-image">
            <img alt="<?=$title?>" src="<?=$src?>" style="width: 50px">
        </div> <?=$title?>
    </div>
    <div class="title-button page-menu col-md-6 col-sm-6 col-xs-12">
        <a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'view', $groupID))?>" class="btn btn-default"><span class="glyphicons parents"></span></a>
<?
	if ($isGroupAdmin) {
?>
        <a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'edit', $groupID))?>" class="btn btn-default"><span class="glyphicons wrench"></span></a>
<?
	}
?>
    </div>
</div>

<?
	if ($isGroupAdmin) {
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 group-users-block">
<?
		foreach($aMembers as $member) {
			if (!$member['GroupMember']['approved']) {
				$user = $aUsers[$member['GroupMember']['user_id']];
				$userID = Hash::get($user, 'User.id');
				$urlView = $this->Html->url(array('controller' => 'User', 'action' => 'view', $user['User']['id']));
				$urlJoinApprove = $this->Html->url(array('controller' => 'Group', 'action' => 'memberApprove', $groupID, $userID));
				$urlRemove = $this->Html->url(array('controller' => 'Group', 'action' => 'memberRemove', $groupID, $userID));
?>
        <div class="group-users-block-w col-md-6 col-sm-6 col-xs-12">
            <div class="panel-users-block clearfix">
                <a href="<?=$urlView?>">
                    <div class="l-users-block">
                        <figure class="rate-10">
                            <img src="<?=$this->Media->imageUrl($user['UserMedia'], 'thumb50x50')?>" alt="<?=$user['User']['full_name']?>" style="width: 50px"/>
                        </figure>
                        <div class="text">
                            <div class="name"><?=$user['User']['full_name']?></div>
                            <div class="skills"><?=Hash::get($user, 'User.skills')?></div>
                        </div>
                    </div>
                </a>
                <div class="r-users-block">
                	<a href="javascript:void(0)" onclick="showAddUser(<?=$member['GroupMember']['id']?>, <?=$userID?>)"><div class="ok"><span class="glyphicons ok_2"></span></div></a>
                    
                    <div class="remove"><span class="glyphicons bin"></span></div>
                </div>
                <div class="remove-block-drop">
                    <div class="remove-text">
                        <?=__('Are you sure to delete this user')?> <a href="<?=$urlView?>" target="_blank"><?=$user['User']['full_name']?></a> ?
                        <div class="remove-button">
                            <a href="javascript:void(0)" class="ok_removed" onclick="window.location.href='<?=$urlRemove?>'; return true;">да</a>
                            <a href="javascript:void(0)" class="not_removed">нет</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?
			}
		}
?>
        
    </div>
</div>

<?
	}
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="group-list-ur clearfix">
<?
	/*
?>
            <li class="add-new-user">
                <a href="#">
                    <figure></figure>
                    <span class="profession">Добавить участников</span>
                </a>
            </li>
<?
	*/
	foreach($aMembers as $member) {
		if ($member['GroupMember']['approved']) {
			$user = $aUsers[$member['GroupMember']['user_id']];
			$userID = Hash::get($user, 'User.id');
			$profileID = Hash::get($user, 'User.id');
			$urlView = ($profileID) ? $this->Html->url(array('controller' => 'User', 'action' => 'view', $user['User']['id'])) : 'javascript:void(0)';
			$urlRemove = $this->Html->url(array('controller' => 'Group', 'action' => 'memberRemove', $groupID, $userID));
?>
            <li>
<?
			if ($isGroupAdmin) {
?>
            	<a href="<?=$urlRemove?>" onclick="return confirm('<?=__('Are you sure to delete this user')?>?');">
                	<div class="remove-media"><span class="glyphicons circle_remove"></span></div>
                </a>
<?
			}
?>
                <a href="<?=$urlView?>">
                    <figure class="rate-10">
                        <img src="<?=$this->Media->imageUrl($user['UserMedia'], 'thumb100x100')?>" alt="<?=$user['User']['full_name']?>" />
                    </figure>
                    <div class="name"><?=$user['User']['full_name']?></div>
                    <span class="profession"><?=$member['GroupMember']['role']?></span>
                </a>
            </li>
<?
		}
	}
?>            
        </ul>
    </div>
</div>

<script type="text/javascript">
var aUsers = null;

function showAddUser(memberID, userID) {
	var user = aUsers[userID];
	user.GroupMember = {id: memberID};
	$('.drop-add-list-user form').remove();
	$('.drop-add-list-user').append(tmpl('group-member', user).replace(/~userID/g, user.User.id));
	$('.drop-add-list-user').show();
}

$(document).ready(function(){
	aUsers = <?=json_encode($aUsers)?>;
    $('.drop-add-list-user .close-block').on('click', function(){
        $('.drop-add-list-user').hide();
    });
});
</script>

<div class="drop-add-list-user" style="display: none; height: 240px">
    <div class="close-block glyphicons circle_remove"></div>
</div>

<script type="text/x-tmpl" id="group-member">
<?=$this->Form->create('GroupMember')?>

<!--label for="add-new-user-list-4">Введите адрес эл. почты пользователя или имя</label>
        <input type="text" id="add-new-user-list-4"-->
        
        <!--label for="add-new-user-list-5">Роль в группе</label>
        <input type="text" id="add-new-user-list-5"-->
        <?=$this->Form->hidden('id', array('value' => '{%=o.GroupMember.id%}'))?>
        <?=$this->Form->input('role')?>
        <ul class="user-box-list">
            <li class="user-add-cell">
                <figure class="rate-10">
<?
	$urlView = $this->Html->url(array('controller' => 'User', 'action' => 'view', '~userID'));
?>
                    <a href="<?=$urlView?>"><img alt="{%=o.User.full_name%}" src="{%=o.UserMedia.url_img%}" style="width: 50px"></a>
                </figure>
                <div class="name">
                    <a href="<?=$urlView?>" class="name-link">{%=o.User.full_name%}</a>
                    <div class="profession">{%=(o.User) ? o.User.skills : ''%}</div>
                </div>
            </li>
        </ul>
        <div class="page-menu clearfix">
            <button class="btn btn-default"><?=__('Add member')?></button>
        </div>
<?=$this->Form->end()?>
</script>