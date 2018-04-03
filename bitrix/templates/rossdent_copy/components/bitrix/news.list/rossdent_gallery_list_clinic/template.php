
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<section class="catalog clinic_moment">
    <div>
        <hr class="catalog__hr">
        <div class="catalog__header">
          Клинические случаи
        </div>


                <div class="gallery__items">
                 <?foreach($arResult["ITEMS"] as $arItem):?>
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="gallery__item">
                   <div style="background-image:url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')" class="gallery__img"></div>
                    <div class="gallery__title">
                        <?=TruncateText($arItem["NAME"], 45)?>
                    </div>
                   <?if(strlen($arItem['PROPERTIES']['MEDIA_CLINIC_VIDEO']['VALUE'])>0):?>
                        <div class="gallery__info" style="background-image: url('/bitrix/templates/rossdent/img/play.png')">
                       <?$time = $arItem['PROPERTIES']['MEDIA_CLINIC_VIDEO_TIME']['VALUE']?>
                            <?=floor($time/60)?>:<?=($time%60)?>
                        </div>
                   <?else:?>
                     <div class="gallery__info" style="background-image: url('/bitrix/templates/rossdent/img/photo.png')">
                            Фотографий: <?=count($arItem['PROPERTIES']['MEDIA_CLINIC_PICTURES']['VALUE'])?>
                        </div>
                   <?endif?>
                 </a>
                <?endforeach?>
              </div>

        <?$arNav = $arResult['NAV_RESULT']?>
        <div class="pagination">
            <div class="pagination__bg">
                <?if($arNav->NavPageCount > 1): // Need show pagination? ?>

                    <?if($arNav->NavPageCount > 5): // Need show pagination with '...'? ?>
                        <?if ($arNav->NavPageNomer > $arNav->nStartPage):?>
                            <a href="?PAGEN_1=<?=$arNav->NavPageNomer - 1?>"
                               class="pagination__item pagination__item--act"><</a>
                        <?endif?>
                        <?if($arNav->NavPageNomer < 3 || $arNav->NavPageCount - $arNav->NavPageNomer < 3):?>
                            <a href="?PAGEN_1=1"
                               class="pagination__item <?if($arNav->NavPageNomer == '1') echo "pagination__item--act"?>">1</a>
                            <a href="?PAGEN_1=2"
                               class="pagination__item <?if($arNav->NavPageNomer == '2') echo "pagination__item--act"?>">2</a>
                            <a href="?PAGEN_1=3"
                               class="pagination__item <?if($arNav->NavPageNomer == '3') echo "pagination__item--act"?>">3</a>
                            <a class="pagination__item">...</a>
                            <a href="?PAGEN_1=<?=$arNav->NavPageCount - 2?>"
                               class="pagination__item <?if($arNav->NavPageNomer == ($arNav->NavPageCount - 2)) echo "pagination__item--act"?>"><?=$arNav->NavPageCount - 2?></a>
                            <a href="?PAGEN_1=<?=$arNav->NavPageCount - 1?>"
                               class="pagination__item <?if($arNav->NavPageNomer == ($arNav->NavPageCount - 1)) echo "pagination__item--act"?>"><?=$arNav->NavPageCount - 1?></a>
                            <a href="?PAGEN_1=<?=$arNav->NavPageCount?>"
                               class="pagination__item <?if($arNav->NavPageNomer == ($arNav->NavPageCount)) echo "pagination__item--act"?>"><?=$arNav->NavPageCount?></a>
                        <?else:?>
                            <a class="pagination__item">...</a>
                            <a href="?PAGEN_1=<?=$arNav->NavPageNomer - 1?>"
                               class="pagination__item <?if($arNav->NavPageNomer == ($arNav->NavPageNomer - 1)) echo "pagination__item--act"?>"><?=$arNav->NavPageNomer - 1?></a>
                            <a href="?PAGEN_1=<?=$arNav->NavPageNomer?>"
                               class="pagination__item <?if($arNav->NavPageNomer == ($arNav->NavPageNomer)) echo "pagination__item--act"?>"><?=$arNav->NavPageNomer?></a>
                            <a href="?PAGEN_1=<?=$arNav->NavPageNomer + 1?>"
                               class="pagination__item <?if($arNav->NavPageNomer == ($arNav->NavPageNomer + 1)) echo "pagination__item--act"?>"><?=$arNav->NavPageNomer + 1?></a>
                            <a class="pagination__item">...</a>
                        <?endif;?>
                        <?if ($arNav->NavPageCount > $arNav->NavPageNomer):?>
                            <a href="?PAGEN_1=<?=$arNav->NavPageNomer + 1?>"
                               class="pagination__item pagination__item--act">></a>
                        <?endif?>
                    <?else:?>
                        <?while ($arNav->nStartPage <= $arNav->NavPageCount):?>
                            <a href="?PAGEN_1=<?=$arNav->nStartPage?>" class="pagination__item <?if($arNav->NavPageNomer == $arNav->nStartPage) echo "pagination__item--act"?>"><?=$arNav->nStartPage?></a>
                            <?$arNav->nStartPage++?>
                        <?endwhile?>
                    <?endif?>


                <?endif?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</section>
