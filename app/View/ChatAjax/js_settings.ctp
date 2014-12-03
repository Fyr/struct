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
}
chatUpdateTime = <?=Configure::read('chatUpdateTime')?>;
chatDef = {
	outcomingMsg: <?=ChatEvent::OUTCOMING_MSG?>,
	incomingMsg: <?=ChatEvent::INCOMING_MSG?>,
	fileUploaded: <?=ChatEvent::FILE_UPLOADED?>,
	fileDownloadAvail: <?=ChatEvent::FILE_DOWNLOAD_AVAIL?>
}
chatLocale = {
	Loading: '<?=__('Loading...')?>',
	fileReceived: '<?=__('You have received a file')?>',
	fileUploaded: '<?=__('File has been uploaded')?>'
}
var mediaURL = {
	upload: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'upload'))?>',
	move: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'move'))?>.json',
	delete: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'delete'))?>.json',
};
