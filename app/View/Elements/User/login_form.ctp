<?=$this->Form->create('User', array('url' => array('controller' => 'User', 'action' => 'login'), 'class' => 'form', 'id' => 'loginForm'))?>
    <div class="input-box-item">
    	<?=$this->Form->input('username', array('label' => false, 'placeholder' => 'Email'))?>
    </div>
    <div class="input-box-item">
        <?=$this->Form->input('password', array('label' => false, 'placeholder' => 'Password'))?>
<?
	$error = $this->Session->flash('auth');
	if ($error) {
?>
	<div class="error-message"><?=$error?></div>
<?
	}
?>
    </div>
    <div class="login-box">
        <button type="submit" class="enter-link"><span class="halflings log_in"></span>Log In</button>
        <a class="func-link fright" href="#">Password Reminder</a>
    </div>
<?=$this->Form->end()?>
