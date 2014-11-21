<?
	$this->Html->script('group-script', array('inline' => false));
	$id = $this->request->data('Group.id');
	$pageTitle = ($id) ? __('Group settings') : __('Create group');
?>
<div class="row header-group-create clearfix">
    <div class="group-page-title col-md-12 col-sm-12 col-xs-12"><?=$pageTitle?></div>
</div>
<?=$this->Form->create('Group')?>
<?=$this->Form->hidden('Group.id')?>
<div class="row group-create">
        <div class="group-create-head col-md-12 col-sm-12 col-xs-12">
            <div class="group-create-logo col-md-3 col-sm-3 col-xs-12">
                
<?
	if ($id) {
		if ($this->request->data('Media.id')) {
			$src = $this->Media->imageUrl($this->request->data, '200x');
		} else {
			$src = '/img/group-create-pl-image.jpg';
		}
?>
				<figure class="col-md-12 col-sm-12 col-xs-5">
                    <img id="Group<?=$id?>" src="<?=$src?>" alt="" data-resize="noresize" data-id="<?=$this->request->data('Media.id')?>" />
                </figure>
                <input class="fileuploader filestyle" type="file" data-object_type="Group" data-object_id="<?=$id?>" data-progress_id="progress-Group<?=$id?>" />
                <span id="progress-Group<?=$id?>">
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
                    <label for="group-create-2"><?=__('Group title')?></label>
                    <div class="input-boxing clearfix">
                        <?=$this->Form->input('Group.title', array('label' => false, 'placeholder' => __('Group title').'...'))?>
                    </div>
                </fieldset>
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
                                <label for="add-new-video"><?=__('Youtube.com URL')?></label>
                                <input id="add-new-video" type="text"/>
                                <div class="page-menu clearfix">
                                    <button type="button" class="btn btn-default" onclick="Group.addGalleryVideo(<?=$id?>)"><?=__('Add')?></button>
                                </div>
                        </div>
                        <ul class="gallery-add-list clearfix">
                        </ul>
                        <span class="gallery-uploader" style="display: none;">
	                        <input type="file" class="fileuploader filestyle" data-object_type="GroupGallery" data-object_id="<?=$id?>" data-progress_id="progress-GroupGallery_<?=$id?>" />
				            <button type="button" class="btn btn-default btn-sm add-video label-add"><?=__('Upload video')?></button>
				            <div id="progress-GroupGallery_<?=$id?>">
		                        <div id="progress-bar">
					            	<div id="progress-stats"></div>
					            </div>
				            </div>
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
                        <span class="title-new-info"><?=__('Add group address')?></span>
                    </a>
                </div>
                <div class="group-create-right col-md-9 col-sm-9 col-xs-12">
<?
	$aGroupAddress = $this->request->data('GroupAddress');
	if (!$aGroupAddress) {
?>
					<div class="group-fieldset no-items">
						<fieldset>
							<?=__('No addresses yet')?>
						</fieldset>
                    </div>
<?
	} else {
		foreach($aGroupAddress as $i => $groupAddress) {
?>
                	<div class="group-address">
                		<input type="hidden" name="data[GroupAddress][<?=$i?>][id]" value="<?=Hash::get($groupAddress, 'id')?>">
						<input type="hidden" name="data[GroupAddress][<?=$i?>][group_id]" value="<?=$id?>">
	                    <fieldset>
						    <label for="group-create-4"><?=__('Headquaters')?></label>
						    <div class="input-boxing clearfix">
						        <span class="icon-input">
						            <span class="glyphicons direction"></span>
						        </span>
						        <textarea class="textarea-auto animated icon-left-width" id="group-create-4" name="data[GroupAddress][<?=$i?>][address]" placeholder="<?=__('Headquaters')?>..."><?=Hash::get($groupAddress, 'address')?></textarea>
						    </div>
						</fieldset>
						<fieldset>
						    <label for="group-create-5"><?=__('Phone')?></label>
						    <div class="input-boxing clearfix">
						        <span class="icon-input">
						            <span class="glyphicons earphone"></span>
						        </span>
						        <input class="icon-left-width" id="group-create-5" type="text" name="data[GroupAddress][<?=$i?>][phone]" value="<?=Hash::get($groupAddress, 'phone')?>" placeholder="<?=__('Phone')?>..." />
						    </div>
						</fieldset>
						<fieldset>
						    <label for="group-create-7"><?=__('Site URL and email')?></label>
						    <div class="input-boxing clearfix">
						        <span class="icon-input">
						            <span class="glyphicons globe_af"></span>
						        </span>
						        <input class="icon-left-width" id="group-create-7" type="text" name="data[GroupAddress][<?=$i?>][url]" value="<?=Hash::get($groupAddress, 'url')?>" placeholder="<?=__('http://yoursite.com')?>..." />
						    </div>
						    <div class="input-boxing clearfix">
						        <span class="icon-input">
						            <span class="glyphicons message_empty"></span>
						        </span>
						        <input class="icon-left-width" id="group-create-8" type="text" name="data[GroupAddress][<?=$i?>][email]" value="<?=Hash::get($groupAddress, 'email')?>" placeholder="<?=__('Email')?>..."/>
						    </div>
						</fieldset>
                    </div>
<?
		}
	}
?>
                </div>
            </div>
        </div>
        
		<div class="group-achievements-block mb40">
            <div class="group-create-cell col-md-12 col-sm-12 col-xs-12">
                <div class="group-create-left col-md-3 col-sm-3 col-xs-12">
                    <a class="add-new-info" href="javascript:void(0)">
                        <span class="icons-new-info glyphicons circle_plus"></span>
                        <span class="title-new-info"><?=__('Add group achievement')?></span>
                    </a>
                </div>
                <div class="group-create-right col-md-9 col-sm-9 col-xs-12">
<?
	$aAchiev = $this->request->data('GroupAchievement');
	if (!$aAchiev) {
?>
					<div class="group-fieldset no-items">
						<fieldset>
							<?=__('No achivements yet')?>
						</fieldset>
                    </div>
<?
	} else {
		foreach($aAchiev as $i => $row) {
?>
                
					<div class="group-fieldset">
						<input type="hidden" name="data[GroupAchievement][<?=$i?>][id]" value="<?=Hash::get($row, 'id')?>">
						<input type="hidden" name="data[GroupAchievement][<?=$i?>][group_id]" value="<?=$id?>">
                        <fieldset>
                            <label for="achiv-title<?=$i?>"><?=__('Achievement')?></label>
                            <div class="input-boxing clearfix">
                                <textarea class="textarea-auto animated icon-left-width" id="achiv-title<?=$i?>" name="data[GroupAchievement][<?=$i?>][title]" placeholder="<?=__('Achievement')?>..."><?=Hash::get($row, 'title')?></textarea>
                            </div>
                        </fieldset>
                        <fieldset>
                            <label for="achiv-url<?=$i?>"><?=__('Achievement approve URL')?></label>
                            <div class="input-boxing clearfix">
                                <input id="achiv-url<?=$i?>" type="text" name="data[GroupAchievement][<?=$i?>][url]" value="<?=Hash::get($row, 'url')?>" placeholder="http://yoursite.com..."/>
                            </div>
                        </fieldset>
                    </div>
<?
		}
	}
?>
                </div>
            </div>
        </div>
        
        <div class="group-create-cell col-md-12 col-sm-12 col-xs-12">
            <div class="group-create-left col-md-3 col-sm-3 col-xs-12"></div>
            <div class="group-create-right col-md-9 col-sm-9 col-xs-12">
                <div class="page-menu clearfix">
                    <input type="submit" class="btn btn-default save-button" value="<?=__('Save')?>" />
<?
	if ($id) {
?>
                    <a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'delete', $id))?>" class="btn btn-default delete-group"><?=__('Delete')?></a>
