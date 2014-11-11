<style type="text/css">
/*
.group-page .group-create .group-create-cell fieldset:last {
    margin-bottom: 0px;
}
.group-page .group-create .group-create-cell fieldset:last .input-boxing:last {
	border-bottom: 2px solid #eeeeee;
}
*/
</style>
<?
	$this->Html->script('group-script', array('inline' => false));
	$id = $this->request->data('Group.id');
	$pageTitle = ($id) ? __('Group settings') : __('Create group');
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="page-title"><?=$pageTitle?></div>
    </div>
</div>
<div class="row group-create">
<?=$this->Form->create('Group')?>
<?=$this->Form->hidden('Group.id')?>
        <div class="group-create-head col-md-12 col-sm-12 col-xs-12">
            <div class="group-create-logo col-md-3 col-sm-3 col-xs-12">
                <figure class="col-md-12 col-sm-12 col-xs-5 settings-avatar">
                    <label for="filestyle-0">
<?
	if ($id) {
		if ($this->request->data('Media.id')) {
			$src = $this->Media->imageUrl($this->request->data, '200x');
		} else {
			$src = '/img/group-create-pl-image.jpg';
		}
?>
		                <img id="<?=$this->request->data('Media.id')?>" src="<?=$src?>" alt="" style="cursor: default" />
                        <input type="file" class="fileuploader filestyle" data-object_type="Group" data-object_id="<?=$id?>" data-progress_id="progress-Group_<?=$id?>" style="display: inline" />
<?
	}
?>
                    </label>
                </figure>
<?
	if ($id) {
?>
                <!--div class="edit-group-logo col-md-12 col-sm-12 col-xs-7">
                    Нажмите на фотографию, чтобы обновить её
                </div-->
                <span id="progress-Group_<?=$id?>">
                <div id="progress-bar">
	            	<div id="progress-stats"></div>
	            </div>
	            </span>
<?
	}
?>
            </div>
            <div class="group-create-cell col-md-9 col-sm-9 col-xs-12">
<?
	if (isset($this->request->query['success']) && $this->request->query['success']) {
?>
    	<div align="center">
    		<label>
                <?=__('Group has been successfully saved')?>
            </label>
        </div>
<?
	}
?>
                <fieldset>
                    <label for="group-create-1"><?=__('Group video')?></label>
                    <div class="input-boxing clearfix">
                        <span class="icon-input">
                            <span class="halflings facetime-video"></span>
                        </span>
                        <?=$this->Form->input('Group.video_url', array('type' => 'text', 'label' => false, 'class' => 'icon-left-width', 'placeholder' => 'http://yourgroupsite.com...'))?>
                    </div>
                </fieldset>
                <fieldset>
                    <label for="group-create-2"><?=__('Group title')?></label>
                    <div class="input-boxing clearfix">
                        <?=$this->Form->input('Group.title', array('label' => false, 'placeholder' => __('Group title').'...'))?>
                    </div>
                </fieldset>
                <fieldset>
                    <label for="group-create-3"><?=__('Description')?></label>
                    <div class="input-boxing clearfix">
                    	<?=$this->Form->input('Group.descr', array('type' => 'textarea', 'label' => false, 'class' => 'textarea-auto animated', 'placeholder' => __('Description'), 'style' => 'overflow: hidden; word-wrap: break-word; height: 235px;'))?>
                    </div>
                </fieldset>
<?
	if ($id) {
?>
                <fieldset>
                    <label><?=__('Photo or video gallery')?></label>
                    <div class="gallery-add page-menu clearfix">
                        <div class="drop-add-video">
                            <div class="close-block glyphicons circle_remove"></div>
                            <form action="#">
                                <label for="add-new-video-4"><?=__('Youtube.com URL')?></label>
                                <input id="add-new-video-4" type="text"/>
                                <div class="page-menu clearfix">
                                    <button class="btn btn-default"><?=__('Add')?></button>
                                </div>
                            </form>
                        </div>
                        <ul class="gallery-add-list clearfix">
                        </ul>
                        <span class="gallery-uploader" style="display: none;">
	                        <input type="file" class="fileuploader filestyle" data-object_type="GroupGallery" data-object_id="<?=$id?>" data-progress_id="progress-GroupGallery_<?=$id?>" />
	                        <span id="progress-GroupGallery_<?=$id?>">
		                        <div id="progress-bar">
					            	<div id="progress-stats"></div>
					            </div>
				            </span>
				            <button type="button" class="btn btn-default btn-sm add-video label-add"><?=__('Upload video')?></button>
			            </span>
                    </div>
                </fieldset>
<?
	}
?>
            </div>
        </div>
        <div class="group-address-block">
            <div class="group-create-cell col-md-12 col-sm-12 col-xs-12">
                <div class="group-create-left col-md-3 col-sm-3 col-xs-12">
                    <a class="add-new-info" href="javascript:void(0)">
                        <span class="icons-new-info glyphicons circle_plus"></span>
                        <span class="title-new-info"><?=__('Add another address')?></span>
                    </a>
                </div>
                <div class="group-create-right col-md-9 col-sm-9 col-xs-12">
