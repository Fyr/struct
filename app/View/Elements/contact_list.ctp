<ul>
<?
	foreach($aUsers as $user) {
		$name = Hash::get($user, 'ChatUser.name');
		
		$time = Hash::get($user, 'ChatEvent.created');
		if ($time) {
			$time = date('H:i', strtotime($time));
		}
		
		$count = Hash::get($user, 'ChatEvent.count');
		if ($count > 10) {
			$count = '10+';
		}
		if ($this->request->data('type') == 'external') {
			$onclick = "window.location.href='".$this->Html->url(array('controller' => 'Chat', 'action' => 'index', $user['ChatUser']['id']), true)."'";
		} else {
			$onclick = "Chat.openRoom(".$user['ChatUser']['id'].")";
		}
?>
            <li class="messages-new clearfix" onclick="<?=$onclick?>">
                <figure class="messages-user rate-10"><img class="ava" src="<?=$user['Avatar']['url']?>" alt="<?=$name?>" /></figure>
                <div class="text">
                    <div class="name"><?=$name?></div>
                    <div class="message clearfix">
                        <p><?=Hash::get($user, 'ChatMessage.message')?></p>
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
?>
</ul>