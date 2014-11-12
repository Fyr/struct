<?=$this->Form->create('Contractor', array('class' => 'contactForm'))?>
<div class="device-lists row col-md-10 col-sm-10 col-xs-10">
<?
	foreach($aProductTypes as $i => $productType) {
		$qty = $this->request->data($i.'.ProductType.qty');
		if ($qty) {
?>
    <div class="device-list-cell">
        <div class="device-list-h clearfix">
            <figure class="row col-md-2 col-sm-2 col-xs-2">
                <?=$this->element('product_image', $productType['ProductType'])?>
                <span class="size">x<?=$qty?></span>
            </figure>
            <div class="description col-md-10 col-sm-10 col-xs-10">
                <?=$productType['ProductType']['descr']?>
            </div>
        </div>
        <div class="device-list-b">
            <!--div class="min-size">
                <?=__('Min.qty')?>: <br />50 <?=__('items')?>
            </div-->
            <div class="devise-item-size clearfix">
                <div class="box-input">
                	<input type="hidden" name="data[<?=$i?>][OrderType][product_type_id]" value="<?=$productType['ProductType']['id']?>" />
                    <input type="text" name="data[<?=$i?>][OrderType][qty]" value="<?=$qty?>"/>
                </div>
                <div class="box-select page-menu">
<?
	$fieldName = 'period_'.$i;
	$options = array('name' => 'data['.$i.'][Order][period]', 'selected' => $this->request->data($i.'.Order.period'));
	echo '<span id="'.$fieldName.'">'.$this->element('select_period', compact('fieldName', 'options')).'</span>';
?>
<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function(){
		$('#<?=$fieldName?> .jq-selectbox__select-text').html($('#ContractorPeriod<?=$i?> option[selected="selected"]').html()); // select.options[select.selectedIndex].text
	}, 500);
});
</script>
                </div>
                <div class="price-month">
                    <?=$this->element('arenda_price', array('price' => $productType['ProductType']['arenda_price']))?>
                </div>
                <div class="remove">
                    <a class="remove-link" href="#" onclick="$(this).closest('.device-list-cell').remove()"><?=__('Remove')?></a>
                </div>
            </div>
        </div>
    </div>
<?
		}
	}
?>
    <!--div class="lease-terms"><span>*</span> При условии аренды на 5 лет</div-->
</div>
<style type="text/css">
.device-order-form label {margin-top: 30px;}
.device-list-cell:last {border-bottom: medium none;}
</style>
<div class="device-order-form row col-md-10 col-sm-10 col-xs-10">
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
		'placeholder' => __('Contractor phone').'...',
		'style' => 'max-width:274px'
	));
	echo $this->Form->input('Contractor.title', array(
		'label' => array('text' => __('Contractor name')),
		'placeholder' => __('Contractor\'s name').'...'
	));
	echo $this->Form->input('Contractor.details', array(
		'type' => 'text',
		'label' => array('text' => __('Contractor details')),
		'placeholder' => __('Contractor details').'...'
	));
?>
        </fieldset>
        <fieldset>
        	<br>
            <input type="submit" value="<?=__('Create order')?>"/>
            <!--div class="no-money">
                На вашем счету недостаточно средств
            </div-->
        </fieldset>
</div>
<?=$this->Form->end()?>
