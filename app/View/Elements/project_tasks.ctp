<li class="clearfix">
    <div class="col-md-3 col-sm-3 col-xs-12 name"><a href="<?=$this->Html->url(array('controller' => 'Project', 'action' => 'task', Hash::get($task, 'Task.id')))?>"><?=Hash::get($task, 'Task.title')?></a></div>
    <div class="col-md-9 col-sm-9 col-xs-12 description">
        <div class="col-md-9 col-sm-9 col-xs-9 name-user">
            <a href="<?=$this->Html->url(array('controller' => 'User', 'action' => 'view', $user['User']['id']))?>">
                <div class="user-avatar">
                    <span class="user-avatar rate-10"><img src="<?=$user['UserMedia']['url_img']?>" alt="<?=$user['User']['full_name']?>"/></span>
                </div> <?=$user['User']['full_name']?>
            </a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3 deadline"><?=$this->Localdate->date(Hash::get($task, 'Task.deadline'))?></div>
    </div>
</li>