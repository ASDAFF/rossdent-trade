<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

	<?// Выводим заказы?>
<?if(!empty($arResult['ORDERS'])):?>

	<?foreach($arResult["ORDER_BY_STATUS"] as $key => $group):?>

		<?foreach($group as $k => $order):?>

		<div class="swiper-slide">
			<table cellpadding="0" cellspacing="0" class="product">
			<tbody>
			<tr>

				<!-- Товары -->
				<td>
					<?if(!CModule::IncludeModule("iblock")){}?>
					<?foreach ($order["BASKET_ITEMS"] as $item):?>
						<?
						if (($n = strpos($item['PRODUCT_XML_ID'], "#")) > 0) {
	 					 $productId = substr($item['PRODUCT_XML_ID'], 0, $n);
	 				 } else {
	 					 $productId = $item['PRODUCT_ID'];
	 				 }
					 $el = CIBlockElement::GetByID($productId);
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
					<?$productCount = 0;?>
					<?foreach ($order["BASKET_ITEMS"] as $item):?>
						<?$productCount += $item['QUANTITY'];?>
					<?endforeach?>
					<div class="product__count-box">
						 <?=$productCount?> <span class="product__top-text">шт</span>
					</div>
				</td>

				<!-- Подробная информация по продуктам -->
				<td>
						<a href="/personal/order/?id=<?=$order['ORDER']['ID']?>" class="btn-green-border">Подробнее</a>
				</td>

				<!-- Сумма заказа -->
				<td>
					<div class="product__count-box">
						 <?=number_format($order['ORDER']['PRICE'], 2, '.', ' ')?> <span class="product__top-text">руб</span>
					</div>
				</td>

				<!-- Статус заказа -->
				<? if ($arResult["INFO"]["STATUS"][$key]['ID'] == 'N'):?>

				<td>
					<div class="product__status-delivered">
						 Принят
						 <div class="product__status-delivered-date">
								 <?=$order["ORDER"]["DATE_STATUS_FORMATED"];?>
						 </div>
					</div>
				</td>

				<?elseif($arResult["INFO"]["STATUS"][$key]['ID'] == 'F'):?>

				<td>
					 <a class="product__status-delivered" >
							Выполнен
							 <a data-order-id="<?=$order["ORDER"]["ID"]?>" class="product__lnk-reply">Повторить заказ</a>
							<?/*<div class="product__status-delivered-date">
									<?=$order["ORDER"]["DATE_STATUS_FORMATED"];?>
							</div>*/?>
						</a>
				</td>

				<?elseif($key == 'PSEUDO_CANCELLED'):?>
				<td>
					<div class="product__status-sent">
						 Отменен
					</div>
				</td>

				<?else:?>
				<td>
					<div class="product__status-sent">
						 Неопределен
					</div>
				</td>
				<?endif?>

			</tr>
			</tbody>
			</table>

		</div>


		<?endforeach?>

	<?endforeach?>
<?endif?>
