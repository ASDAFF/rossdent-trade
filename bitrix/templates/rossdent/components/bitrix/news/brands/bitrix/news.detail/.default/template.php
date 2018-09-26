<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="catalog news-detail">
	<div class="box">
		<hr class="catalog__hr">
		<div class="catalog__header">
			<?=$arResult['NAME']?>
		</div>
	</div>
</section>


<section class="news-text">
	<div class="box">
		<div class="news-text__wrapper">
			<img class="brand-text__img" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>">
			<?=$arResult['DETAIL_TEXT']?>
		</div>
	</div>
</section>


<section id="catalog-view" class="catalog-view">
	<div class="box">

		<div class="catalog-view__items" data-count="" data-limit="" data-section-id="">

			<? foreach($arResult['ITEMS'] as $arItem): ?>

				<div class="catalog-view__item" id="prod<?=$arItem['ID']?>">
					<div class="catalog-view__item-img" style="background-image: url(<?=($arItem['PREVIEW_PICTURE']) ? CFile::GetPath($arItem["PREVIEW_PICTURE"]) : '/bitrix/templates/rossdent/img/no_image.jpg';?>)">
					</div>
					<div class="catalog-view__item-title">
						<?=TruncateText($arItem['NAME'], 40)?>
					</div>
					<div class="catalog-view__item-price">
						<?=number_format($arItem['PRICE'], 0, '', ' ')?>
						<span class="catalog-view__item-price-top">РУБ</span>
					</div>

					<a href="<?=$arItem['DETAIL_PAGE_URL'];?>" class="catalog-view__src">
						<div class="catalog-view__item-hover">
							<div class="catalog-view__item-inner-title">
								<?=$arItem['NAME']?>
							</div>
							<div class="catalog-view__item-inner-text">
								<?=$arItem['PREVIEW_TEXT']?>
							</div>

							<div class="catalog-view__basket">
								<div data-count="1" class="input-step">
									<div href="#" class="input-step__prev"></div>
									<input pattern="[0-9.]+" type="text" class="input-step__count ajax-basket-product-count ajax-basket-no-calc-price" value="1" size="1">
									<div href="#" class="input-step__next"></div>
								</div>
								<div class="btn-green btn-green--basket ajax-btn-basket-add" data-product="<?=$arItem['ID']?>">В КОРЗИНУ</div>
							</div>
						</div>
					</a>
				</div>
			<? endforeach; ?>
		</div>
	</div>

	<div class="pagination">
		<div class="pagination__bg">
			<? for($i = 1; $i <= $arResult['PAGES']; $i++): ?>
				<a href="?PAGEN_1=<?=$i?>" class="pagination__item <?=($arResult['PAGE'] == $i) ? 'pagination__item--act' : '';?>"><?=$i?></a>
			<? endfor; ?>
		</div>
	</div>

	<a href="/brands/" class="btn-green-border">К списку</a>
</section>

