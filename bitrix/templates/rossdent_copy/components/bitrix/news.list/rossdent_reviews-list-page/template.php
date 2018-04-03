<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<section class="catalog min-height">
  <div class="box">
    <hr class="catalog__hr">
    <div class="catalog__header">
      Отзывы
    </div>
    <div class="news-box">
        <?foreach($arResult['ITEMS'] as $arItem):?>
        <a class="news-item" href="<?=$arItem['DETAIL_PAGE_URL']?>">
            <div class="news-item__img" style="background-image:url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>')"></div>
            <div class="news-item__text-box">
                <div class="news-item__title">
                    <?=$arItem['NAME']?>
                </div>
                <div>
                    <?=$arItem['PREVIEW_TEXT']?>
                </div>
            </div>
        </a>
        <?endforeach?>
    </div>

	</div>
  <div class="box">
    <a href="/about" class="btn-green-border">Назад</a>
  </div>
</section>
