<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<section class="catalog bg-white about-reviews">
	<div class="box">
		<hr class="catalog__hr">
		<div class="catalog__header">
			 Отзывы
			<div class="news__all">
	 		<a href="/reviews/" class="btn-green-border">Все отзывы</a>
			</div>
		</div>
		<div class="about-reviews-box">
			<?foreach($arResult['ITEMS'] as $arItem):?>
			<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="review">
	 			<div class="review__img" style="background-image:url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>')"></div>
				<div class="review__box">
					<div class="review__name">
						<?=$arItem['DISPLAY_PROPERTIES']['REVIEW_FIO']['VALUE']?>
					</div>
					<div class="review__description">
						<?=$arItem['DISPLAY_PROPERTIES']['REVIEW_JOB']['VALUE']?>
					</div>
					<hr class="review__hr">
					<div class="review__text">
						<?=$arItem['PREVIEW_TEXT']?>
					</div>
				</div>
			</a>
			<?endforeach?>
		</div>
	</div>
</section>
