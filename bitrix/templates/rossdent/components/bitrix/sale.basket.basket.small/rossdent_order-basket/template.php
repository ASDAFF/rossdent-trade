<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(count($arResult['ITEMS'])>0):?>

<div class="swiper-slide">
	<table cellpadding="0" cellspacing="0" class="product">
	<tbody>
	<tr>
		<!-- <pre> -->
			<?//=print_r($arResult, true)?>
		<!-- </pre> -->
		<!-- Товары -->
		<td>
			<?
				if(!CModule::IncludeModule("iblock")){}
				$quantity = 0;
				$priceSum = 0;
			?>
			<?foreach ($arResult["ITEMS"] as $item):?>

			   <?
				 if (($n = strpos($item['PRODUCT_XML_ID'], "#")) > 0) {
					 $productId = substr($item['PRODUCT_XML_ID'], 0, $n);
				 } else {
					 $productId = $item['PRODUCT_ID'];
				 }
				 $el = CIBlockElement::GetByID($productId);
				 $quantity += $item['QUANTITY'];
				 $priceSum += $item['PRICE'] * $item['QUANTITY'];
				 if($el_res = $el->GetNext()) {}
				 if (strlen($el_res['PREVIEW_PICTURE']) > 0):?>
					 <a href="<?=$item['DETAIL_PAGE_URL']?>" class="product__item" style="background-image: url('<?=CFile::GetPath($el_res['PREVIEW_PICTURE']);?>')">
					 </a>
				 <?else:?>
					 <a href="<?=$item['DETAIL_PAGE_URL']?>" class="product__item" style="background-image: url('/bitrix/templates/rossdent/img/no_image.jpg')">
					 </a>
				 <?endif?>

			<?endforeach?>
		</td>

		<!-- Общее количество товара -->
		<td>
			<div class="product__count-box">
				 <?=$quantity?> <span class="product__top-text">шт</span>
			</div>
		</td>

		<!-- Подробная информация по продуктам -->
		<td>
			<a href="/personal/cart" class="btn-green-border">Подробнее</a>
		</td>

		<!-- Сумма заказа -->
		<td>
			<div class="product__count-box">
				 <?=number_format($priceSum, 2, '.', ' ')?> <span class="product__top-text">руб</span>
			</div>
		</td>

		<!-- Статус заказа -->
		<td>
			<div class="product__status-delivered">
				 <div class="btn-green ajax-btn-order">
						 Оформить
				 </div>
			</div>
		</td>

	</tr>
	</tbody>
	</table>
</div>
<?endif?>
