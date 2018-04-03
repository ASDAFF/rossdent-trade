<section >
		<div>
				<hr class="catalog__hr">
				<div class="catalog__header">
						Лекторы практик-центра:
				</div>
				<div class="consultants">
					<?foreach ($arResult['ITEMS'] as $arItem):?>
						<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="consultant">
								<img class="consultant__avatar" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>">
								<div class="consultant__name">
										<?=$arItem['NAME']?>
								</div>
								<div class="consultant__description">
										<?=$arItem['PROPERTIES']['JOB']['VALUE']?>
								</div>
						</a>
					<?endforeach?>
				</div>
		</div>
</section>