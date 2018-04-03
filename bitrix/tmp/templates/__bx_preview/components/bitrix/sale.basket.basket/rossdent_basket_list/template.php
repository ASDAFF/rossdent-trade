<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="box">
	<?if (strlen($arResult["ERROR_MESSAGE"]) <= 0):?>

		<hr class="catalog__hr">
		<div class="catalog__header">
	    Корзина
	  </div>

		<a class="product-detail__back" href="/personal/">К списку заказов</a>

		<div class="lesson">
			<?if (isset($arResult['GRID']['ROWS'])):?>
				<?foreach($arResult['GRID']['ROWS'] as $prod):?>
				<!-- <pre> -->
					<?//=print_r($prod, true)?>
				<!-- </pre> -->
					<div class="lesson-item__table">
						<div class="lesson-item__table-item">
							<div class="lesson-item__table-item-title">
								Товар
							</div>
							<div class="lesson-item__table-item-text">
								<a href="<?=$prod["DETAIL_PAGE_URL"]?>" class="product__item" style="background-image: url('<?=$prod['DETAIL_PICTURE_SRC']?>')"></a>
							</div>
						</div>
						<div class="lesson-item__table-item">
							<div class="lesson-item__table-item-title">
								Наименование
							</div>
							<div class="lesson-item__table-item-text">
								<?
								/*if (($n = strpos($prod['PRODUCT_XML_ID'], "#")) > 0) {
									$productId = substr($prod['PRODUCT_XML_ID'], 0, $n);
									$el = CIBlockElement::GetByID($productId);
									if($el_res = $el->GetNext()) {}
									echo "<pre>";
									echo print_r($el_res, true);
									echo "</pre>";
								} else {*/
									echo $prod["NAME"];
								/*}*/?>
							</div>
						</div>
						<div class="lesson-item__table-item">
							<div class="lesson-item__table-item-title">
								Цена
							</div>
							<div class="lesson-item__table-item-text">
								<?=$prod["PRICE_FORMATED"]?>
							</div>
						</div>
						<div class="lesson-item__table-item">
							<div class="lesson-item__table-item-title">
								Количество
							</div>
							<div class="lesson-item__table-item-text">
								<?=$prod["QUANTITY"]?>
							</div>
						</div>
					</div>
					<a class='btn-green-border ajax-btn-order-delete' data-id='<?=$prod['ID']?>'>удалить</a>
				<?endforeach?>
			<?endif?>
			<p class="lesson__right"><b>Итого:</b> <?=$arResult['allSum_FORMATED']?></p>
		</div>

	<?else:?>
		<?ShowError($arResult["ERROR_MESSAGE"]);?>
	<?endif?>

</div>
