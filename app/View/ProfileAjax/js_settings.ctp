<?
	$profileID = Hash::get($profile, 'Profile.id');
	$profileID = ($profileID) ? $profileID : '0';
?>
var profileURL = {
	panel: '<?=$this->Html->url(array('controller' => 'ProfileAjax', 'action' => 'panel'))?>',
	removeAvatar: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'delete'))?>',
	timelineEvents: '<?=$this->Html->url(array('controller' => 'ProfileAjax', 'action' => 'timelineEvents'))?>.json',
	addEvent: '<?=$this->Html->url(array('controller' => 'ProfileAjax', 'action' => 'addEvent'))?>.json'
}