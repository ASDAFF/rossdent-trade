<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="news-detail">
	<div class="row">
		<div class="col-sm-3 col-xs-12">
			<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>

			<img
			class="detail_picture"
			border="0"
			src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
			height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
			/>
			<?endif?>
		</div>
		<div class="col-sm-8 col-xs-12">
			<div class="lector-name">
				<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
				<?=$arResult["NAME"]?>
				<?endif;?>
			</div>
			<div class="lector-prof">
			<?=$arResult['PROPERTIES']['JOB']['VALUE']?>
			</div>
			<div class="lector-description">
				<?if($arResult["NAV_RESULT"]):?>
				<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
				<?echo $arResult["NAV_TEXT"];?>
				<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
				<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
				<?echo $arResult["DETAIL_TEXT"];?>
				<?else:?>
				<?echo $arResult["PREVIEW_TEXT"];?>
				<?endif?>
			</div> 

			<?if ($arResult["PROPERTIES"]["LECTOR_LINK"]['VALUE']): //Условие, проверяющее, заполнено ли свойство?>
					<div class="lector-show-more">
				<a href="<?=$arResult['DISPLAY_PROPERTIES']['LECTOR_LINK']['VALUE']?>" class="btn-green-border" target="_blank"> Подробнее</a>
			</div>
					<?endif //конец условия?>
			
		</div>
	</div>
	<div class="clear"></div>
	<div style="clear:both"></div>
	

</div>