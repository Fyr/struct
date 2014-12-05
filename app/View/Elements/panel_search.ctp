<div class="searchBlock clearfix">
	<form id="searchUserForm" action="" method="post">
        <input class="searchInput" type="text" name="data[q]" value="<?=$this->request->data('q')?>" placeholder="<?=__('Find user or community...')?>">
        <button type="submit" class="searchButton"><span class="glyphicons search"></span></button>
    </form>
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
				$src = $this->Media->imageUrl(Hash::get($user, 'UserMedia'), 'thumb50x50');
?>
        <li class="simple-list-item">
            <a href="<?=$this->Html->url(array('controller' => 'User', 'action' => 'view', $user['User']['id']))?>">
                <div class="user-list-item clearfix">
                    <div class="user-list-item-avatar rate-10"><img src="<?=$src?>" alt="<?=$name?>" style="width: 50px; height: 50px;" /></div>
                    <div class="user-list-item-body">
                        <div class="user-list-item-name"><?=$name?></div>
                        <div class="user-list-item-spec"><?=Hash::get($user, 'User.skills')?></div>
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
				$src = $this->Media->imageUrl(Hash::get($group, 'GroupMedia'), 'thumb50x50')
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
