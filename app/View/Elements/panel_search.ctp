<div class="searchBlock clearfix">
        <input class="searchInput" type="text" value="<?=$this->request->data('q')?>" placeholder="<?=__('Find user or community...')?>">
        <button type="button" class="searchButton"><span class="glyphicons search"></span></button>
</div>
<div class="dropdown-panel-scroll">
<?
	if ((isset($aUsers) && $aUsers) || (isset($aGroups) && $aGroups)) {
?>
    <ul class="search-list-user">
<?
		if (isset($aUsers) && $aUsers) {
			foreach($aUsers as $user) {
				$name = Hash::get($user, 'User.full_name');
?>
        <li class="simple-list-item">
            <a href="<?=$this->Html->url(array('controller' => 'Profile', 'action' => 'view', $user['User']['id']))?>">
                <div class="user-list-item clearfix">
                    <div class="user-list-item-avatar rate-10"><img src="<?=$user['Media']['url_img']?>" alt="<?=$name?>" style="width: 50px; height: auto;" /></div>
                    <div class="user-list-item-body">
                        <div class="user-list-item-name"><?=$name?></div>
                        <div class="user-list-item-spec"><?=Hash::get($user, 'Profile.skills')?></div>
                    </div>
                </div>
            </a>
        </li>
<?
			}
		}
		if (isset($aGroups) && $aGroups) {
			foreach($aGroups as $group) {
				$name = Hash::get($group, 'Group.title');
				$src = $this->Media->imageUrl($group, 'thumb50x50');
				if (!$src) {
					$src = '/img/group-create-pl-image.jpg';
				}
?>
        <li class="simple-list-item">
            <a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'view', $group['Group']['id']))?>">
                <div class="user-list-item clearfix">
                    <div class="user-list-item-avatar rate-10"><img src="<?=$src?>" alt="<?=$name?>" style="width: 50px; height: auto;" /></div>
                    <div class="user-list-item-body">
                        <div class="user-list-item-name"><?=$name?></div>
                        <div class="user-list-item-spec"><!--0 members--></div>
                    </div>
                </div>
            </a>
        </li>
<?
			}
		}
		
?>
    </ul>
<?
	} else {
?>
	<ul class="search-list-user">
		<li class="simple-list-item">
			<div style="margin-left: 10px;">
				<?=__('No item found');?>
			</div>
		</li>
	</ul>
<?
	}
?>
</div>
