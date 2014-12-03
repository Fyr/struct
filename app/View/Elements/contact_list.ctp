<style type="text/css">
.aside-block .close-block {
    color: #C5C5C5;
    position: absolute;
    right: -10px;
    text-align: center;
    top: -10px;
}
.aside-block .close-block:hover { color: #22B5AE;}
.main-panel .dropdown-chatPanel .messages-list li .aside-block {
    float: right;
    position: relative;
    width: 35px;
}
</style>
<ul>
<?
	if ($aUsers) {
		foreach($aUsers as $user) {
			$user_id = Hash::get($user, 'User.id');
			$room_id = Hash::get($user, 'ChatContact.room_id');
			$name = Hash::get($user, 'User.full_name');
			$message = Hash::get($user, 'ChatContact.msg');
			$time = Hash::get($user, 'ChatContact.modified');
			if (!$this->LocalDate->dateTime($time)) {
				$time = Hash::get($user, 'ChatContact.created');
			}
			$time = $this->LocalDate->time($time);
			
			$count = Hash::get($user, 'ChatContact.active_count');
			if ($count > 10) {
				$count = '10+';
			} else if (!$count) {
				$count = '';
			}
			if ($this->request->data('type') == 'internal') {
				$onclick = "Chat.openRoom(".$user['User']['id'].")";
			} else {
				$onclick = "window.location.href='".$this->Html->url(array('controller' => 'Chat', 'action' => 'index', $user_id), true)."'";
			}
			
			if ($this->request->data('q')) {
				$message = Hash::get($user, 'User.skills');
			}
?>
            <li class="messages-new clearfix" onclick="<?=$onclick?>">
                <figure class="messages-user rate-10"><img class="ava" src="<?=$this->Media->imageUrl($user['UserMedia'], 'thumb100x100')?>" alt="<?=$name?>" style="width: 50px; height: auto;"/></figure>
                <div class="text">
                    <div class="name"><?=$name?></div>
                    <div class="message clearfix">
                        <p><?=$message?></p>
                    </div>
                </div>
                <div class="aside-block">
                	<div class="close-block glyphicons circle_remove" onclick="var e = arguments[0] || window.event; if ($(e.target).hasClass('circle_remove')) { Chat.delContact(<?=$user_id?>, <?=$room_id?>) }"></div>
                    <div class="time"><?=$time?></div>
                    <div class="count-b">
                        <span class="count"><?=$count?></span>
                    </div>
                </div>
            </li>
<?
		}
	} else {
?>
		<li class="messages-new clearfix">
			<?=__('No user found')?>
		</li>
<?
	}
?>
</ul>