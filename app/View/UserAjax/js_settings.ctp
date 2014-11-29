var profileURL = {
	panel: '<?=$this->Html->url(array('controller' => 'UserAjax', 'action' => 'panel'))?>',
	timelineEvents: '<?=$this->Html->url(array('controller' => 'UserAjax', 'action' => 'timelineEvents'))?>.json',
	updateEvent: '<?=$this->Html->url(array('controller' => 'UserAjax', 'action' => 'updateEvent'))?>.json',
	deleteEvent: '<?=$this->Html->url(array('controller' => 'UserAjax', 'action' => 'deleteEvent'))?>.json'
}