<?
	}
?>
                </div>
            </div>
        </div>
</div>
<?=$this->Form->end()?>
<script type="text/javascript">
$(document).ready(function(){
<?
	if ($id) {
?>	
	Group.updateGalleryAdmin(<?=$id?>);
<?
	}
?>
	$('.group-address-block .add-new-info').click(function(){
		$('.group-address-block .no-items').remove();
		$('.group-address-block .group-create-right').prepend(
			tmpl('group-address', {i: $('.group-address-block .group-create-right .group-address').length})
		);
	});
	$('.group-achievements-block .add-new-info').click(function(){
		$('.group-achievements-block .no-items').remove();
		$('.group-achievements-block .group-create-right').prepend(
			tmpl('group-achiev', {i: $('.group-achievements-block .group-create-right .group-fieldset').length})
		);
	});
});
</script>

<script type="text/x-tmpl" id="group-address">
<div class="group-address">
	<input type="hidden" name="data[GroupAddress][{%=o.i%}][id]" value="">
	<input type="hidden" name="data[GroupAddress][{%=o.i%}][group_id]" value="<?=$id?>">
    <fieldset>
	    <label for="group-create-4"><?=__('Headquaters')?></label>
	    <div class="input-boxing clearfix">
	        <span class="icon-input">
	            <span class="glyphicons direction"></span>
	        </span>
	        <textarea class="textarea-auto animated icon-left-width" id="group-create-4" name="data[GroupAddress][{%=o.i%}][address]" placeholder="<?=__('Headquaters')?>..."></textarea>
	    </div>
	</fieldset>
	<fieldset>
	    <label for="group-create-5"><?=__('Phone')?></label>
	    <div class="input-boxing clearfix">
	        <span class="icon-input">
	            <span class="glyphicons earphone"></span>
	        </span>
	        <input class="icon-left-width" id="group-create-5" type="text" name="data[GroupAddress][{%=o.i%}][phone]" value="" placeholder="<?=__('Phone')?>..." />
	    </div>
	</fieldset>
	<fieldset>
	    <label for="group-create-7"><?=__('Site URL and email')?></label>
	    <div class="input-boxing clearfix">
	        <span class="icon-input">
	            <span class="glyphicons globe_af"></span>
	        </span>
	        <input class="icon-left-width" id="group-create-7" type="text" name="data[GroupAddress][{%=o.i%}][url]" value="" placeholder="<?=__('http://yoursite.com')?>..." />
	    </div>
	    <div class="input-boxing clearfix">
	        <span class="icon-input">
	            <span class="glyphicons message_empty"></span>
	        </span>
	        <input class="icon-left-width" id="group-create-8" type="text" name="data[GroupAddress][{%=o.i%}][email]" value="" placeholder="<?=__('Email')?>..."/>
	    </div>
	</fieldset>
