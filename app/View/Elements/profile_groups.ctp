<?
	$title = Hash::get($group, 'Group.title');
	$src = $this->Media->imageUrl($group['GroupMedia'], 'thumb50x50');
	$class = ($hide) ? 'can-hide' : '';
	$style = ($hide) ? 'style="display: none"' : ''
?>
<div class="news-article group-type <?=$class?>" <?=$style?>>
    <a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'view', Hash::get($group, 'Group.id')))?>">
        <div class="news-article-title">
            <?=($currUserID == Hash::get($group, 'Group.owner_id')) ? __('Administrator') : Hash::get($group, 'GroupMember.role')?>
        </div>
        <div class="news-article-title subtitle clearfix">
            <div class="subtitle-image">
                <img src="<?=$src?>" alt="<?=$title?>" style="width: 50px" />
            </div>
            <div class="subtitle-body">
                <?=$title?>
                <div class="subtitle-body-info ">
                    1 <?=__('Members')?>
                </div>
            </div>
        </div>
	    <div class="news-article-pubdate">
	        <?=Hash::get($group, 'Group.descr')?>
	    </div>
    </a>
</div>