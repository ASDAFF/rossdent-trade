<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
?>

<?if(count($arResult["ERRORS"]) > 0):?>
		<p>Управление подписками возможно только для зарегистрированных и авторизованных пользователей.</p>
<?else:?>

	<form method="POST" action="<?echo $arResult["FORM_ACTION"]?>">

						<?
						$arRubric = array();
						foreach ($arResult["RUBRICS"] as $arItem) {
						// ID news subscribe
						if ($arItem['ID'] == 1) {$arRubric = $arItem;}
						}?>
						<input class="checkbox" name="RUB_ID[]" value="<?echo $arRubric["ID"]?>" id="RUB_<?echo $arRubric["ID"]?>" type="checkbox" <?if($arRubric["CHECKED"]) echo "checked";?>><label for="RUB_<?echo $arRubric["ID"]?>">Подписка</label><br>

					<div class="">
						Я хочу получать новости и акции на почту
					</div>

					<input name="FORMAT" value="html" id="FORMAT_html" type="hidden" checked>
					<br>

					<?echo bitrix_sessid_post();?>
					<input class="btn-green-border" type="submit" name="Update" value="Применить">
	</form>

<?endif?>
