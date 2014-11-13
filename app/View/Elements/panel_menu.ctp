<div class="main-panel-before"></div>
<div class="main-panel">
    <div class="main-panel-dropdown">
        <?=$this->element('panels')?>
    </div>
    <div class="main-panel-block">
        <div class="main-panel-wrapper">
            <div class="user-image">
                <a id="user<?=$currUser['ChatUser']['id']?>" href="#"><img src="<?=$currUser['Avatar']['url']?>" alt="<?=$currUser['ChatUser']['name']?>" style="width: 90px;"/></a>
            </div>
            <?=$this->element('panel_icons')?>
        </div>
    </div>
</div>