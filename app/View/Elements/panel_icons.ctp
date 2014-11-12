<div class="main-panel-list">
    <ul>
        <li><a href="javascript:void(0)"><span class="glyphicons search searchPanel"></span></a></li>
        <li<?=($this->request->controller == 'Chat') ? ' class="active"' : ''?>><a href="javascript:void(0)"><span class="glyphicons chat chatPanel"></span><div id="chatTotalUnread" class="count"></div></a></li>
        <li<?=($this->request->controller == 'Group') ? ' class="active"' : ''?>><a href="javascript:void(0)"><span class="glyphicons group groupPanel"></span></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons notes notesPanel"></span></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons briefcase briefcasePanel"></span></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons credit_card credit_cardPanel"></span><div class="count"></div></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons cloud cloudPanel"></span></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons file filePanel"></span></a></li>
        <li<?=($this->request->controller == 'Device') ? ' class="active"' : ''?>><a href="javascript:void(0)"><span class="glyphicons ipad ipadPanel"></span></a></li>
        <li><a href="javascript:void(0)"><span class="glyphicons calendar calendarPanel"></span></a></li>
    </ul>
</div>
<div class="service-menu">
    <ul>
        <li<?=($this->request->controller == 'Profile' && $this->request->action == 'edit') ? ' class="active"' : ''?>><a href="<?=$this->Html->url(array('controller' => 'Profile', 'action' => 'edit'))?>"><span class="glyphicons settings"></span></a></li>
        <li><a href="<?=$this->Html->url(array('controller' => 'Users', 'action' => 'logout'))?>"><span class="glyphicons exit"></span></a></li>
        <li class="logo-li"><a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'view', 7))?>"><span class="logo-icon"></span></a></li>
    </ul>
</div>