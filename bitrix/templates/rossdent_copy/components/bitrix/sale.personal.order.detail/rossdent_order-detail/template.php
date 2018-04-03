<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="box">
<?if(!empty($arResult['ERRORS']['FATAL'])):?>

	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?=ShowError($error)?>
	<?endforeach?>

<?else:?>

	<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

		<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?endif?>

	<hr class="catalog__hr">
	<div class="catalog__header">
    Подробности заказа
  </div>

	<a class="product-detail__back" href="<?=$arResult["URL_TO_LIST"]?>">К списку заказов</a>


	<table class="courses-detail__table courses-detail__wrapper">
		<tbody>
			<tr>
				<td>
					<b>Номер заказа:</b>
				</td>
				<td>
					№<?=$arResult["ACCOUNT_NUMBER"]?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Дата заказа:</b>
				</td>
				<td>
					<?=$arResult["DATE_INSERT_FORMATED"]?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Текущий статус:</b>
				</td>
				<td>
					<?=$arResult["STATUS"]["NAME"]?>
				</td>
			</tr>


			<?if (isset($arResult["ORDER_PROPS"])):?>
				<?foreach($arResult["ORDER_PROPS"] as $prop):?>

					<?/*Выводим адрес доставки и контактное лицо*/?>
					<?if ($prop['ID'] == 47 || $prop['ID'] == 48):?>

					<tr>
						<td><b><?=$prop['NAME']?>:</b></td>
						<td><?=$prop["VALUE"]?></td>
					</tr>
					<?endif?>

				<?endforeach?>
			<?endif;?>

			<tr><td><br></td><td></td></tr>

		</tbody>
	</table>

	<hr class="catalog__hr">
	<div class="catalog__header">
		Содержимое заказа
	</div>

	<div class="lesson">
		<?if (isset($arResult["BASKET"])):?>
			<?foreach($arResult["BASKET"] as $prod):?>
				<div class="lesson-item__table">
					<div class="lesson-item__table-item">
						<div class="lesson-item__table-item-title">
							Товар
						</div>
						<div class="lesson-item__table-item-text">
							<a href="<?=$prod["DETAIL_PAGE_URL"]?>" class="product__item" style="background-image: url('<?=$prod['PICTURE']['SRC']?>')"></a>
						</div>
					</div>
					<div class="lesson-item__table-item">
						<div class="lesson-item__table-item-title">
							Наименование
						</div>
						<div class="lesson-item__table-item-text">
							<?=htmlspecialcharsEx($prod["NAME"])?>
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
			<?endforeach?>
		<?endif?>
		<p class="lesson__right"><b>Итого:</b> <?=$arResult["PRICE_FORMATED"]?></p>
	</div>


</div>

<?endif?>
