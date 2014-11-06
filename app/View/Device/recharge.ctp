<div class="personal-account">
    <div class="description"><?=__('Choose the suitable payment system to recharge your balance')?></div>
    <form action="#">
        <div class="payment-personal-account">
            <ul class="clearfix">
                <li class="active visa"></li>
                <li class="master-cart"></li>
                <li class="yandex-money"></li>
                <li class="qiwi"></li>
            </ul>
        </div>
        <div class="payment-amount">
            <label for="payment-amount-input"><?=__('Recharge amount')?></label> <br/>
            <div class="input-block page-menu">
                <input id="payment-amount-input" value="$ 300" type="text"/>
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-send"></span>
                </button>
            </div>
        </div>
    </form>
</div>