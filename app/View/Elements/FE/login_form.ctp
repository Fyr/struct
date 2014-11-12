<?=$this->Form->create('User', array('url' => array('controller' => 'Users', 'action' => 'login'), 'class' => 'form', 'id' => 'loginForm'))?>
    <div class="input-box-item">
    	<?=$this->Form->input('username', array('label' => false, 'placeholder' => __('Email')))?>
    </div>
    <div class="input-box-item">
        <?=$this->Form->input('password', array('label' => false, 'placeholder' => __('Password')))?>
        <div class="error-message"><?=(isset($authError) && $authError) ? $authError : ''?></div>
    </div>
    <div class="login-box">
        <a class="enter-link" href="javascript:void(0);" onclick="$('#loginForm').submit()"><span class="halflings log_in"></span><?=__('Log In')?></a>
        <a class="func-link fright" href="#"><?=__('Password Reminder')?></a>
    </div>
<?=$this->Form->end()?>
