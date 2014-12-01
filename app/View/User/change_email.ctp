<?
	$id = $this->request->data('User.id');
?>
<?=$this->Form->create('User')?>
<?=$this->Form->hidden('User.id')?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="page-title"><?=__('Change email')?></div>
    </div>
</div>
<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 n-padding">
            <div class="col-md-7 col-sm-7 col-xs-12">
                <div class="settings-input-row">
                    <div class="comments-box-send-info"><?=__('New email')?></div>
                    <div class="input-group settings-input col-md-12 col-sm-12">
                        <span class="input-group-addon glyphicons message_full"></span>
                        <?=$this->Form->input('username', array('class' => 'form-control', 'label' => false))?>
                    </div>
                </div>
                <div class="settings-input-row">
                    <div class="comments-box-send-info"><?=__('Confirm email')?></div>
                    <div class="input-group settings-input col-md-12 col-sm-12">
                        <?=$this->Form->input('confirm_email', array('class' => 'form-control', 'label' => false, 'value' => ''))?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 n-padding">
            <div class="col-md-7 col-sm-7 col-xs-12">
                <div class="settings-input-row nbb clearfix mb100">
                    <div class="col-md-3 col-sm-3 col-xs-3 npl">
                        <button type="submit" class="btn btn-primary save-button"><?=__('Save')?></button>
                    </div>
                </div>
            </div>
        </div>
</div>
<?=$this->Form->end()?>
<script type="text/javascript">
function updateSave() {
	var enabled = $('#UserUsername').val() && $('#UserUsername').val() === $('#UserConfirmEmail').val();
	$('.save-button').prop('disabled', !enabled);
	$('.save-button').removeClass('disabled');
	if (!enabled) {
		$('.save-button').addClass('disabled');
	}
}

$(document).ready(function(){
	$('#UserUsername, #UserConfirmEmail').keyup(function(){
		updateSave();
	});
	
	$('.save-button').click(function(){
		updateSave();
		return !$('.save-button').prop('disabled');
	});
	updateSave();
});
</script>