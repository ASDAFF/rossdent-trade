<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<section class="section-padding">
    <div class="box">
        <hr class="catalog__hr">
        <div class="catalog__header">
            С вами работают
        </div>
        <div class="consultants">
            <?foreach($arResult['ITEMS'] as $arItem):?>
            <div href="#" class="consultant">
                <img class="consultant__avatar" src="<?=urldecode($arItem['PREVIEW_PICTURE']['SRC'])?>">
                <div class="consultant__name">
                    <?=$arItem['DISPLAY_PROPERTIES']['WORKER_FIO']['VALUE']?>
                </div>
                <div class="consultant__description">
                    <?=$arItem['DISPLAY_PROPERTIES']['WORKER_JOB']['VALUE']?>
                </div>
                <div class="consultant__contacts">
                    <a class="consultant__contacts-a" href="tel:<?=$arItem['DISPLAY_PROPERTIES']['WORKER_PHONE']['VALUE']?>"><span class="consultant__bold">Тел.:</span> <?=$arItem['DISPLAY_PROPERTIES']['WORKER_PHONE']['VALUE']?></a>
                    <a class="consultant__contacts-a" href="mailto:<?=$arItem['DISPLAY_PROPERTIES']['WORKER_EMAIL']['VALUE']?>"><span class="consultant__bold">E-mail:</span> <?=$arItem['DISPLAY_PROPERTIES']['WORKER_EMAIL']['VALUE']?></a>
                </div>
            </div>
            <?endforeach?>
        </div>
    </div>
</section>
