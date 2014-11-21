<?
	$profileID = Hash::get($profile, 'Profile.id');
	$profileID = ($profileID) ? $profileID : '0';
?>
var profileURL = {
	panel: '<?=$this->Html->url(array('controller' => 'ProfileAjax', 'action' => 'panel'))?>',
	timelineEvents: '<?=$this->Html->url(array('controller' => 'ProfileAjax', 'action' => 'timelineEvents'))?>.json',
	updateEvent: '<?=$this->Html->url(array('controller' => 'ProfileAjax', 'action' => 'updateEvent'))?>.json',
	deleteEvent: '<?=$this->Html->url(array('controller' => 'ProfileAjax', 'action' => 'deleteEvent'))?>.json'
}