<div class="searchBlock clearfix">
    <form action="#">
        <input class="searchInput" type="text" placeholder="<?=__('Find user...')?>">
        <button class="searchButton" ><span class="glyphicons search"></span></button>
    </form>
</div>
<div class="dropdown-panel-scroll">
    <div class="messages-list allMessages">
        <?=$this->element('contact_list')?>
    </div>
</div>