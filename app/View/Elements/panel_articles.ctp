<div class="searchBlock clearfix">
	<form method="post" action="" id="searchArticleForm">
	    <input class="searchInput" type="text" name="data[q]" value="<?=$this->request->data('q')?>" placeholder="<?=__('Find article...')?>">
	    <button class="searchButton" type="submit"><span class="glyphicons search"></span></button>
    </form>
</div>

<div class="create-group">
	<div class="page-menu">
		<?=$this->Html->link(__('Create'), array('controller' => 'Article', 'action' => 'edit'), array('class' => 'btn btn-default pull-left'))?>
	</div>
</div>

<div class="dropdown-panel-scroll">
	<?=$this->element('article_list')?>
</div>