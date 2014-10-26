<span class="btn rightButton active"><?=__('Balance')?>: <?=$this->element('sum', array('sum' => $balance))?></span>
<a href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'orders'))?>" class="btn rightButton"><?=__('My orders')?></a>
<h1><?=__('Recharge balance')?></h1>

