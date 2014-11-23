<li class="clearfix">
    <div class="col-md-3 col-sm-3 col-xs-12 name"><a href="<?=$this->Html->url(array('controller' => 'Project', 'action' => 'task', Hash::get($task, 'Task.id')))?>"><?=Hash::get($task, 'Task.title')?></a></div>
    <div class="col-md-9 col-sm-9 col-xs-12 description">
        <div class="col-md-9 col-sm-9 col-xs-9 name-user">
            <a href="<?=$this->Html->url(array('controller' => 'Profile', 'action' => 'view', $user['ChatUser']['id']))?>">
                <div class="user-avatar">
                    <span class="user-avatar rate-10"><img src="<?=$user['Avatar']['url']?>" alt="<?=$user['ChatUser']['name']?>"/></span>
                </div> <?=$user['ChatUser']['name']?>
            </a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3 deadline"><?=Hash::get($task, 'Task.deadline')?></div>
    </div>
</li>