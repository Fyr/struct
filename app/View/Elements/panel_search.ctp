<div class="searchBlock clearfix">
    <form action="#">
        <input class="searchInput" type="text" value="<?=$this->request->data('q')?>" placeholder="<?=__('Find user or community...')?>">
        <button class="searchButton"><span class="glyphicons search"></span></button>
    </form>
</div>
<div class="dropdown-panel-scroll">
<?
	if ($aUsers) {
?>
    <ul class="search-list-user">
<?
		foreach($aUsers as $user) {
			$name = Hash::get($user, 'ChatUser.name');
?>
        <li class="simple-list-item">
            <a href="<?=$this->Html->url(array('controller' => 'Profile', 'action' => 'view', $user['ChatUser']['id']))?>">
                <div class="user-list-item clearfix">
                    <div class="user-list-item-avatar rate-10"><img src="<?=$user['Avatar']['url']?>" alt="<?=$name?>" style="width: 50px; height: auto;" /></div>
                    <div class="user-list-item-body">
                        <div class="user-list-item-name"><?=$name?></div>
                        <div class="user-list-item-spec"><?=Hash::get($user, 'Profile.skills')?></div>
                    </div>
                </div>
            </a>
        </li>
<?
		}
?>
    </ul>
<?
	} else {
?>
	<ul class="search-list-user">
		<li class="simple-list-item">
			<div style="margin-left: 10px;">
				<?=__('No user found');?>
			</div>
		</li>
	</ul>
<?
	}
?>
</div>
