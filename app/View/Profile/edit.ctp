<style type="text/css">
.settings-input input {
	font-size: 20px;
}
</style>
<?
	$id = $this->request->data('Profile.id');
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="page-title"><?=($id)? __('Profile settings') : __('Create your profile')?></div>
    </div>
</div>
<div class="row">
<?=$this->Form->create('Profile')?>
<?=$this->Form->hidden('Profile.id')?>
<div class="col-md-12 col-sm-12 col-xs-12 n-padding">
    <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-3 n-padding">
            <div class="settings-avatar">
<?
	if ($id) {
		if ($this->request->data('Media.id')) {
			$src = $this->Media->imageUrl($this->request->data, 'noresize');
		} else {
			$src = '/img/no-photo.jpg';
		}
?>
                <img id="<?=$this->request->data('Media.id')?>" src="<?=$src?>" alt="" />
<?
	}
?>
            </div>
        </div>
<?
	if ($id) {
?>
			<div class="col-md-12 col-sm-12 col-xs-9">
                <input class="fileuploader filestyle" type="file" data-object_type="Profile" data-object_id="<?=$id?>" />
                <div id="progress-bar">
	            	<div id="progress-stats"></div>
	            </div>
	            <div class="mb30">
		            <a href="/tickets/tickets" target="_blank"><?=__('Tech.support')?></a>
		        </div>
	        </div>
<?
	}
?>
        <!--div class="settings-link">
            <a href="#"><span class="glyphicon-extended glyphicon-mailfull"></span> <?=__('Change email')?></a>
        </div>
        <div class="settings-link">
            <a href="#"><span class="glyphicon-extended glyphicon-unlock"></span> <?=__('Change password')?></a>
        </div-->
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
                <?=__('My video')?>
            </div>
            <div class="input-group settings-input col-md-12 col-sm-12">
                <span class="input-group-addon halflings facetime-video"></span>
                <?=$this->Form->input('Profile.video_url', array('label' => false, 'class' => 'form-control'))?>
            </div>
        </div>
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
        <div class="settings-input-row">
            <div class="comments-box-send-info">
                <?=__('I live')?>
            </div>
            <div class="input-group settings-input col-md-12 col-sm-12">
                <span class="input-group-addon glyphicon-extended glyphicons direction"></span>
                <?=$this->Form->input('Profile.live_place', array('type' => 'text', 'label' => false))?>
            </div>
        </div>
        <div class="settings-input-row nbb">
            <div class="comments-box-send-info">
                <?=__('Interface language')?>
            </div>
            <input class="hidenibput" id="lang" type="text" />
            <div class="box-select">
                <label for="settings-input-row-lang"></label>
<?
	$options = array(
		'eng' => __('English'),
		'rus' => __('Russian')
	);
?>
<?=$this->Form->input('Profile.lang', array('label' => false, 'options' => $options, 'class' => 'formstyler', 'id' => 'settings-input-row-lang'))?>
                <!--select class="formstyler" name="data[Profile][lang]" id="settings-input-row-lang">
                    <option value="0" selected="selected">English</option>
                    <option value="1">Русский</option>
                </select-->
            </div>
            <!--div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="htmlholder"><span class="country-icon"><img src="/img/temp/en.png" alt=""/></span>  English</span> <span class="halflings chevron-down"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                	<li><a data-lang="en2" href="#"><span class="country-icon"><img src="/img/temp/en.png" alt=""/></span> English</span></a></li>
                    <li><a data-lang="en1" href="#"><span class="country-icon"><img src="/img/temp/russia.png" alt=""/></span>English</a></li>
                </ul>
            </div-->
        </div>
        <!--div class="settings-input-row nbb">
            <div class="comments-box-send-info">
            	<?=__('If you are looking for a job, employer can find you in our database')?>
            </div>
            <label>
                <input type="checkbox" /> <span class="glyphicon glyphicon-ok"></span> <?=__('I am looking for a job')?>
            </label>
        </div-->
        <div class="settings-input-row nbb clearfix mb100">
            <div class="col-md-2 col-sm-2 npl">
                <input type="submit" class="btn btn-default" value="<?=__('Save')?>" />
            </div>
            <div class="col-md-10 col-sm-10 taright">
                <a class="my-page-view-user" href="<?=$this->Html->url(array('controller' => 'Profile', 'action' => 'view'))?>"><?=__('How other people see this page')?></a>
            </div>
        </div>
        <!--div class="settings-input-row nbb clearfix">
            <div class="col-md-2 col-sm-2 npl">
                <a href="#" class="btn btn-default">
                    <?=__('Delete')?>
                </a>
            </div>
            <div class="col-md-10 col-sm-10 ">
                <div class="fs13 text-grey">
                	<?=__('You can easily remove your profile from the site, just click the button and all information will be deleted permanently.')?>
                </div>
            </div>
        </div-->
    </div>
</div>
<?=$this->Form->end()?>

</div>
<script type="text/javascript">
<?
	$profileID = Hash::get($profile, 'Profile.id');
?>
var objectType = 'Profile', objectID = <?=($profileID) ? $profileID : 'null'?>;
</script>