</div>
</script>

<script type="text/x-tmpl" id="group-achiev">
<div class="group-fieldset default">
	<input type="hidden" name="data[GroupAchievement][{%=o.i%}][id]" value="">
	<input type="hidden" name="data[GroupAchievement][{%=o.i%}][profile_id]" value="<?=$id?>">
    <fieldset>
        <label for="achiv-title{%=o.i%}"><?=__('Achievement')?></label>
        <div class="input-boxing clearfix">
            <textarea class="textarea-auto animated icon-left-width" id="achiv-title{%=o.i%}" name="data[GroupAchievement][{%=o.i%}][title]" placeholder="<?=__('Achievement')?>..."></textarea>
        </div>
    </fieldset>
    <fieldset>
        <label for="achiv-url{%=o.i%}"><?=__('Achievement approve URL')?></label>
        <div class="input-boxing clearfix">
            <input id="achiv-url{%=o.i%}" type="text" name="data[GroupAchievement][{%=o.i%}][url]" value="" placeholder="http://yoursite.com..."/>
        </div>
    </fieldset>
</div>
</script>

<script type="text/x-tmpl" id="group-gallery-image-admin">
{% 
	for(var i = 0; i < o.length; i++) { 
		var img = o[i].Media;
%}
    <li>
        <div class="remove-media" onclick="Group.delGalleryImage({%=img.object_id%}, {%=img.id%})"><span class="glyphicons circle_remove"></span></div>
        <a href="javascript::void(0)">
            <img src="{%=img.image.replace(/100x80/, 'thumb120x90')%}" alt="" />
        </a>
    </li>
{%
	}
%}
</script>

<script type="text/x-tmpl" id="group-gallery-video-admin">
{% 
	for(var i = 0; i < o.length; i++) { 
		var video = o[i].GroupVideo;
%}
    <li>
        <div class="remove-media" onclick="Group.delGalleryVideo({%=video.group_id%}, {%=video.id%})"><span class="glyphicons circle_remove"></span></div>
        <a class="gallery-video" href="javascript::void(0)">
        	<img src="http://img.youtube.com/vi/{%=video.video_id%}/1.jpg" alt="" />
        </a>
    </li>
{%
	}
%}
</script>