<ul>
<?
	if ($aUsers) {
		foreach($aUsers as $user) {
			$name = Hash::get($user, 'User.full_name');
			$message = Hash::get($user, 'ChatMessage.message');
			$time = Hash::get($user, 'ChatEvent.created');
			if ($time) {
				$time = date('H:i', strtotime($time));
			}
			
			$count = Hash::get($user, 'ChatEvent.count');
			if ($count > 10) {
				$count = '10+';
			}
			if ($this->request->data('type') == 'internal') {
				$onclick = "Chat.openRoom(".$user['User']['id'].")";
			} else {
				$onclick = "window.location.href='".$this->Html->url(array('controller' => 'Chat', 'action' => 'index', $user['User']['id']), true)."'";
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