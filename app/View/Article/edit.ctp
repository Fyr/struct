<?
	$id = $this->request->data('Article.id');
	$published = $this->request->data('Article.published');
?>
<?=$this->Form->create('Article')?>
<a class="btn btn-default smallBtn" href="javascript:void(0)"><span class="glyphicons parents"></span></a>
<div class="articleControls">
<?
	if ($id) {
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
	<?=$this->Form->input('title', array('type' => 'textarea', 'required' => 'required', 'placeholder' => __('Article title'), 'label' => false))?>
</div>
<div class="articleTitleBox">
	<?=$this->Form->input('section', array('type' => 'textarea', 'required' => 'required', 'placeholder' => __('Article section'), 'label' => false))?>
</div>
<div class="wordProcessor">
	<?=$this->Redactor->redactor('body', array('style' => 'width: 100%'))?>
</div>
<button type="submit" class="btn btn-primary" type="button"><?=__('Save')?></button>
<?=$this->Form->end()?>
