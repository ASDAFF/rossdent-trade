<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="swiper-container index-slider">
    <div class="swiper-wrapper">
        <?foreach($arResult['ITEMS'] as $arItem):?>
        <div class="swiper-slide index-slider__slide" style="background-image: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>')">
            <?if(!empty($arItem['PROPERTIES']['SLIDER_MOBILE_IMG']['VALUE'])):?>
            <div class="index-slider__slide-mobile" style="background-image:url('<?=CFile::GetPath($arItem['PROPERTIES']['SLIDER_MOBILE_IMG']['VALUE'])?>')"></div>
            <?endif?>
            <div class="box">
                <div class="index-slider__content">
                    <hr class="index-slider__hr">
                    <div class="index-slider__title">
                        <?=$arItem['NAME']?>
                    </div>
                    <div class="index-slider__text">
                        <?=$arItem['PREVIEW_TEXT']?>
                    </div>
                    <a href="<?=$arItem['DISPLAY_PROPERTIES']['SLIDER_LINK']['VALUE']?>" class="btn-green">
                        <?=$arItem['DISPLAY_PROPERTIES']['SLIDER_BTN_TEXT']['VALUE']?>
                    </a>
                </div>
                <div class="index-slider__next"></div>
                <div class="index-slider__prev"></div>
            </div>
        </div>

        <?endforeach?>
    </div>
    <div class="box">
        <div class="swiper-pagination index-slider__pagination"></div>
    </div>

</section>
