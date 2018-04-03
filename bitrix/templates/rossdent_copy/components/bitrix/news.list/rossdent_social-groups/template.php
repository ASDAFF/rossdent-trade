<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<div class="social">
	<?foreach($arResult['ITEMS'] as $arItem):?>
		<a target="_blank" href="<?=$arItem['PROPERTIES']['SOCIAL_LINK']['VALUE']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" class="social__icon"></a>
	<?endforeach?>
</div>
