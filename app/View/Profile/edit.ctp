<?
	$id = $this->request->data('Profile.id');
?>
<?=$this->Form->create('Profile')?>
<?=$this->Form->hidden('Profile.id')?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="page-title"><?=($id)? __('Profile settings') : __('Create your profile')?></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 n-padding">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-3 n-padding">
                <div class="settings-avatar">
                    <!--a href="#"><img src="img/temp/bigavatar.jpg" alt="" /></a>
                    <input type="file" class="filestyle"-->
<?
	if ($id) {
		if ($this->request->data('Media.id')) {
			$src = $this->Media->imageUrl($this->request->data, 'noresize');
		} else {
			$src = '/img/no-photo.jpg';
		}
?>
                <img id="Profile<?=$id?>" src="<?=$src?>" alt="" data-resize="noresize" data-id="<?=$this->request->data('Media.id')?>" />
<?
	}
?>
                </div>
            </div>
<?
	if ($id) {
?>
            <div class="settings-avatar-info fs13 text-grey mb60">
                <input class="fileuploader filestyle" type="file" data-object_type="Profile" data-object_id="<?=$id?>" data-progress_id="progress-Profile<?=$id?>" />
                <span id="progress-Profile<?=$id?>">
	                <div id="progress-bar">
		            	<div id="progress-stats"></div>
		            </div>
	            </span>
            </div>
<?
	}
?>
            <div class="mb30">
                <a href="/tickets/tickets" target="_blank"><?=__('Tech.support')?></a>
            </div>
            <div class="settings-link">
                <a href="#"><span class="glyphicon-extended glyphicon-mailfull"></span> <?=__('Change email')?></a>
            </div>
            <div class="settings-link">
                <a href="#"><span class="glyphicon-extended glyphicon-unlock"></span> <?=__('Change password')?></a>
            </div>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-12">
<?
	if (isset($this->request->query['success']) && $this->request->query['success']) {
?>
    	<div align="center">
    		<label>
                <?=__('Profile has been successfully saved')?>
            </label>
        </div>
<?
	}
?>
			<div class="settings-input-row">
	            <div class="comments-box-send-info">
	                <?=__('Full name')?>
	            </div>
	            <div class="input-group settings-input col-md-12 col-sm-12">
	                <?=$this->Form->input('Profile.full_name', array('label' => false, 'class' => 'form-control'))?>
	            </div>
	        </div>
            <div class="settings-input-row">
	            <div class="comments-box-send-info">
	                <?=__('My video')?>
	            </div>
	            <div class="input-group settings-input col-md-12 col-sm-12">
	                <span class="input-group-addon halflings facetime-video"></span>
	                <?=$this->Form->input('Profile.video_url', array('label' => false, 'class' => 'form-control'))?>
	            </div>
	        </div>
	        <div class="settings-input-row">
	            <div class="comments-box-send-info">
	                <?=__('Phone')?>
	            </div>
	            <div class="input-group settings-input col-md-12 col-sm-12">
	                <?=$this->Form->input('Profile.phone', array('label' => false, 'class' => 'form-control'))?>
	            </div>
	        </div>
            <div class="settings-input-row">
	            <div class="comments-box-send-info">
	                <?=__('Skills')?>
	            </div>
	            <div class="input-group settings-input col-md-12 col-sm-12">
	            	<?=$this->Form->input('Profile.skills', array('type' => 'text', 'label' => false, 'class' => 'form-control col-md-12 col-sm-12', 'id' => 'tokenfield'))?>
	            </div>
	        </div>
            <div class="settings-input-row">
	            <div class="comments-box-send-info">
	                <?=__('Birthday')?>
	            </div>
	            <div id="datetimepicker1" class="input-group date settings-input col-md-12 col-sm-12">
	                <span class="input-group-addon">
	                    <span class="glyphicons calendar"></span>
	                </span>
	                <?=$this->Form->input('Profile.birthday', array('type' => 'text', 'label' => false, 'id' => 'datetimepicker6', 'class' => 'form-control', 'data-date-format' => "YYYY-MM-DD"))?>
	            </div>
	        </div>
            <!--div class="settings-input-row">
                <div class="comments-box-send-info">
                    Я проживаю
                </div>
                <div class="input-group settings-input col-md-12 col-sm-12">
                    <span class="input-group-addon glyphicon-extended glyphicons direction"></span>
                    <input class="form-control" />
                </div>
            </div-->
            <div class="settings-input-row">
	            <div class="comments-box-send-info">
	                <?=__('Country of residence')?>
	            </div>
	            <div class="input-group settings-input col-md-12 col-sm-12">
	                <span class="input-group-addon glyphicon-extended glyphicons direction"></span>
	                <?=$this->Form->input('Profile.live_country', array('type' => 'text', 'label' => false))?>
	            </div>
	        </div>
	        <div class="settings-input-row">
	            <div class="comments-box-send-info">
	                <?=__('City of residence')?>
	            </div>
	            <div class="input-group settings-input col-md-12 col-sm-12">
	                <span class="input-group-addon glyphicon-extended glyphicons direction"></span>
	                <?=$this->Form->input('Profile.live_place', array('type' => 'text', 'label' => false))?>
	            </div>
	        </div>
            <!--div class="settings-input-row">
                <div class="comments-box-send-info">
                    Университет
                </div>
                <div class="input-group settings-input col-md-12 col-sm-12">
                    <span class="input-group-addon glyphicon-extended glyphicons book_open"></span>
                    <input class="form-control" />
                </div>
            </div-->
            <div class="settings-input-row">
	            <div class="comments-box-send-info">
	                <?=__('University')?>
	            </div>
	            <div class="input-group settings-input col-md-12 col-sm-12">
	            	<?=$this->Form->input('Profile.university', array('type' => 'text', 'label' => false, 'class' => 'form-control'))?>
	            </div>
	        </div>
            
            <div class="group-create-cell">
                <fieldset class="gallery-block">
                    <label>Фотографии</label>
                    <div class="gallery-add page-menu clearfix">
                        <ul class="gallery-add-list clearfix">
                        	<li>
                        		<!--div class="remove-media"><span class="glyphicons circle_remove"></span></div-->
