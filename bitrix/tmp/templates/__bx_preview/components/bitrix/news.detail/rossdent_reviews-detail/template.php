<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="box">
<div class="courses-detail">
	<hr class="catalog__hr">
	<div class="catalog__header">
		<?=$arResult['NAME']?>
	</div>
	<a class="product-detail__back" href="/reviews/">назад</a>
	<div class="courses-detail__wrapper">
		<img class="courses-detail__img" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="" />
		<table class="courses-detail__table">
			<tr>
				<td>
					<b>ФИО:</b>
				</td>
				<td>
					<?=$arResult['DISPLAY_PROPERTIES']['REVIEW_FIO']['VALUE']?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Должность:</b>
				</td>
				<td>
					<?=$arResult['PROPERTIES']['REVIEW_JOB']['VALUE']?>
				</td>
			</tr>
		</table>



	</div>
	<?=$arResult['DETAIL_TEXT']?>
</div>
</div>
