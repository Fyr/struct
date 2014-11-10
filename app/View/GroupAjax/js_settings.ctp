<?
	$profileID = Hash::get($profile, 'Profile.id');
	$profileID = ($profileID) ? $profileID : '0';
?>
var groupURL = {
	panel: '<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'panel'))?>',
	getGallery: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'Ajax', 'action' => 'getList', 'GroupGallery'))?>',
	delGalleryImage: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'Ajax', 'action' => 'delete', 'GroupGallery'))?>'
}