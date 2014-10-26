<a href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'recharge'))?>" class="btn rightButton"><?=__('Balance')?>: <?=$this->element('sum', array('sum' => $balance))?></a>
<a href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'orders'))?>" class="btn rightButton"><?=__('My orders')?></a>
<h1><?=$productType['ProductType']['title']?></h1>
<?=$this->Form->create('Contractor', array('class' => 'contactForm'))?>
<div class="product clearfix">
	<img src="<?=$this->Media->imageUrl($productType, '100x')?>" class="fullImg" alt="<?=$productType['ProductType']['title']?>" />
	<div class="description">
		<div class="info"><?=$productType['ProductType']['descr']?></div>
		<span class="price"><?=$this->element('arenda_price', array('price' => $productType['ProductType']['arenda_price']))?></span>
		<div class="btn-group">
<?
	$options = array();
	for($i = 1; $i <= 10; $i++) {
		$options[$i] = $i.' '.__('units');
	}
	echo $this->Form->input('OrderType.qty', array('options' => $options, 'label' => false, 'class' => 'select110'));
?>
		</div>
		<div class="btn-group">
<?
	$options = array();
	for($i = 1; $i <= 12; $i++) {
		$options[$i] = $i.' '.__('months');
	}
	echo $this->Form->input('Order.period', array('options' => $options, 'label' => false, 'class' => 'select110'));
?>		
		</div>
		<div class="btn-group"><button type="submit" class="btn"><?=__('Create order')?></button></a></div>
	</div>
</div>
	<fieldset>
<?
	echo $this->Form->input('Contractor.contact_person', array(
		'label' => array('text' => __('Contact person')),
		'placeholder' => __('Contact person').'...'
	));
	echo $this->Form->input('Contractor.email', array(
		'type' => 'text',
		'placeholder' => __('Email').'...'
	));
	echo $this->Form->input('Contractor.phone', array(
		'type' => 'text',
		'placeholder' => __('+7(906)785-45-48').'...',
		'style' => 'max-width:274px'
	));
	echo $this->Form->input('Contractor.title', array(
		'label' => array('text' => __('Contractor\'s name')),
		'placeholder' => __('Contractor\'s name').'...'
	));
	echo $this->Form->input('Contractor.details', array(
		'type' => 'text',
		'label' => array('text' => __('Contractor details')),
		'placeholder' => __('Contractor details').'...'
	));
?>
		<div style="padding-top: 40px;"><button type="submit" class="btn"><?=__('Create order')?></button></div>
	</fieldset>
<?=$this->Form->end()?>