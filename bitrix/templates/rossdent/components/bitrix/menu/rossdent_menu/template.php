<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="menu__items-box">
            <?
            $previousLevel = 0;
            foreach($arResult as $arItem):?>
                <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                    <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
                <?endif?>
                <?if ($arItem["IS_PARENT"]):?>
                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <div class="sub-menu"><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>menu__item--active menu__item<?else:?>menu__item<?endif?>"><img class="menu__item-img" src="<?=$arItem['PARAMS']['LNK_IMG']?>"><span class="menu__item-text"><?=$arItem["TEXT"]?></span></a><a href="#" class="toggle-submenu"><img src="/images/toggle-img.png" alt=""></a><ul>
                    <?else:?>
                        <div class="sub-menu"<?if ($arItem["SELECTED"]):?> class="menu__item--active menu__item"<?endif?>><a href="<?=$arItem["LINK"]?>" class="parent"><img class="menu__item-img" src="<?=$arItem['PARAMS']['LNK_IMG']?>"><span class="menu__item-text"><?=$arItem["TEXT"]?></span></a><a href="#" class="toggle-submenu"><img src="/images/toggle-img.png" alt=""></a><ul>
                    <?endif?>
                <?else:?>
                    <?if ($arItem["PERMISSION"] > "D"):?>
                        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                            <a href="<?=($arItem["LINK"] == '/catalog/brands') ? '/brands/' : $arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>menu__item--active menu__item<?else:?>menu__item<?endif?>"><img class="menu__item-img" src="<?=$arItem['PARAMS']['LNK_IMG']?>"><span class="menu__item-text"><?=$arItem["TEXT"]?></span></a>
                        <?else:?>
                            <a href="<?=($arItem["LINK"] == '/catalog/brands') ? '/brands/' : $arItem["LINK"]?>" class=" menu__item"><span class="menu__item-text"><?=$arItem["TEXT"]?></span></a>
                        <?endif?>
                    <?else:?>
                        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                            <li><a href="" class="test <?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><span><?=$arItem["TEXT"]?></span></a></li>
                        <?else:?>
                            <li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><span><?=$arItem["TEXT"]?></span></a></li>
                        <?endif?>
                    <?endif?>
                <?endif?>
                <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
            <?endforeach?>
            <?if ($previousLevel > 1)://close last item tags?>
                <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
            <?endif?>
        </ul>
    </div>
<div class="menu-clear-left"></div>
<?endif?>