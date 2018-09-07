<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="catalog">
    <div class="box">
        <hr class="catalog__hr">
        <div class="catalog__header">
          <?=$arResult['NAME']?>
        </div>
        <div class="news-box">
            <?foreach($arResult['ITEMS'] as $arItem):?>
            <a class="news-item" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                <?switch($arItem['PROPERTIES']['NEWS_TYPE']['VALUE_ENUM_ID']) {
                    case 1:
                        echo "<div class='action'>Акция</div>";
                        break;
                    case 2:
                        echo "<div class='discount'>Скидка</div>";
                        break;
                }?>
                <div class="news-item__img-wrapper">
                  <div class="news-item__img" style="background-image:url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>')"></div>
                  <span class="news-item__filter"></span>
                </div>
                <div class="news-item__text-box">
                    <div class="news-item__title">
                      <?$obParser = new CTextParser;?>
                      <?=$obParser->html_cut($arItem['NAME'], 38)?>
                    </div>
                    <div>
                      <?$obParser = new CTextParser;?>
                      <?=$obParser->html_cut($arItem['PREVIEW_TEXT'], 80)?>
                    </div>
                </div>
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
    <div class="box">
      <a class="btn-green-border" href="/">Назад</a>
    </div>
</section>
