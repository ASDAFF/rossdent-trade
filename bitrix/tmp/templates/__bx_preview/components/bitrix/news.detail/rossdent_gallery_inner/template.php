<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<section class="catalog news-detail">
    <div class="">
        <hr class="catalog__hr">
        <div class="catalog__header">
            <?=$arResult['NAME']?>
        </div>
        <div class="catalog__header-date">
            <?=$arResult['TIMESTAMP_X']?>
        </div>
    </div>
</section>

<?if(strlen($arResult['PROPERTIES']['MEDIA_CLINIC_VIDEO']['VALUE'])>0):?>
<section class="news-text">
        <div class="">
            <div class="news-text__wrapper">	
                <iframe class="news-text__video" width="560" height="315" src="<?=$arResult['PROPERTIES']['MEDIA_CLINIC_VIDEO']['VALUE']?>" frameborder="0" allowfullscreen>
                </iframe>
            </div>
        </div>
</section>
<section class="news-text">
        <div class="">
                <div class="news-text__wrapper">
                    <div class="news-text__images">
                        <?foreach ($arResult['PROPERTIES']['MEDIA_CLINIC_PICTURES']['VALUE'] as $pictureId):?>
                            <a class="gallery" rel="group" href="<?=CFile::GetPath($pictureId)?>"><img src="<?=CFile::GetPath($pictureId)?>" alt="" /></a>
                        <?endforeach?>
                    </div>
          </div>
          <a href="/courses/galery/" class="btn-green-border">Вернуться</a>
        </div>

    </section>
<div class="clear"></div>
    
<?else:?>
    <section class="news-text">
        <div class="">
                <div class="news-text__wrapper">
                    <div class="news-text__images">
                        <?foreach ($arResult['PROPERTIES']['MEDIA_CLINIC_PICTURES']['VALUE'] as $pictureId):?>
                            <a class="gallery" rel="group" href="<?=CFile::GetPath($pictureId)?>"><img src="<?=CFile::GetPath($pictureId)?>" alt="" /></a>
                        <?endforeach?>
                    </div>
          </div>
          <a href="/courses/galery/" class="btn-green-border">Вернуться</a>
        </div>
    </section>
    <div class="clear"></div>
<?endif?>