<div class="row">
    <div class="col-md-4">
        <a href="/" class="logo-company">
            <img class="logo-image" src="/img/logo.png" alt=""><br>
            <span class="logo-text">Creative Environment</span>
        </a>
    </div>
    <div class="col-md-6 col-md-offset-2">
		<div class="row" id="login_form_block">
		    <div class="col-md-4 func-link-box">
		        <a class="func-link" href="javascript:void(0);" onclick="switchIndexForms();">Register</a>
		    </div>
		    <div class="col-md-7 col-md-offset-1">
		        <div class="input-box">
		            <div class="form">
		                <?=$this->element('FE/login_form')?>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="row" id="register_form_block" style="display: none;">
		    <div class="col-md-4 func-link-box">
		        <a class="func-link" href="javascript:void(0);" onclick="switchIndexForms();">Sign In</a>
		    </div>
		    <div class="col-md-7 col-md-offset-1">
		        <div class="input-box">
		            <div class="form">
		            	<?=$this->element('FE/register_form')?>
		            </div>
		        </div>
		    </div>
		</div> 
    </div>
</div>