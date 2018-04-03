<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="news">
    <div class="box">
        <div class="news__title">
                <span class="news__title-text">
                    Полезные статьи
                </span>
            <div class="news-slider__arrows">
                <div class="news-slider__prev">
                    <img class="news-slider__arrow-img" src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/arrow.png">
                </div>
                <div class="news-slider__next">
                    <img class="news-slider__arrow-img" src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/arrow.png">
                </div>
            </div>
            <div class="news__all">
                <a href="/news/?filter=articles" class="btn-green-border">Все статьи</a>
            </div>
        </div>
    </div>
    <div class="swiper-container news-slider">
        <div class="swiper-wrapper">
            <?foreach($arResult['ITEMS'] as $arItem):?>
            <a class="swiper-slide news-slider__slide" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                <div class="news-slider__img-wrapper">
                  <div class="news-slider__img" style="background-image:url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>')">
                  </div>
                  <span class="news-slider__filter"></span>
                </div>
                <div class="news-slider__text-box">
                    <div class="news-slider__title">
                        <?$obParser = new CTextParser;?>
                        <?=$obParser->html_cut($arItem['NAME'], 40)?>
                    </div>
                    <div class="news-slider__text">
                        <?=TruncateText($arItem['PREVIEW_TEXT'], 80)?>
                    </div>
                </div>
            </a>
            <?endforeach?>
        </div>

    </div>
    
</section>
