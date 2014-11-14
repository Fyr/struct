            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 mutant-title">
					<div class="col-md-12 col-sm-12 col-xs-12 mutant-title">
	                    <div class="col-md-9 col-sm-9 col-xs-9">
	                        <div class="page-title"><?=Hash::get($user, 'ChatUser.name')?></div>
	                        <div class="user-spec col-md-6 col-sm-6 col-xs-6"><?=Hash::get($user, 'Profile.skills')?></div>
	                        <div class="col-md-6 col-sm-6 col-xs-6">
		                        <div class="user-adress">
		                            <div class="fs15"><?=Hash::get($user, 'Profile.live_place')?></div>
		                            <div class="fs13 text-grey"></div>
		                            <div class="fs15 mt10"><?=Hash::get($user, 'Profile.birthday');?></div>
		                        </div>
	                    	</div>
	                        
	                	</div>
		                <div class="col-md-3 col-sm-3 col-xs-3">
		                    <div class="user-avatar taright">
<?
	$src = (Hash::get($user, 'Media.id')) ? $this->Media->imageUrl($user, 'thumb150x150') : '/img/no-photo.jpg';
?>
		                        <img style="width: 150px" src="<?=$src?>" alt="<?=Hash::get($user, 'ChatUser.username')?>" />
		                    </div>
		                </div>
            		</div>
            	</div>
            </div>
