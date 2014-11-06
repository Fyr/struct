<div class="dropdown-panel-scroll">
	<?=$this->element('device_list')?>
</div>
<div class="b-order-bottom-device clearfix">
    <a href="<?=$this->Html->url(array('controller' => 'Device', 'action' => 'orders'), true)?>" class="my-orders"><?=__('My orders')?></a>
    <a href="#" class="order-device" onclick="$('#devicePanelForm').submit()"><?=__('Order it')?></a>
</div>