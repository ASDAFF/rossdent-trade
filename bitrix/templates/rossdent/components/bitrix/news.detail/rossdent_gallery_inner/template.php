<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<section class="catalog news-detail">
    <div class="box">
        <hr class="catalog__hr">
        <div class="catalog__header">
            <?=$arResult['NAME']?>
        </div>
        <div class="catalog__header-date">
            <?=$arResult['TIMESTAMP_X']?>
        </div>
    </div>
</section>

<?if(strlen($arResult['PROPERTIES']['MEDIA_VIDEO']['VALUE'])>0):?>
<section class="news-text">
		<div class="box">
			<div class="news-text__wrapper">
				<iframe class="news-text__video" width="560" height="315" src="<?=$arResult['PROPERTIES']['MEDIA_VIDEO']['VALUE']?>" frameborder="0" allowfullscreen>
				</iframe>
			</div>
			<a href="/media/" class="btn-green-border">Вернуться</a>
		</div>
</section>
<?else:?>
	<section class="news-text">
	    <div class="box">
				<div class="news-text__wrapper">
					<div class="news-text__images">
						<?foreach ($arResult['PROPERTIES']['MEDIA_PICTURES']['VALUE'] as $pictureId):?>
							<a class="gallery" rel="group" href="<?=CFile::GetPath($pictureId)?>"><img src="<?=CFile::GetPath($pictureId)?>" alt="" /></a>
						<?endforeach?>
					</div>
	      </div>
	      <a href="/media/" class="btn-green-border">Вернуться</a>
	    </div>
	</section>
<?endif?>
