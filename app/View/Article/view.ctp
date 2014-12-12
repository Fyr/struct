<div class="editArticle">	
	<div class="articleControls">

		<a class="btn btn-default" href="<?=$this->Html->url(array('controller' => 'User', 'action' => 'view', Hash::get($article, 'Article.owner_id')))?>">
			<?=__('Back to profile')?>
		</a>
<?
	if ($isArticleAdmin) {
		$id = Hash::get($article, 'Article.id');
?>
		<a class="btn btn-default smallBtn" href="<?=$this->Html->url(array('controller' => 'Article', 'action' => 'edit', $id))?>">
			<span class="glyphicon glyphicon-wrench glyphicons wrench"></span>
		</a>
<?
	}
?>
	</div>
	<div class="articleTitleBox">
		<?=Hash::get($article, 'Article.title')?>
	</div>
	<div class="articleText">
		<?=Hash::get($article, 'Article.body')?>
	</div>
</div>