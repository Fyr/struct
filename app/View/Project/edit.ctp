<?
	$this->Html->script('group-script', array('inline' => false));
	$id = $this->request->data('Project.id');
	$pageTitle = ($id) ? __('Project settings') : __('Create project');
?>
<div class="row header-group-create clearfix">
    <div class="group-page-title col-md-12 col-sm-12 col-xs-12"><?=$pageTitle?></div>
</div>
<?=$this->Form->create('Project')?>
<?=$this->Form->hidden('Project.id')?>
<div class="row group-create">
        <div class="group-create-head col-md-12 col-sm-12 col-xs-12">
            <div class="group-create-cell col-md-9 col-sm-9 col-xs-12">
<?
	if (isset($this->request->query['success']) && $this->request->query['success']) {
?>
		    	<div align="center">
		    		<label>
		                <?=__('Project has been successfully saved')?>
		            </label>
		        </div>
<?
	}
?>
				<fieldset>
                    <label for="group-create-2"><?=__('Project title')?></label>
                    <div class="input-boxing clearfix">
                        <?=$this->Form->input('Project.title', array('label' => false, 'placeholder' => __('Project title').'...'))?>
                    </div>
                </fieldset>
                <fieldset>
                    <label for="group-create-3"><?=__('Deadline')?></label>
                    <div class="input-boxing clearfix">
                    	<?=$this->Form->input('Project.deadline', array('type' => 'text', 'label' => false, 'class' => 'datetimepicker', 'data-date-format' => 'YYYY-MM-DD'))?>
                    </div>
                </fieldset>
                <fieldset>
                    <label for="group-create-3"><?=__('Description')?></label>
                    <div class="input-boxing clearfix">
                    	<?=$this->Form->input('Project.descr', array('type' => 'textarea', 'label' => false, 'class' => 'textarea-auto animated', 'placeholder' => __('Description'), 'style' => 'overflow: hidden; word-wrap: break-word; height: 235px;'))?>
                    </div>
                </fieldset>

            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="page-menu clearfix">
                    <input type="submit" class="btn btn-default save-button" value="<?=__('Save')?>" />
<?
	if ($id) {
?>
                    <a href="<?=$this->Html->url(array('controller' => 'Project', 'action' => 'delete', $id))?>" class="btn btn-default delete-group"><?=__('Delete')?></a>
<?
	}
?>
                </div>
        </div>
</div>
<?=$this->Form->end()?>
<script type="text/javascript">

</script>

