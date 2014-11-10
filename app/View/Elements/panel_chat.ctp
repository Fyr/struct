<div class="searchBlock clearfix">
        <input class="searchInput" type="text" value="<?=$this->request->data('q')?>" placeholder="<?=__('Find user...')?>">
        <button type="button" class="searchButton"><span class="glyphicons search"></span></button>
</div>
<div class="dropdown-panel-scroll">
    <div class="messages-list allMessages">
        <?=$this->element('contact_list')?>
    </div>
</div>