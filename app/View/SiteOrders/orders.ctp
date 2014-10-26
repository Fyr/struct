<a href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'recharge'))?>" class="btn rightButton"><?=__('Balance')?>: <?=$this->element('sum', array('sum' => $balance))?></a>
<span class="btn rightButton active"><?=__('My orders')?></span>
<h1><?=__('My orders')?></h1>
<?
	if ($aOrders) {
?>
<table class="myOrders">
<tr>
	<th width="35%">Номер заказа</th>
	<th width="20%">Дата создания</th>
	<th width="30%">Дата обновления</th>
	<th width="15%">Статус</th>
</tr>
<?
		foreach($aOrders as $order) {
?>
<tr>
	<td>
		<?=$order['Order']['id']?>
<?
			foreach($order['OrderType'] as $orderType) {
?>
		<div class="description"><?=$aProductTypeOptions[$orderType['product_type_id']]?></div>
<?
			}
?>
	</td>
	<td><?=$this->PHTime->niceShort($order['Order']['created'])?></td>
	<td><?=$this->PHTime->niceShort($order['Order']['modified'])?></td>
	<td class="status"><?=$this->element('order_status', array('order' => $order))?></td>
</tr>
<?
		}
?>
</table>
<?
	} else {
		echo '<br>'.__('- No orders -');
	}
?>