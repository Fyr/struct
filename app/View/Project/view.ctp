<?
	$projectID = Hash::get($project, 'Project.id');
?>
<div class="row header-project-page clearfix">
    <div class="project-page-title col-md-4 col-sm-12 col-xs-12"><?=Hash::get($project, 'Project.title')?></div>
    <div class="title-button page-menu col-md-8 col-sm-12 col-xs-12 clearfix">
    	<a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'view', Hash::get($project, 'Project.group_id')))?>" class="btn btn-default"><span class="glyphicons parents"></span></a>
        <a class="btn btn-default" href="#"><span class="glyphicons coins"></span></a>
        <a class="btn btn-default" href="#"><span class="glyphicons pause"></span></a>
        <a class="btn btn-default" href="#">Завершить</a>
        <a class="btn btn-default wrench" href="<?=$this->Html->url(array('controller' => 'Project', 'action' => 'edit', $projectID))?>"><span class="glyphicons wrench"></span></a>
    </div>
</div>
<div class="row description-project-page clearfix">
    <div class="col-md-9 col-sm-9 col-xs-12 text-description">
        <p><?=Hash::get($project, 'Project.descr')?></p>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 deadline-date">
        <div class="date">
            <span class="glyphicons anchor"></span>
            <?=__('Deadline')?>
            <div class="input-calendar">
                <input data-format="dd/MM" class="datetimepicker" value="" type="text"/>
            </div>
        </div>
    </div>
</div>
<div class="row project-timeline clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12 project-timeline-list">
        <div class="title-list">
            <span class="glyphicons clock"></span>
           <?=__('Last updates')?>
        </div>
        <ul class="list-timeline">
            <li class="clearfix">
                <div class="time col-md-3 col-sm-3 col-xs-12">10 октября, 15:33</div>
                <div class="timeline-text col-md-9 col-sm-9 col-xs-12">
                    <a href="#" class="user-link">
                    <span class="user-avatar rate-0"><img src="/img/temp/smallava.jpg" alt=""/></span>
                    Альберт Леманн
                    </a> <a href="#">прокомментировал</a> в «Главная страница»
                </div>
            </li>
            <li class="clearfix">
                <div class="time col-md-3 col-sm-3 col-xs-12">10 октября, 9:47</div>
                <div class="timeline-text col-md-9 col-sm-9 col-xs-12">
                    <a href="#" class="user-link">
                    <span class="user-avatar rate-10"><img src="/img/temp/mava.jpg" alt=""/></span>
                    Дмитрий Перековский
                    </a> создал новую задачу <a href="#">«Страница пользователя»</a>
                </div>
            </li>
            <li class="clearfix">
                <div class="time col-md-3 col-sm-3 col-xs-12">9 октября, 14:59</div>
                <div class="timeline-text col-md-9 col-sm-9 col-xs-12">
                    <a href="#" class="user-link">
                    <span class="user-avatar rate-0"><img src="/img/temp/smallava.jpg" alt=""/></span>
                    Лия Усманова
                    </a> закрыла задачу <a href="#">«Статистика»</a>
                </div>
            </li>
            <li class="clearfix">
                <div class="time col-md-3 col-sm-3 col-xs-12">1 октября, 11:26</div>
                <div class="timeline-text col-md-9 col-sm-9 col-xs-12">
                    <a href="#" class="user-link">
                    <span class="user-avatar rate-10"><img src="/img/temp/mava.jpg" alt=""/></span>
                    Евгений Николаев
                    </a>создал новую задачу <a href="#">«Облачное хранилище»</a>
                </div>
            </li>
            <li class="clearfix">
                <div class="time col-md-3 col-sm-3 col-xs-12">29 сентября, 21:12</div>
                <div class="timeline-text col-md-9 col-sm-9 col-xs-12">
                    <a href="#" class="user-link">
                        <span class="user-avatar rate-10"><img src="/img/temp/smallava.jpg" alt=""/></span>
                        Альберт Леманн
                    </a> закрыл задачу <a href="#">«Группы и сообщества»</a>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="row under-project">
    <div class="page-menu new-under-project">
        <a href="javascript:void(0)" class="btn btn-default new-under-project-btn">Новый подпроект</a>
    </div>
