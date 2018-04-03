<?
global $APPLICATION;
$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    Array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "DEPTH_LEVEL" => "8",
        "IBLOCK_ID" => "16",
        "IBLOCK_TYPE" => "catalog",
        "IS_SEF" => "Y",
    		"SECTION_PAGE_URL" => "/#SECTION_CODE#",
    		"SEF_BASE_URL" => "/catalog",
        "SECTION_URL" => ""
    )
);
$arResult = $aMenuLinksExt;
?>


<section class="catalog">
    <div class="box">
        <hr class="catalog__hr">
        <div class="catalog__header">
            Каталог
        </div>
        <div class="catalog-menu">



            <?
            // Формируем меню
            $arLayerElement = array();
            $empryLevel = array();
            $sectionItems = CIBlockSection::GetList(Array(), Array("IBLOCK_ID" => 16), true, Array("UF_LINK"));
            while($sectionItem = $sectionItems->GetNext()) {
              if ($sectionItem['ELEMENT_CNT'] == 0 && isset($sectionItem['UF_LINK'])) {
                $empryLevel[] = $sectionItem;
              }
            }
            $firstLevel = array();
            $parent = array();
            foreach($arResult as $arItem) {
                // check empry (9 this '/catalog/')
                if (substr($arItem[1], 9)) {

                }
                if ($arItem[3]['DEPTH_LEVEL'] == 1) {
                    $firstLevel[] = $arItem;
                }
                if ($arItem[3]['DEPTH_LEVEL'] > 1) {
                    $arLayerElement[$arItem[3]['DEPTH_LEVEL']]
                                   [$parent[$arItem[3]['DEPTH_LEVEL']][0]]
                                   ['array'][] = $arItem;
                    $arLayerElement[$arItem[3]['DEPTH_LEVEL']]
                                   [$parent[$arItem[3]['DEPTH_LEVEL']][0]]
                                   ['link'] = $parent[$arItem[3]['DEPTH_LEVEL']][1];
                }
                if ($arItem[3]['IS_PARENT']) {
                    $parent[$arItem[3]['DEPTH_LEVEL'] + 1] = $arItem;
                }
            }?>

            <div class="catalog-menu__layer-1 catalog-menu__layer">
                <?foreach($firstLevel as $element):?>
                    <a href="<?=$element[1]?>" class="catalog-menu__item">
                        <?=$element[0]?>
                    </a>
                <?endforeach?>
            </div>

            <?foreach($arLayerElement as $depth => $depth_elements):?>
                <?foreach($depth_elements as $name => $elements):?>
                    <div class="catalog-menu__layer" data-link="<?=$elements['link']?>">
                        <?$first = true?>
                        <?foreach($elements['array'] as $elKey => $element):?>
                            <?if($first):?>
                                <div class="catalog-menu__header">
                                  <?if ($depth > 1):?>
                                    <img class="catalog-menu__back" src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/back-button.svg" alt="" />
                                  <?endif?>
                                  <?=$name?>
                                </div>
                                <?$first = false; endif?>
                              <a href="<?=$element[1]?>" class="catalog-menu__item"><?=$element[0]?></a>
                        <?endforeach?>
                    </div>
                <?endforeach?>
            <?endforeach?>

            <?foreach ($empryLevel as $empryItem):?>
            <div class="catalog-menu__layer catalog-menu__pp" data-link="/catalog/<?=$empryItem['CODE']?>">
              <div class="catalog-menu__header">
                  <img class="catalog-menu__back" src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/back-button.svg" alt="" />
                  <?=$empryItem['NAME']?>
              </div>
              <img class="catalog-menu__pp-img" src="<? echo CFile::GetPath($empryItem['PICTURE']);?>" alt="" />
              <p class="catalog-menu__pp-text">
                <?=$empryItem['DESCRIPTION']?>
              </p>
              <a target="_blank" href="<?=$empryItem['UF_LINK']?>" class="btn-green-border" style="width: 180px">
                Смотреть каталог
              </a>
            </div>
            <?endforeach?>

        </div>
    </div>
</section>
