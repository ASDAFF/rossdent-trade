<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(count($arResult['OFFERS']) > 0):?>

<?
// Prepare product IDs
$arOffers = $arResult['OFFERS'];
$productIds = array();
$lengthArray = array();
$diamArray = array();
foreach ($arOffers as $arItem) {
  $length = $arItem['PROPERTIES']['PRODUCT_LENGTH']['VALUE'];
  $diam = $arItem['PROPERTIES']['PRODUCT_DIAM']['VALUE'];
  $diamArray[] = $diam;
  $lengthArray[] = $length;
  $productIds[$diam][$length] = $arItem['ID'];
}

$lengthArray = array_unique($lengthArray);
$diamArray = array_unique($diamArray);

// Main price
if ($arResult['MIN_BASIS_PRICE']['CURRENCY'] !== 'RUB') {
  $price = CCurrencyRates::ConvertCurrency($arResult['MIN_BASIS_PRICE']['VALUE'], $arResult['MIN_BASIS_PRICE']['CURRENCY'], 'RUB');
  $price = number_format($price, 0, '', ' ');
} else {
  $price = number_format($arResult['MIN_BASIS_PRICE']['VALUE'], 0, '', ' ');
}

?>

<section class="product-detail">
      <div class="box">
          <hr class="catalog__hr">
          <div class="catalog__header">
              Каталог
          </div>
          <a class="product-detail__back" href="<?=$_SERVER['HTTP_REFERER'];?>">назад</a>
          <div class="product-detail__wrapper">
            <div class="product-detail__wrapper-img">
              <?if(!empty($arResult['PROPERTIES']['PRODUCT_IMAGES']['VALUE'])):?>
              <div class="swiper-container swiper-product-img-inner">
                <div class="swiper-wrapper">
                    <?foreach($arResult['PROPERTIES']['PRODUCT_IMAGES']['VALUE'] as $arItem):?>
                      <div class="swiper-slide"><img src="<?=CFile::GetPath($arItem)?>" alt="" /></div>
                    <?endforeach?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>

              <?elseif(isset($arResult['DETAIL_PICTURE']['SRC']) || strlen($arResult['DETAIL_PICTURE']['SRC']) > 0):?>
              <img class="product-detail__img" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="">
              <?else:?>
              <img class="product-detail__img" src="/bitrix/templates/rossdent/img/no_image.jpg" alt="">
              <?endif?>
            </div>
            <div class="product-detail__info">
              <div class="info__print" onClick="print()"></div>
              <div class="info__name"><?=$arResult['NAME']?></div>
              <span data-price="<?=$price?>" class="info__price"><?=$price?></span>
              <span class="info__price-str">РУБ</span>

              <div class="info__vendor">
                <b>ПРОИЗВОДИТЕЛЬ:</b> <?=$arResult['PROPERTIES']['PRODUCT_VENDOR']['VALUE']?>
              </div>
              <div class="info__why">
                <div class="info__why-item">
                  <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/product-detail-img-1.png" alt="">
                  <p>Доставка<br>
                  в течении 1 дня</p>
                </div>
                <div class="info__why-item">
                  <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/product-detail-img-2.png" alt="">
                  <p>Поддержка<br>
                  и обучение</p>
                </div>
                <div class="info__why-item">
                  <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/product-detail-img-3.png" alt="">
                  <p>Простая система<br>
                  оплаты</p>
                </div>
                <div class="info__why-item">
                  <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/product-detail-img-4.png" alt="">
                  <p>Гарантии<br>
                  Качества</p>
                </div>
              </div>
            </div>
          </div>
          <p class="product-detail__text-caption">Характеристики:</p>
          <p class="product-detail__text">
            <?=$arResult['DETAIL_TEXT']?>
          </p>
      </div>
      <div class="box">
        <div class="product-table">
          <span class="product-table__h-caption"><?if (strlen($arResult['PROPERTIES']['PRODUCT_H_TEXT']['VALUE']) > 0) {echo $arResult['PROPERTIES']['PRODUCT_H_TEXT']['VALUE'];} else {echo 'Длина, мм';}?></span>
          <div class="product-table__wrapper">
            <span class="product-table__v-caption"><?if (strlen($arResult['PROPERTIES']['PRODUCT_V_TEXT']['VALUE']) > 0) {echo $arResult['PROPERTIES']['PRODUCT_V_TEXT']['VALUE'];} else {echo 'Диаметр, мм';}?></span>
            <div class="product-table__table-wrapper">
              <div class="product-table__table-wr">
              <table class="product-table__table">
                <tr>
                  <th></th>
                  <?foreach ($lengthArray as $arLengthValue):?>
                    <th><?=$arLengthValue?></th>
                  <?endforeach?>
                </tr>
                  <?foreach ($diamArray as $diamArrayItem):?>
                    <tr>
                    <td><?=$diamArrayItem?></td>
                    <?foreach ($lengthArray as $lengthItem):?>
                      <td>
                        <?if(isset($productIds[$diamArrayItem][$lengthItem])):?>
                        <input data-product-diam="<?=$diamArrayItem?>" data-product-length="<?=$lengthItem?>" data-id="<?=$productIds[$diamArrayItem][$lengthItem]?>" type="text" class="product-table__table-input" min="0" value="0">
                        <p class="product-table__table-input-str"> шт</p>
                        <?endif?>
                      </td>
                    <?endforeach?>
                    </tr>
                  <?endforeach?>
              </table>
              </div>
              <p class="product-table__description">Для выбора количества имплантов нажмите по соответствующей ячейке таблицы.<br>Цена за штуку: <?=$price?> руб</p>
            </div>
          </div>
          <div class="product-table__price">
            <span class="product-table__price-str">Сумма, руб:</span>
            <span class="product-table__price-sum">---</span>
            <a class="btn-green ajax-btn-basket-add" data-product="<?=$arResult['ID']?>" data-product-is-implant="true" style="background-image: url(/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/basket.png);     background-position-x: 16px;">В КОРЗИНУ</a>
          </div>
        </div>
      </div><br>
    </section>

