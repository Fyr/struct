<form id="devicePanelForm" action="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'checkout'), true)?>" method="post" style="padding-bottom: 100px;">
		<ul class="drop-device-list">
<?
	
	foreach($aDevices as $i => $device) {
?>
            <li class="drop-device-list-cell clearfix">
            	<input type="hidden" name="data[<?=$i?>][ProductType][id]" value="<?=$device['ProductType']['id']?>" />
                <figure class="drop-device-icon">
                	<?=$this->element('product_image', $device['ProductType'])?>
                </figure>
                <div class="drop-device-info">
                    <div class="title"><?=$device['ProductType']['title']?></div>
                    <div class="text-descript">
                        <p>
                        	<?=$device['ProductType']['teaser']?>
                        </p>
                        <div class="month-amount"><?=$this->element('arenda_price', array('price' => $device['ProductType']['arenda_price']))?></div>
                        <div class="select-option clearfix">
                            <div class="box-input">
                                <input type="text" name="data[<?=$i?>][ProductType][qty]" value="0" />
                            </div>
                            <div class="box-select page-menu">
<?
	$fieldName = 'period_'.$i;
	$options = array('name' => 'data['.$i.'][Order][period]');
	echo $this->element('select_period', compact('fieldName', 'options'));
?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
<?
	}
?>
        </ul>
</form>
