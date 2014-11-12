<?
	$profileID = Hash::get($profile, 'Profile.id');
	$profileID = ($profileID) ? $profileID : '0';
?>
var groupURL = {
	panel: '<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'panel'))?>',
	getGallery: '<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'getGallery'))?>.json',
	delGalleryImage: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'Ajax', 'action' => 'delete', 'GroupGallery'))?>',
	addGalleryVideo: '<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'addGalleryVideo'))?>.json',
	delGalleryVideo: '<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'delGalleryVideo'))?>.json'
}
var groupDef = {
	maxImages: <?=Configure::read('groupMaxImages')?>
}