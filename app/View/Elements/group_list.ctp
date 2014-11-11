<ul class="group-list">
<?
	foreach($aGroups as $group) {
		$name = $group['Group']['title'];
		$url = $this->Html->url(array('controller' => 'Group', 'action' => 'view', $group['Group']['id']));
		$src = $this->Media->imageUrl($group, 'thumb50x50');
?>
    <li class="simple-list-item">
        <a href="<?=$url?>">
            <div class="user-list-item clearfix">
                <div class="user-list-item-avatar rate-10"><img src="<?=($src) ? $src : '/img/group-create-pl-image.jpg'?>" alt="<?=$name?>" style="width: 50px;" /></div>
                <div class="user-list-item-body">
                    <div class="user-list-item-name"><?=$name?></div>
                    <div class="user-list-item-spec"><!--0 <?=__('Members')?>--></div>
                </div>
            </div>
        </a>
    </li>
<?
	}
?>
</ul>