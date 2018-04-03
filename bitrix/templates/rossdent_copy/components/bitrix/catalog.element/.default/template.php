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

<div class="courses-detail">
	<hr class="catalog__hr">
	<div class="catalog__header">
		<?=$arResult['NAME']?>
	</div>
	<div class="courses-detail__wrapper">
		<img class="courses-detail__img" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="" />
		<table class="courses-detail__table">
			<tr>
				<td>
					<b>Место проведения:</b>
				</td>
				<td>
					<?=$arResult['PROPERTIES']['LESSON_COUNTRY_FULL']['VALUE']?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Лекторы:</b>
				</td>
				<td>
					<?=$arResult['PROPERTIES']['LESSON_TEACHER']['VALUE']?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Дата проведения:</b>
				</td>
				<td>
					<?if ($arResult["PROPERTIES"]["LESSON_DATE_END"]['VALUE']): //Условие, проверяющее, заполнено ли свойство?>
					<?=$arResult['PROPERTIES']['LESSON_DATE']['VALUE']?> - <?=$arResult['PROPERTIES']['LESSON_DATE_END']['VALUE']?>
					<?else:?>
					<?=$arResult['PROPERTIES']['LESSON_DATE']['VALUE']?>
					<?endif //конец условия?>
				</td>
			</tr>
			
			<tr>
				<td><?$APPLICATION->IncludeComponent(
					"bitrix:sp-artgroup.share",
					".default",
					Array(
						"COMPONENT_TEMPLATE" => ".default",
						"HOW_INC" => "local",
						"SERVICES" => array(0=>"vkontakte",1=>"facebook",2=>"twitter",3=>"odnoklassniki",4=>"moimir",),
						"SHOW" => "small"
						)
						);?></td>
					</tr>
					
					<tr>
						<td colspan="2">
							<a class="btn-green btn-green--wide" href='/form/?WEB_FORM_ID=3&FIELD_23=<?=$arResult['NAME']?>'>
								Зарегистрироваться
							</a>
						</td>
					</tr>
				</table>



			</div>
			<?=$arResult['DETAIL_TEXT']?>
		</div>

		<!-- Social -->
<!-- <div style="text-align: center;"> 
	<span class="ya-share2__box-title">Поделиться в социальных сетях:</span> -->

<!-- 	<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/vendor/share.js" charset="utf-8"></script>
	<div class="ya-share2" data-services="vkontakte,facebook,twitter"></div> -->
<!-- </div>
<br>
<a class="btn-green" style="margin: 0 auto; width: 240px" href="/form/?WEB_FORM_ID=3&FIELD_23=<?=$arResult['NAME']?>">
	Зарегистрироваться
</a> -->
<br>
<br>
