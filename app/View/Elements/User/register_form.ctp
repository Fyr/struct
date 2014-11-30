<?=$this->Form->create('User', array('url' => array('controller' => 'User', 'action' => 'register'), 'class' => 'form', 'id' => 'registerForm'))?>
    <div class="input-box-item">
        <?=$this->Form->input('username', array('label' => false, 'placeholder' => 'Email'))?>
    </div>
    <div class="input-box-item">
    	<?=$this->Form->input('password', array('label' => false, 'placeholder' => 'Password', 'required' => true))?>
    </div>
    <div class="login-box">
        <label for="terms-of-use" class="terms-of-use">
            <span class="glyphicons ok_2"></span>
            <input id="terms-of-use" type="checkbox">
            <span>I agree to</span>
        </label>
        <a class="terms-link" href="http://54.68.18.45/terms.pdf" target="_blank">Terms of Use</a>
        <br>
        <a class="enter-link" href="javascript:void(0);" onclick="if ($('label.terms-of-use').hasClass('checkedIn')) { $('#registerForm').submit(); }">
            <span class="halflings log_in"></span> Register
        </a>
    </div>
<?=$this->Form->end()?>