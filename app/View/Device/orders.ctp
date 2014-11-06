<div class="device-order-data row col-md-12 col-sm-12 col-xs-12">
    <!--div class="group-menu page-menu taleft">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn active btn-default">Месяц</button>
            <button type="button" class="btn btn-default">Квартал</button>
            <button type="button" class="btn btn-default">Год</button>
        </div>
    </div-->
</div>
<div class="device-order col-md-12 col-sm-12 col-xs-12">
    <div class="calendar-name col-md-2 col-sm-2 col-xs-12">
        <div class="days-cal"><?=date('F')?></div>
    </div>
    <div class="device-order-table col-md-10 col-sm-10 col-xs-12">
    	<div class="device-order-t-header clearfix  col-md-12 col-sm-12 col-xs-12">
            <div class="number col-md-10 col-sm-10 col-xs-10"><?=__('Order ID')?></div>
            <div class="price  col-md-2 col-sm-2 col-xs-2 t-a-center"><?=__('Sum')?>, $</div>
        </div>
        
<?
	$total = 0;
	foreach($aOrders as $order) {
		$orderType = $order['OrderType'][0];
		$productType = $aProductTypeOptions[$orderType['product_type_id']]['ProductType'];
		$sum = $orderType['qty'] * $productType['arenda_price'];
		$total+= $sum;
?>
        <div class="device-order-t-cell col-md-12 col-sm-12 col-xs-12 clearfix">
            <div class="number-order col-md-2 col-sm-2 col-xs-12">
                <a href="#"><?=$order['Order']['id']?></a>
            </div>
            <div class="item-order-list col-md-10 col-sm-10 col-xs-12 clearfix">
                <ul class="list-item-device">
                    <li class="clearfix">
                        <div class="list-item-inner col-md-10 col-sm-10 col-xs-10">
                            <figure class="device-image">
                                <?=$this->element('product_image', $orderType)?>
                                <span class="size">x<?=$orderType['qty']?></span>
                            </figure>
                            <div class="description"><?=$productType['title']?></div>
                        </div>
                        <div class="item-order-price col-md-2 col-sm-2 col-xs-2 t-a-center"><?=$sum?></div>
                    </li>

                    <!--li class="clearfix">
                        <div class="list-item-inner col-md-10 col-sm-10 col-xs-10">
                            <figure class="device-image">
                                <span class="icon glyphicons print"></span>
                                <span class="size">x2</span>
                            </figure>
                            <div class="description">Копия печать</div>
                        </div>
                        <div class="item-order-price col-md-2 col-sm-2 col-xs-2 t-a-center"></div>
                        <div class="responsible-user col-md-12 col-sm-12 col-xs-12">
                            <div class="user-cell clearfix">
                                <div class="user-cell-left col-md-10 col-sm-10 col-xs-10">
                                    <figure class="user-image good"><img src="/img/device-user-1.jpg" alt=""/></figure>
                                    <div class="description-user clearfix">
                                        <div class="name">
                                            <div class="title">Альберт Леманн</div>
                                            <div class="id">id: 8I2WTZ6LZVG28V</div>
                                        </div>
                                        <div class="data-device">
                                            Распечатано <br/>
                                            <span class="size-printed">227 стр.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-order-price col-md-2 col-sm-2 col-xs-2 t-a-center">45,40</div>
                            </div>
                            <div class="user-cell clearfix">
                                <div class="user-cell-left col-md-10 col-sm-10 col-xs-10">
                                    <figure class="user-image good"><img src="/img/device-user-2.jpg" alt=""/></figure>
                                    <div class="description-user clearfix">
                                        <div class="name">
                                            <div class="title">Антон Кулаев</div>
                                            <div class="id">id: 4JPONXIIL2A2V0</div>
                                        </div>
                                        <div class="data-device">
                                            Распечатано <br/>
                                            <span class="size-printed">4 896 стр.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-order-price col-md-2 col-sm-2 col-xs-2 t-a-center">979,20</div>
                            </div>
                        </div>
                    </li-->
                </ul>
            </div>
        </div>
<?
	}
?>

        <div class="device-order-total col-md-12 col-sm-12 col-xs-12">
            <div class="total-price">$<?=$total?></div>
        </div>
    </div>
</div>