<?else:?>


  <?
  // Main price
  if ($arResult['PRICES']['BASE']['CURRENCY'] !== 'RUB') {
    $price = CCurrencyRates::ConvertCurrency($arResult['PRICES']['BASE']['VALUE'], $arResult['PRICES']['BASE']['CURRENCY'], 'RUB');
    $price = number_format($price, 0, '', ' ');
  } else {
    $price = number_format($arResult['PRICES']['BASE']['VALUE'], 0, '', ' ');
  }
  ?>

		<section class="product-detail">
		      <div class="box">
		          <hr class="catalog__hr">
		          <div class="catalog__header">
		              Каталог
		          </div>
              <a class="product-detail__back" href="<?=$_SERVER['HTTP_REFERER'];?>" >назад</a>
		          <div class="product-detail__wrapper">
		            <div class="product-detail__wrapper-img">

                  <?if(!empty($arResult['PROPERTIES']['PRODUCT_IMAGES']['VALUE'])):?>
                  <div class="swiper-container swiper-product-img-inner">
                    <div class="swiper-wrapper">
                        <?foreach($arResult['PROPERTIES']['PRODUCT_IMAGES']['VALUE'] as $arItem):?>
                          <div class="swiper-slide"><img src="<?=CFile::GetPath($arItem)?>" alt="" /></div>
                        <?endforeach?>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
                  <?elseif(isset($arResult['DETAIL_PICTURE']['SRC']) || strlen($arResult['DETAIL_PICTURE']['SRC']) > 0):?>
                  <img class="product-detail__img" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="">
                  <?else:?>
                  <img class="product-detail__img" src="/bitrix/templates/rossdent/img/no_image.jpg" alt="">
                  <?endif?>
		            </div>
		            <div class="product-detail__info">
                  <div class="info__print" onClick="print()"></div>
		              <div class="info__name"><?=$arResult['NAME']?></div>

                  <?if(!empty($price) && ($price > 0)):?>
		              <span data-price="<?=$price?>" class="info__price"><?=$price?></span>
		              <span class="info__price-str">РУБ</span>
                  <div data-count="1" class="input-step">
		                <a href="#" class="input-step__prev"></a>
		                <input pattern="[0-9.]+" type="text" class="input-step__count ajax-basket-product-count" value='1' size="1">
		                <a href="#" class="input-step__next"></a>
		              </div>
                  <?else:?>
                    <b>уточняйте цену по телефону
                    +7 (918) 068-02-42</b>
                  <?endif?>
		              <div class="info__colum-wrapper">
                    <?if(strlen($arResult['PROPERTIES']['PRODUCT_ART']['VALUE']) > 0):?>
  		                <div class="info__colum-item">
  		                  <b>АРТИКУЛ:</b> <?=$arResult['PROPERTIES']['PRODUCT_ART']['VALUE']?>
  		                </div>
                    <?endif?>
                    <?if(strlen($arResult['PROPERTIES']['PRODUCT_VENDOR']['VALUE']) > 0):?>
		                <div class="info__colum-item">
		                  <b>ПРОИЗВОДИТЕЛЬ:</b> <?=$arResult['PROPERTIES']['PRODUCT_VENDOR']['VALUE']?>
		                </div>
                    <?endif?>
		              </div>
		              <div class="info__colum-wrapper">
		                <div class="info__colum-item">

                      <?if(isset($price)):?>
  		                  <a class="btn-green ajax-btn-basket-add" data-product="<?=$arResult['ID']?>" style="background-image: url(/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/basket.png);     background-position-x: 16px;">В КОРЗИНУ</a>
                      <?else:?>
                        <a class="btn-green btn-green--inactive" data-product="<?=$arResult['ID']?>" style="background-image: url(/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/basket.png);">В КОРЗИНУ</a>

                      <?endif?>

		                </div>
                    <div class="info__colum-item"> <!--ajax-fast-order класс для открытия аякс формы-->
                      <a href="/question/?<?=http_build_query(array("order_product" => 1,"name_product" => $arResult['NAME']));?>" class="btn-green btn-ico" style="background-image: url(/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/ico-phone.png);">Получить консультацию</a>
                      <form class="form-fast-order hidden" method="post">
                        <? if($arResult['SECTION']['PATH'][0]['CODE'] == "master_klassy"): ?>
                            <input type="hidden" name="status" id="status" value="18188902">
                        <? else: ?>
                            <input type="hidden" name="status" id="status" value="17197705">
                        <? endif;?>

                            <input type="hidden" name="info__name" id="info__name" value="http://prntscr.com/j9swms">
                            <input type="hidden" name="source" id="source" value="Заявка с сайта">
                            <input type="hidden" name="lead_type" id="lead_type" value="Входящий">

                        <div class="btn-close">X</div>
                        <div class="btn-green">
                          <input class="input-box__input" type="hidden" name="tovar" value="<? echo "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>">
                          <div class="input-box">
                            <div class="input-box__title">Имя</div>
                            <input class="input-box__input" type="text" name="name" value="">
                          </div>
                          <div class="input-box">
                            <div class="input-box__title">Телефон</div>
                            <input class="input-box__input" type="text" name="telephone" value="">
                          </div>

						<div class="input-box rule-text">
                          <label style="display: inline-block;">
                            <input class="checkbox-cast" type="checkbox" name="rule" id="rule" value="Y" checked>
                            <span class="checkbox-custom"></span>
                          </label>
						Нажимая на эту кнопку, я даю свое согласие на <a href="/upload/compliance.pdf" target="_blank">обработку персональных данных</a> и соглашаюсь с условиями <a href="/upload/politics.pdf" target="_blank">политики конфиденциальности</a>.
					    </div>

                          <input class="btn-green-border btn-green-border--white" type="submit" value="отправить">
                        </div>
                      </form>
		                </div>
		              </div><br>
		              <div class="info__why">
		                <div class="info__why-item">
		                  <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/product-detail-img-1.png" alt="">
		                  <p>Доставка <br>
		                  в течении 1 дня</p>
		                </div>
		                <div class="info__why-item">
		                  <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/product-detail-img-2.png" alt="">
		                  <p>Поддержка <br>
		                  и обучение</p>
		                </div>
		                <div class="info__why-item">
		                  <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/product-detail-img-3.png" alt="">
		                  <p>Простая система <br>
		                  оплаты</p>
		                </div>
		                <div class="info__why-item">
		                  <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/product-detail-img-4.png" alt="">
		                  <p>Гарантии <br>
		                  Качества</p>
		                </div>
		              </div>
		            </div>
		          </div>
              <?if(strlen($arResult['DETAIL_TEXT']) > 0):?>
		          <p class="product-detail__text-caption">Характеристики:</p>
		          <p class="product-detail__text">
		            <?=$arResult['DETAIL_TEXT']?>
		          </p>
              <?endif?>
                <? if($arResult['PROPERTIES']['CML2_MANUFACTURER']['VALUE']):

                  $params = array(
                      "max_len" => "100",
                      "change_case" => "L",
                      "replace_space" => "-",
                      "replace_other" => "-",
                      "delete_repeat_replace" => "true",
                      "use_google" => "false",
                  );
                  ?>
                    <br>
                    Бренд: <a href="/brands/<?=CUtil::translit($arResult['PROPERTIES']['CML2_MANUFACTURER']['VALUE'], "ru", $params)?>/" class="" style="text-decoration: none;color: black;font-weight: 700;"><?=$arResult['PROPERTIES']['CML2_MANUFACTURER']['VALUE'];?></a>
                <? endif; ?>
		      </div>
		    </section>