<?
	$aGroupAddress = $this->request->data('GroupAddress');
	if ($aGroupAddress && is_array($aGroupAddress)) {
		foreach($aGroupAddress as $i => $groupAddress) {
			echo $this->element('group_address', array('i' => $i, 'groupAddress' => $groupAddress, 'group_id' => $id));
		}
	} else {
		echo $this->element('group_address', array('i' => 0, 'groupAddress' => array(), 'group_id' => $id));
	}
?>
                </div>
                
            </div>
        </div>
        <div class="group-achievements-block">
            <div class="group-create-cell col-md-12 col-sm-12 col-xs-12">
                <div class="group-create-left col-md-3 col-sm-3 col-xs-12">
                    <a class="add-new-info" href="javascript:void(0)">
                        <span class="icons-new-info glyphicons circle_plus"></span>
                        <span class="title-new-info"><?=__('Add another achievement')?></span>
                    </a>
                </div>
                <div class="group-create-right col-md-9 col-sm-9 col-xs-12">
<?
	$aGroupAchieve = $this->request->data('GroupAchievement');
	if ($aGroupAchieve && is_array($aGroupAchieve)) {
		foreach($aGroupAchieve as $i => $groupAchievement) {
			echo $this->element('group_achievement', array('i' => $i, 'groupAchievement' => $groupAchievement, 'group_id' => $id));
		}
	} else {
		echo $this->element('group_achievement', array('i' => 0, 'groupAchievement' => array(), 'group_id' => $id));
	}
?>
                	
                </div>
            </div>
        </div>
        <div class="group-create-cell col-md-12 col-sm-12 col-xs-12">
            <div class="group-create-left col-md-3 col-sm-3 col-xs-12"></div>
            <div class="group-create-right col-md-9 col-sm-9 col-xs-12">
                <!--div class="group-hide-view">
                    <div class="comments-hide-view">
                        <?=__('If you are looking for a job, employer can find you in our database')?>
                    </div>
                    <label>
                        <input type="checkbox" name="data[Group][hidden]" value="1" <?=$this->request->data('Group.hidden') ? 'checked="checked"' : ''?>/> <span class="glyphicons ok_2"></span> <?=__('Hide group')?>
                    </label>
                </div-->
                <div class="page-menu clearfix">
                    <input type="submit" class="btn btn-default" value="<?=__('Save')?>" />
<?
	if ($id) {
?>
                    <a href="#" class="btn btn-default"><?=__('Delete')?></a>
<?
	}
?>

                </div>
            </div>
        </div>
<?=$this->Form->end()?>

</div>
<script type="text/javascript">
var count = {address: 1, achieve: 1};
$(document).ready(function(){
	$('select.formstyler, input.filestyle').styler({
        fileBrowse: 'Загрузить фото'
    });
    $('.textarea-auto').autosize();
            
	$('.group-address-block .add-new-info').click(function(){
		var $div = $('.group-address-block .group-address-info:first');
		count.address++;
		$div.parent().append('<div class="group-address-info">' + $div.html().replace(/\[0\]/g, '[' + count.address + ']') + '</div>');
		$('input, textarea', $('.group-address-block .group-address-info:last')).val('');
		
		groupAddress_update();
	});
	groupAddress_update();
	
	$('.group-achievements-block .add-new-info').click(function(){
		var $div = $('.group-achievements-block .group-achieve-info:first');
		count.achieve++;
		$div.parent().append('<div class="group-achieve-info">' + $div.html().replace(/\[0\]/g, '[' + count.achieve + ']') + '</div>');
		$('input, textarea', $('.group-achievements-block .group-achieve-info:last')).val('');
		
		groupAchievement_update();
	});
	
	groupAchievement_update();
<?
	if ($id) {
?>	
	Group.updateGalleryAdmin(<?=$id?>);
<?
	}
?>
});

function groupAddress_update() {
	$('.group-address-block .group-block-remove').hide();
	$('.group-address-block .group-block-remove').off();
	if ($('.group-address-block .group-address-info').length >= 1) {
		$('.group-address-block .group-block-remove').show();
		$('.group-address-block .group-block-remove').on('click', function(){
			$(this).parent().remove();
			groupAddress_update();
		});
	}
}

function groupAchievement_update() {
	$('.group-achievements-block .group-block-remove').hide();
	$('.group-achievements-block .group-block-remove').off();
	if ($('.group-achievements-block .group-address-info').length >= 1) {
		$('.group-achievements-block .group-block-remove').show();
		$('.group-achievements-block .group-block-remove').on('click', function(){
			$(this).parent().remove();
			groupAchievement_update();
		});
	}
}
</script>