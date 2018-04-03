<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<section class="catalog bg-white about-reviews schedule-near">
    <div>
        <hr class="catalog__hr">
        <div class="catalog__header">
           Ближайшие курсы
           <div class="news__all">
            <a href="/courses/schedule/" class="btn-green-border">Все курсы</a>
        </div>
    </div>
    <div class="about-reviews-box">
        <?foreach($arResult['ITEMS'] as $arItem):?>
        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="review">
            <div class="review__img" style="background-image:url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>')"></div>
            <div class="review__box">
                <div class="review__name">
                    <?$obParser = new CTextParser;?>
                        <?=$obParser->html_cut($arItem['NAME'], 40)?>
                </div>
                <div class="review__lector">
                    <span>Лектор:</span>
                    <?=$arItem['DISPLAY_PROPERTIES']['LESSON_TEACHER']['VALUE']?>
                </div>
                <div class="review__data">
                    <?=$arItem['DISPLAY_PROPERTIES']['LESSON_DATE']['VALUE']?>
                </div>
            </div>
        </a>
        <?endforeach?>
    </div>
</div>
</section>