<div class="searchBlock clearfix">
	<form method="post" action="" id="searchArticleCatForm">
	    <input class="searchInput" type="text" name="data[q]" value="<?=$this->request->data('q')?>" placeholder="<?=__('Find article...')?>">
	    <button class="searchButton" type="submit"><span class="glyphicons search"></span></button>
    </form>
</div>

<!--div class="create-group">
	<div class="page-menu">
		<?=$this->Html->link(__('Create'), array('controller' => 'Article', 'action' => 'edit'), array('class' => 'btn btn-default pull-left'))?>
	</div>
</div-->

<div class="dropdown-panel-scroll">
	<ul class="group-list" style="padding-top: 82px">
<?
	if ($aCategories) {
		echo $this->element('notes_list');
	} else {
		echo $this->element('article_list', array('aArticles' => $aArticles, 'showControls' => false));
	}
?>
	</ul>
</div>