<?endif?>


<!-- Похожие товары -->
<div class="box">
  <hr class="catalog__hr">
  <div class="catalog__header">
      С этим товаром покупают
  </div>
  <div class="catalog-view" style="padding-top: 0">
    <div class="box swiper-container swiper-product-recomend">
      <div class="swiper-wrapper">
        <?foreach($arResult['ANALOG'] as $analog):?>
          <a class="catalog-view__item swiper-slide" href="<?=$analog['DETAIL_PAGE_URL']?>">
            <div class="catalog-view__item-img" style="background-image: url('<?=CFile::GetPath($analog['PREVIEW_PICTURE'])?>')"></div>
            <p class="catalog-view__item-title">
              <?=$analog['NAME']?>
            </p>
            <p class="catalog-view__item-price">
            <?if($analog['PRICE'] > 0):?>
              <?=number_format($analog['PRICE'], 0, '', ' ')?>
              <span class="catalog-view__item-price-top"> РУБ</span>
            <?else:?>
              <span class="catalog-view__item-no-price">
                УТОЧНЯЙТЕ ЦЕНУ
              </span>
            <?endif?>
            </p>
          </a>
        <?endforeach?>
      </div>
      <a class="swiper-product-recomend__prev"><img src="/bitrix/templates/rossdent/img/arrow.png" alt="" /></a>
      <a class="swiper-product-recomend__next"><img src="/bitrix/templates/rossdent/img/arrow.png" alt="" /></a>
    </div>
  </div>
</div>
