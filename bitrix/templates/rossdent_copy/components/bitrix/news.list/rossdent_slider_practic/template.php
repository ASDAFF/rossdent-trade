<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="swiper-container index-slider">
    <div class="swiper-wrapper">
        <?foreach($arResult['ITEMS'] as $arItem):?>
        <div class="swiper-slide index-slider__slide" >
           
    
                
                    <a href="<?=$arItem['DISPLAY_PROPERTIES']['SLIDER_LINK_PC']['VALUE']?>"  >
                        <img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" style="width: 100%;">
                    </a>
                
                <div class="index-slider__next"></div>
                <div class="index-slider__prev"></div>
        
        </div>
        <?endforeach?>
    </div>
</section>