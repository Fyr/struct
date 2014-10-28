<div class="searchBlock clearfix">
	<input type="text" value="Найти устройство"  />
	<a href="javascript: void(0)" class="glyphicons search"></a>
</div>
<div class="myOrders">
	<a href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'orders'))?>" class="btn"><?=__('My orders')?></a>
</div>
<div id="allOrders" style="overflow:hidden">
	<?=$this->element('device_list')?>
</div>
<div class="recharge clearfix">
	<span class="glyphicons wallet"></span>
	<div class="text">
		<div class="balance"><?=__('Balance')?>: <?=$this->element('sum', array('sum' => $balance))?></div>
		<a href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'recharge'))?>"><?=__('Recharge')?></a>
	</div>
</div>