<?
	$src = $this->Media->imageUrl(array('Media' => $this->request->data('MediaUniversity')), 'thumb120x90');
	if (!$src) {
		$src = '/img/group-create-pl-image.jpg';
	}
?>
                        		<img id="ProfileUniversity<?=$id?>" alt="" src="<?=$src?>" data-media_id="<?=$this->request->data('MediaUniversity.id')?>" data-resize="thumb120x90" style="width: 120px; height: 90px;">
                        	</li>
                            <!--li>
                                <div class="remove-media"><span class="glyphicons circle_remove"></span></div>
                                <a data-fancybox-group="gallery-1" href="img/temp/gal-group-1.jpg" class="fancy-image">
                                    <img alt="" src="img/temp/gal-group-1.jpg" style="width: 118px;height: 90px">
                                </a>
                            </li>
                            <li>
                                    <span class="label-add">
                                        <span class="glyphicons picture"></span>
                                    </span>
                                    <span>
                                        <span class="halflings facetime-video label-add"></span>
                                    </span>
                            </li-->
                        </ul>
                        <input class="fileuploader filestyle" type="file" data-object_type="ProfileUniversity" data-object_id="<?=$id?>" data-progress_id="progress-ProfileUniversity<?=$id?>" />
                        <span id="progress-ProfileUniversity<?=$id?>">
			                <div id="progress-bar">
				            	<div id="progress-stats"></div>
				            </div>
			            </span>
                    </div>
                </fieldset>
            </div>
            
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 n-padding">
        <div class="profile-achievements-block">
            <div class="group-create-cell col-md-12 col-sm-12 col-xs-12">
                <div class="group-create-left col-md-3 col-sm-3 col-xs-12">
                    <a href="javascript:void(0)" class="add-new-info">
                        <span class="icons-new-info glyphicons circle_plus"></span>
                        <span class="title-new-info"><?=__('Add user achievement')?></span>
                    </a>
                </div>
                <div class="group-create-right col-md-7 col-sm-7 col-xs-12">
