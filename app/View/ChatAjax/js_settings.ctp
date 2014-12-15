<?
	App::uses('ChatEvent', 'Model');
?>
var chatURL = {
	// panel: '<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'panel'))?>.json',
	contactList: '<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'contactList'))?>.json',
	sendMsg: '<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'sendMsg'))?>.json',
	sendFile: '<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'sendFile'))?>.json',
	updateState: '<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'updateState'))?>.json',
	openRoom: '<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'openRoom'))?>.json',
	markRead: '<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'markRead'))?>.json',
	delContact: '<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'delContact'))?>.json',
	addMember: '<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'addMember'))?>.json',
	loadMore: '<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'loadMore'))?>.json'
}
chatUpdateTime = <?=Configure::read('chat.updateTime')?>;
chatDef = {
	outcomingMsg: <?=ChatEvent::OUTCOMING_MSG?>,
	incomingMsg: <?=ChatEvent::INCOMING_MSG?>,
	roomOpened: <?=ChatEvent::ROOM_OPENED?>,
	fileUploaded: <?=ChatEvent::FILE_UPLOADED?>,
	fileDownloadAvail: <?=ChatEvent::FILE_DOWNLOAD_AVAIL?>,
	invitedUser: <?=ChatEvent::INVITED_USER?>,
	wasInvited: <?=ChatEvent::WAS_INVITED?>,
	joinedRoom: <?=ChatEvent::JOINED_ROOM?>
}
chatLocale = {
	Loading: '<?=__('Loading...')?>'
}
var mediaURL = {
	upload: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'upload'))?>',
	move: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'move'))?>.json',
	delete: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'delete'))?>.json',
};
