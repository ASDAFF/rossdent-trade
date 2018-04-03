<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>


<script type="text/javascript">
<!--
var opened_sections = [<?
$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
if (strlen($arResult["opened"]) > 0)
{
	echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
}
else
{
	$arResult["opened"] = "reg";
	echo "'reg'";
}
?>];
//-->

var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
</script>

<section class="info">
<div class="box">
	<div class="info__header">
		Оформить заказ
	</div>
	<?
	if ($arResult['DATA_SAVED'] == 'Y')
		ShowNote(GetMessage('PROFILE_DATA_SAVED'));
	?>
	<?ShowError($arResult["strProfileError"]);?>
	<div class="info__form-box">
		<form class="info__form" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
			<?=$arResult["BX_SESSION_CHECK"]?>
			<input type="hidden" name="lang" value="<?=LANG?>" />
			<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
			<hr class="info__hr">
			<div class="info__title">
				 Контактные данные
			</div>
			<div class="info__inputs">
				<div class="input-box">
					<div class="input-box__title">
						 Фамилия
					</div>
 <input placeholder="Введите фамилию" class="input-box__input" type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
				</div>
				<div class="input-box">
					<div class="input-box__title">
						 Имя
					</div>
 					<input placeholder="Введите имя" class="input-box__input" type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
				</div>
				<div class="input-box">
					<div class="input-box__title">
						 Отчество
					</div>
 <input placeholder="Введите отчество" class="input-box__input" type="text" name="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
				</div>
				<div class="input-box">
					<div class="input-box__title">
						 Почта
					</div>
 <input placeholder="Введите почту" class="input-box__input" type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
				</div>
				<div class="input-box">
					<div class="input-box__title">
						 Телефон
					</div>
 <input placeholder="Введите телефон" class="input-box__input" type="text" name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
				</div>
			</div>
			<hr class="info__hr">
			<div class="info__title js-address">
				 Адрес доставки
			</div>
			<div class="info__inputs">
				<div class="input-box">
					<div class="input-box__title">
						 Страна
					</div>
 <?=$arResult["COUNTRY_SELECT"]?>
				</div>

				<div class="input-box">
					<div class="input-box__title">
						 Город
					</div>
 <input placeholder="Введите город" class="input-box__input" type="text" name="PERSONAL_CITY" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>" />
				</div>
				<div class="input-box">
					<div class="input-box__title">
						 Улица, дом
					</div>
 <input placeholder="Введите улицу, дом" class="input-box__input" cols="30" rows="5" name="PERSONAL_STREET" value="<?=$arResult["arUser"]["PERSONAL_STREET"]?>" />
				</div>

			</div>
			<div class="info__inputs" style="margin-bottom: 40px;">
				<div class="input-box__title">
					<label style="display: inline-block;">
						<input class="checkbox-cast" type="checkbox" name="RULE" id="rule" value="Y" checked>
						<span class="checkbox-custom" style="border: 1px solid"></span>
					</label>
					Нажимая на эту кнопку, я даю свое согласие на <a style="color: #949797;" href="/upload/compliance.pdf" target="_blank">обработку персональных данных</a> и соглашаюсь с условиями <a style="color: #949797;" href="/upload/politics.pdf" target="_blank">политики конфиденциальности</a>.
				</div>
			</div>
			<input type="submit" class="btn-green-border" style="display: inline-block; float: left; margin: 10px 10px 0 0;" value="Применить" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">

			<div class="btn-green-border ajax-btn-order" style="display: inline-block; float: left; margin: 10px 10px 0 0;">Оформить</div>
			<input type="hidden" name="LOGIN" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
		</form>
		<div class="subscription">
			<?$APPLICATION->IncludeComponent(
			 "bitrix:subscribe.simple",
			 "rossdent_subscribe",
			 Array(
				 "AJAX_MODE" => "N",
				 "AJAX_OPTION_ADDITIONAL" => "",
				 "AJAX_OPTION_HISTORY" => "N",
				 "AJAX_OPTION_JUMP" => "N",
				 "AJAX_OPTION_STYLE" => "Y",
				 "CACHE_TIME" => "3600",
				 "CACHE_TYPE" => "A",
				 "COMPONENT_TEMPLATE" => ".default",
				 "SET_TITLE" => "Y",
				 "SHOW_HIDDEN" => "N"
			 )
			);?>
		</div>
	</div>
</div>

</section>
