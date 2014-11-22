<?
	$profileID = Hash::get($profile, 'Profile.id');
	$profileID = ($profileID) ? $profileID : '0';
?>
var groupURL = {
	panel: '<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'panel'))?>',
	getGallery: '<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'getGallery'))?>.json',
	addGalleryVideo: '<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'addGalleryVideo'))?>.json',
	delGalleryVideo: '<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'delGalleryVideo'))?>.json',
	join: '<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'join'))?>.json',
}
var groupDef = {
	maxImages: <?=Configure::read('groupMaxImages')?>
}