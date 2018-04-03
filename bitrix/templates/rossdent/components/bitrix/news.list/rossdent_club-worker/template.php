<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<section class="section-padding">
		<div class="box">
				<hr class="catalog__hr">
				<div class="catalog__header">
						ЛЕКТОРЫ НАУЧНОГО ЦЕНТРА:
				</div>
				<div class="consultants">
					<?foreach ($arResult['ITEMS'] as $arItem):?>
						<a href="#" class="consultant">
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
				<div class="consultants__btn">
					<a href="/forum/" class="btn-green btn-green--consultation">
						Получить консультацию
					</a>
					<a href="/courses/#courses" class="btn-green btn-green--consultation">
						Расписание курсов
					</a>
				</div>
		</div>
</section>
