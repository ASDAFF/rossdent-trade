<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?foreach($arResult['ITEMS'] as $arItem):?>


  <div class="catalog-view__item" id="prod<?=$arItem['ID'];?>">
      <?switch($arItem['PROPERTIES']['PRODUCT_TYPE']['VALUE_ENUM_ID']) {
          case 30:
              echo "<div class='action'>Акция</div>";
              break;
          case 31:
              echo "<div class='discount'>Скидка</div>";
              break;
      }?>
      <?if(isset($arItem['PREVIEW_PICTURE']['SRC']) || strlen($arItem['PREVIEW_PICTURE']['SRC']) > 0):?>
      <div class="catalog-view__item-img" style="background-image: url('<?=urldecode($arItem['PREVIEW_PICTURE']['SRC'])?>')">
      </div>
      <?else:?>
      <div class="catalog-view__item-img" style="background-image: url('/bitrix/templates/rossdent/img/no_image.jpg')">
      </div>
      <?endif?>
      <div class="catalog-view__item-title">
          <?=TruncateText($arItem['NAME'], 40)?>
      </div>
      <div class="catalog-view__item-price">
        <?if(isset($arItem['MIN_PRICE']['VALUE'])):?>
          <?=number_format($arItem['MIN_PRICE']['VALUE'], 0, '', ' ')?>
          <span class="catalog-view__item-price-top">
              РУБ
          </span>
        <?else:?>
        <span class="catalog-view__item-no-price">
            Уточняйте цену
        </span>
        <?endif?>
      </div>

      <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="catalog-view__src">
      <div class="catalog-view__item-hover">
        <div class="catalog-view__item-inner-title">
          <?=$arItem['NAME']?>
        </div>
        <div class="catalog-view__item-inner-text">
          <?=$arItem['PREVIEW_TEXT']?>
        </div>

        <?// is implant? ?>
        <?if (count($arItem['OFFERS']) > 0):?>
            <div class="btn-green btn-green--detail">Подробнее</div>
        <?else:?>
          <?if (isset($arItem['MIN_PRICE']['VALUE'])):?>
          <div class="catalog-view__basket">
            <div data-count="1" class="input-step">
              <div href="#" class="input-step__prev"></div>
              <input pattern="[0-9.]+" type="text" class="input-step__count ajax-basket-product-count ajax-basket-no-calc-price" value='1' size="1">
              <div href="#" class="input-step__next"></div>
            </div>
            <div class="btn-green btn-green--basket ajax-btn-basket-add" data-product="<?=$arItem['ID']?>">В КОРЗИНУ</div>
          </div>
          <?else:?>
            <div class="btn-green btn-green--detail">Подробнее</div>
          <?endif?>
        <?endif?>
      </div>
      </a>

  </div>


<?endforeach?>
