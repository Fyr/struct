<?
	$id = $this->request->data('Article.id');
	$published = $this->request->data('Article.published');
?>
<?=$this->Form->create('Article', array('class' => 'editArticle'))?>
<div class="articleControls">
	<a class="btn btn-default" href="<?=$this->Html->url(array('controller' => 'User', 'action' => 'view'))?>">
		<?=__('Back to profile')?>
	</a>
<?
	if ($id) {
?>
	<a class="btn btn-default" href="<?=$this->Html->url(array('controller' => 'Article', 'action' => 'view', $id))?>">
		<?=__('View article')?>
	</a>
<?
		echo $this->Html->link(
			'<span class="glyphicons '.(($published) ? 'eye_open' : 'eye_close').'"></span>',
			array('controller' => 'Article', 'action' => 'changePublish', $id),
			array('class' => 'btn btn-default smallBtn', 'escape' => false)
		);
		echo $this->Html->link(
			'<span class="glyphicons bin"></span>',
			array('controller' => 'Article', 'action' => 'delete', $id),
			array('class' => 'btn btn-default smallBtn', 'escape' => false),
			__('Are you sure to delete this record?')
		);
	}
?>
</div>
<div class="articleTitleBox">
	<?=($id) ? __('Edit article') : __('Create article')?>
</div>
<br /><br /><br />

<div class="oneFormBlock">
	<div class="form-group">
	<?=$this->Form->input('title', array('placeholder' => __('Article title').'...', 'label' => __('Article title'), 'class' => 'form-control'))?>
	</div>
	<div class="settings-input-row" style="border-bottom: none;">
        <div class="comments-box-send-info">
            <?=__('Article section')?>
        </div>
        <div class="input-group settings-input col-md-12 col-sm-12 timezone-select">
            <?=$this->Form->input('cat_id', array('options' => $aCategoryOptions, 'placeholder' => __('Article section').'...', 'label' => false, 'class' => 'formstyler'))?>
        </div>
    </div>
</div>
	
<div class="wordProcessor">
	<?=$this->Redactor->redactor('body', array('style' => 'width: 100%'))?>
</div>
<button type="submit" class="btn btn-primary" type="button"><?=__('Save')?></button>
<?=$this->Form->end()?>
