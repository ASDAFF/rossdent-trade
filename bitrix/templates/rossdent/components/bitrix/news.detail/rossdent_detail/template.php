<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="catalog news-detail">
    <div class="box">
        <hr class="catalog__hr">
        <div class="catalog__header">
            <?=$arResult['NAME']?>
        </div>
        <div class="catalog__header-date">
          <?if(!empty($arResult['SHOW_COUNTER'])) echo "Просмотров: ", $arResult['SHOW_COUNTER'];?>
          <?//=$arResult['TIMESTAMP_X']?>
        </div>
    </div>
</section>

<?if (isset($arResult['PROPERTIES']['NEWS_SLIDER_IMGS']['VALUE']) &&
      $arResult['PROPERTIES']['NEWS_SLIDER_IMGS']['VALUE'] == true):?>
<?$imgs = $arResult['PROPERTIES']['NEWS_SLIDER_IMGS']['VALUE'];?>


      <section class="swiper-container index-slider">
          <div class="swiper-wrapper">
              <?foreach($imgs as $imgKey => $imgItem):?>
              <?$img = CFile::GetPath($imgItem);?>
              <div class="swiper-slide index-slider__slide" style="background-image: url('<?=$img?>')">
                  <div class="box">
                      <div class="index-slider__content">
                        <hr class="index-slider__hr">
                        <div class="index-slider__title">
                            <?=$arResult['PROPERTIES']['NEWS_SLIDER_TITLES']['VALUE'][$imgKey]?>
                        </div>
                        <div class="index-slider__text">
                            <?=$arResult['PROPERTIES']['NEWS_SLIDER_TEXTS']['VALUE'][$imgKey]['TEXT']?>
                        </div>
                        <div class="index-slider__next"></div>
                        <div class="index-slider__prev"></div>
                      </div>
                  </div>
              </div>
              <?endforeach?>
          </div>
          <div class="box">
              <div class="swiper-pagination index-slider__pagination"></div>
          </div>
      </section>
      <br>
      <br>
      <br>
<section class="news-text">
    <div class="box">
        <div class="news-text__wrapper">
            <?=$arResult['DETAIL_TEXT']?>
        </div>
        <a class="news-text__show-all js-show-more-text">Показать полное описание</a>
        <a href="<?=$arParams['IBLOCK_URL']?>" class="btn-green-border">К списку</a>
    </div>
</section>

<?else:?>

<section class="news-text">
    <div class="box">
      <?if($arResult['DETAIL_PICTURE']['WIDTH'] > 1200):?>
        <img class="news-text__img news-text__img--big" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
        <div class="news-text__wrapper">
          <?=$arResult['DETAIL_TEXT']?>
      <?else:?>
        <div class="news-text__wrapper">
          <img class="news-text__img" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
          <?=$arResult['DETAIL_TEXT']?>
      <?endif?>
        </div>
        <a class="news-text__show-all js-show-more-text">Показать полное описание</a>
            <a href="<?=$arParams['IBLOCK_URL']?>" class="btn-green-border">К списку</a>
    </div>
</section>

<?endif?>
