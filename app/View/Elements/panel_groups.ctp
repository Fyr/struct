<div class="searchBlock clearfix">
	<form id="searchGroupForm" action="" method="post">
	    <input class="searchInput" type="text" name="data[q]" value="<?=$this->request->data('q')?>" placeholder="<?=__('Find group...')?>">
	    <button type="submit" class="searchButton" ><span class="glyphicons search"></span></button>
    </form>
</div>
<div class="create-group">
    <div class="page-menu">
        <a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'edit'))?>" class="btn btn-default"><?=__('Create')?></a>
    </div>
</div>
<div class="dropdown-panel-scroll">
	<?=$this->element('group_list')?>
</div>