<?
	foreach($aDevices as $device) {
?>
<div class="productItem clearfix">
	<div class="thumb"><img src="<?=$this->Media->imageUrl($device, '60x')?>" alt="<?=$device['ProductType']['title']?>" /></div>
	<div class="name"><?=$device['ProductType']['title']?></div>
	<div class="description"><?=$device['ProductType']['teaser']?></div>
	<div class="orderInfo">
		<?=$this->element('arenda_price', array('price' => $device['ProductType']['arenda_price']))?>
		<a href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'checkout', $device['ProductType']['id']), true)?>" class="btn"><?=__('Order it')?></a>
	</div>
</div>
<?
	}
?>