<?
	$aAchiev = $this->request->data('ProfileAchievement');
	if (!$aAchiev) {
?>
					<div class="group-fieldset no-items">
						<fieldset>
							<?=__('No achivements yet')?>
						</fieldset>
                    </div>
<?
	}
	foreach($aAchiev as $i => $row) {
?>
                
					<div class="group-fieldset">
						<input type="hidden" name="data[ProfileAchievement][<?=$i?>][id]" value="<?=Hash::get($row, 'id')?>">
						<input type="hidden" name="data[ProfileAchievement][<?=$i?>][profile_id]" value="<?=$id?>">
                        <fieldset>
                            <label for="achiv-title<?=$i?>"><?=__('Achievement')?></label>
                            <div class="input-boxing clearfix">
                                <textarea class="textarea-auto animated icon-left-width" id="achiv-title<?=$i?>" name="data[ProfileAchievement][<?=$i?>][title]" placeholder="<?=__('Achievement')?>..."><?=Hash::get($row, 'title')?></textarea>
                            </div>
                        </fieldset>
                        <fieldset>
                            <label for="achiv-url<?=$i?>"><?=__('Achievement approve URL')?></label>
                            <div class="input-boxing clearfix">
                                <input id="achiv-url<?=$i?>" type="text" name="data[ProfileAchievement][<?=$i?>][url]" value="<?=Hash::get($row, 'url')?>" placeholder="http://yoursite.com..."/>
                            </div>
                        </fieldset>
                    </div>
<?
	}
?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 n-padding">
        <div class="group-create-left col-md-3 col-sm-3 col-xs-12"></div>
        <div class="col-md-7 col-sm-7 col-xs-12">
            <div class="settings-input-row nbb">
                <div class="comments-box-send-info">
                    <?=__('Interface language')?>
                </div>
                <div class="box-select">
                    <label for="settings-input-row-lang"></label>
<?
	$options = array(
		'eng' => __('English'),
		'rus' => __('Russian')
	);
?>
                    <?=$this->Form->input('Profile.lang', array('label' => false, 'options' => $options, 'class' => 'formstyler', 'id' => 'settings-input-row-lang'))?>
                </div>
            </div>
            <div class="settings-input-row nbb clearfix mb100">
                <div class="col-md-3 col-sm-3 col-xs-3 npl">
                    <!--a href="#" class="btn btn-default save-button">Сохранить</a-->
                    <input type="submit" class="btn btn-default save-button" value="<?=__('Save')?>" />
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6  taright">
                    <a class="my-page-view-user" href="<?=$this->Html->url(array('controller' => 'Profile', 'action' => 'view'))?>"><?=__('How other people see this page')?></a>
                </div>
                <!--div class="col-md-3 col-sm-3 col-xs-3 taright">
                    <a href="#" class="btn btn-default"><?=__('Delete')?></a>
                </div-->
            </div>
        </div>
    </div>
</div>
<?=$this->Form->end()?>
<script type="text/javascript">
$(document).ready(function(){
	$('.profile-achievements-block .add-new-info').click(function(){
		$('.profile-achievements-block .no-items').remove();
		$('.profile-achievements-block .group-create-right').prepend(
			tmpl('profile-achiev', {i: $('.profile-achievements-block .group-create-right .group-fieldset').length})
		);
	});
});
</script>
<script type="text/x-tmpl" id="profile-achiev">
<div class="group-fieldset default">
	<input type="hidden" name="data[ProfileAchievement][{%=o.i%}][id]" value="">
	<input type="hidden" name="data[ProfileAchievement][{%=o.i%}][profile_id]" value="<?=$id?>">
    <fieldset>
        <label for="achiv-title{%=o.i%}"><?=__('Achievement')?></label>
        <div class="input-boxing clearfix">
            <textarea class="textarea-auto animated icon-left-width" id="achiv-title{%=o.i%}" name="data[ProfileAchievement][{%=o.i%}][title]" placeholder="<?=__('Achievement')?>..."></textarea>
        </div>
    </fieldset>
    <fieldset>
        <label for="achiv-url{%=o.i%}"><?=__('Achievement approve URL')?></label>
        <div class="input-boxing clearfix">
            <input id="achiv-url{%=o.i%}" type="text" name="data[ProfileAchievement][{%=o.i%}][url]" value="" placeholder="http://yoursite.com..."/>
        </div>
    </fieldset>
</div>
</script>