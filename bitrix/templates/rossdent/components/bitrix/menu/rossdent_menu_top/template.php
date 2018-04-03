<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div>
    <ul id="nav" class="menu__items_top-box">
    <? foreach($arResult as $arItem):?>
        <?if($arItem['DEPTH_LEVEL'] == 1):?>
            <li><a href="<?=$arItem['LINK']?>" class="menu__item_top <?if($arItem['SELECTED']):?>active<?endif;?>"><?=$arItem['TEXT']?></a></li>
        <?endif;?>
    <?endforeach?>
        <li class="more"> <span>Ещё <img src="/bitrix/templates/rossdent/img/arrow-down.png"></span>
            <ul id="overflow">
            </ul>
        </li>
    </ul>

    <div class="menu-clear-left"></div>
</div>
<?endif?>