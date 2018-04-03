<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<?if($USER->IsAuthorized()):?>
<section class="gallery">
<div class="box">
 <div class="gallery__header">
		Галерея
 </div>
 <div class="gallery__items">
	 <?foreach($arResult["ITEMS"] as $arItem):?>
  	<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="gallery__item">
      <div style="background-image:url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')" class="gallery__img"></div>
  		<div class="gallery__title">
  			<?=TruncateText($arItem["NAME"], 45)?>
  		</div>
      <?if(strlen($arItem['PROPERTIES']['MEDIA_VIDEO']['VALUE'])>0):?>
    		<div class="gallery__info" style="background-image: url('/bitrix/templates/rossdent/img/play.png')">
          <?$time = $arItem['PROPERTIES']['MEDIA_VIDEO_TIME']['VALUE']?>
    			<?=floor($time/60)?>:<?=($time%60)?>
    		</div>
      <?else:?>
        <div class="gallery__info" style="background-image: url('/bitrix/templates/rossdent/img/photo.png')">
  				Фотографий: <?=count($arItem['PROPERTIES']['MEDIA_PICTURES']['VALUE'])?>
  			</div>
      <?endif?>
    </a>
	<?endforeach?>
 </div>
<a href="/media/" class="btn-green-border">Показать еще</a>
</div>
</section>
<?endif?>