<?
	foreach($aSubprojects as $subproject) {
		$subprojectID = Hash::get($subproject, 'Subproject.id')
?>
    <div class="under-project-cell clearfix">
        <div class="cell-title clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 title-under-project"><?=Hash::get($subproject, 'Subproject.title')?></div>
            <div class="col-md-9 col-sm-9 col-xs-12 sub-title">
                <div class="col-md-9 col-sm-9 col-xs-9 sub-title-label"><?=__('Assigned')?></div>
                <div class="col-md-3 col-sm-3 col-xs-3 sub-title-label"><span class="glyphicons anchor"></span><?=__('Deadline')?></div>
            </div>
        </div>
        <ul class="cell-list">
<?
		$openTasks = 0;
		$closedTasks = 0;
		if (isset($aTasks[$subprojectID]) && ($tasks = $aTasks[$subprojectID])) {
			foreach($tasks as $taskID => $task) {
				if (!$task['Task']['closed']) {
					$user = $aUsers[$task['Task']['user_id']];
					$openTasks++;
					echo $this->element('project_tasks', compact('task', 'user'));
				} else {
					$closedTasks++;
				}
			}
		}
		if (!$openTasks) {
?>
			<li class="clearfix"><?=__('No open tasks')?></li>
<?
		}
?>
        </ul>
        <div class="page-menu new-task">
            <a href="#" class="add-new-task-project" onclick="addNewTask(<?=$subprojectID?>)">
                <button class="btn btn-default"><span class="glyphicons plus"></span></button>
                <?=__('New task')?>
            </a>
        </div>
<?
	if ($closedTasks) {
?>
        <div class="end-under-project-list">
            <div class="title-end-under-project">
                <span><?=__('Closed tasks')?></span>
            </div>
            <div class="end-under-project-block">
                <div class="under-project-cell">
                    <ul class="cell-list">
<?
		if (isset($aTasks[$subprojectID]) && ($tasks = $aTasks[$subprojectID])) {
			foreach($tasks as $taskID => $task) {
				if ($task['Task']['closed']) {
					$user = $aUsers[$task['Task']['user_id']];
					echo $this->element('project_tasks', compact('task', 'user'));
				}
			}
		}
?>
                    </ul>
                </div>
            </div>
        </div>
<?
	}
?>
    </div>
<?
	} // $aSubproject
?>
</div>

<div class="drop-add-sub-project popup-block">
    <div class="close-block glyphicons circle_remove"></div>
    <?=$this->Form->create('Subproject', array('url' => array('controller' => 'Project', 'action' => 'addSubproject')))?>
        <!--label for="drop-add-sub-project-1">Название подпроекта</label>
        <input id="drop-add-sub-project-1" type="text"/-->
        <?=$this->Form->hidden('project_id', array('value' => $projectID))?>
        <?=$this->Form->input('title')?>
        <div class="page-menu clearfix">
            <button type="submit" class="btn btn-default"><?=__('Add subproject')?></button>
        </div>
    <?=$this->Form->end()?>
</div>

<div class="drop-add-sub-project-user popup-block">
    <div class="close-block glyphicons circle_remove"></div>
    <?=$this->Form->create('Task', array('url' => array('controller' => 'Project', 'action' => 'addTask', $projectID)))?>
    	<?=$this->Form->hidden('creator_id', array('value' => $currUserID))?>
    	<?=$this->Form->hidden('subproject_id')?>
        <?=$this->Form->input('title')?>
        <?=$this->Form->input('deadline', array('type' => 'text', 'class' => 'datetimepicker', 'data-date-format' => 'YYYY-MM-DD'))?>
        <label><?=__('Manager')?></label>
        <?=$this->Form->input('manager_id', array('options' => $aMemberOptions, 'class' => 'formstyler', 'label' => false))?>
        <label><?=__('Assignee')?></label>
        <?=$this->Form->input('user_id', array('options' => $aMemberOptions, 'class' => 'formstyler', 'label' => false))?>
        <?=$this->Form->input('descr', array('label' => array('text' => __('Description'))))?>
        <div class="page-menu clearfix">
            <button type="submit" class="btn btn-default"><?=__('Add task')?></button>
        </div>
    <?=$this->Form->end()?>
</div>

<script type="text/javascript">
function addNewTask(subprojectID) {
	$('.popup-block').hide();
	$('.drop-add-sub-project-user').show();
	$('#TaskSubprojectId').val(subprojectID);
}

$(document).ready(function(){
    $('.new-under-project-btn').on('click', function(){
        $('.popup-block').hide();
        $('.drop-add-sub-project').show();
    });
    $('.popup-block .close-block, .popup-block .close-block').on('click', function(){
        $('.popup-block').hide();
    });
});

</script>