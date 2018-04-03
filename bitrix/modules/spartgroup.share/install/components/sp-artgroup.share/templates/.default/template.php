<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<div class="share_box share_<?=$arParams['SHOW']?>">
    <div
        class="yashare-auto-init"
        data-yashareL10n="ru"
        data-yashareType="<?=$arParams['SHOW']?>"
        data-yashareQuickServices="<? for($i=0; $i < count($arParams['SERVICES']); ++$i){ echo $arParams['SERVICES'][$i];if(($i+1) != count($arParams['SERVICES']))echo ','; }?>"
        <?=($arParams['SHOW'] == 'small')?' data-yashareTheme="counter"':''?>
        >
    </div>
</div>