<?
	$isKonstructorActive = ($this->request->controller == 'Group' && Hash::get($this->request->pass, '0') == Configure::read('Konstructor.groupID')) ? ' active' : '';
	
	$isChatActive = ($this->request->controller == 'Chat') ? ' class="active"' : '';
	$isGroupActive = ($this->request->controller == 'Group' && !$isKonstructorActive) ? ' class="active"' : '';
	$isDeviceActive = ($this->request->controller == 'Device') ? ' class="active"' : '';
	$isUserActive = ($this->request->controller == 'User' && $this->request->action == 'edit') ? ' class="active"' : '';
	
?>
<div class="main-panel-list">
    <ul>
        <li><a href="javascript:void(0)"><span class="glyphicons search searchPanel"></span></a></li>
        <li<?=$isChatActive?>><a href="javascript:void(0)"><span class="glyphicons chat chatPanel"></span><div id="chatTotalUnread" class="count"></div></a></li>
        <li<?=$isGroupActive?>><a href="javascript:void(0)"><span class="glyphicons group groupPanel"></span></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons notes notesPanel"></span></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons briefcase briefcasePanel"></span></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons credit_card credit_cardPanel"></span><div class="count"></div></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons cloud cloudPanel"></span></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons file filePanel"></span></a></li>
        <li<?=$isDeviceActive?>><a href="javascript:void(0)"><span class="glyphicons ipad ipadPanel"></span></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons calendar calendarPanel"></span></a></li>
    </ul>
</div>
<div class="service-menu">
    <ul>
        <li<?=$isUserActive?>><a href="<?=$this->Html->url(array('controller' => 'User', 'action' => 'edit'))?>"><span class="glyphicons settings"></span></a></li>
        <li><a href="<?=$this->Html->url(array('controller' => 'User', 'action' => 'logout'))?>"><span class="glyphicons exit"></span></a></li>
        <li class="logo-li<?=$isKonstructorActive?>"><a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'view', Configure::read('Konstructor.groupID')))?>"><span class="logo-icon"></span></a></li>
    </ul>
</div>