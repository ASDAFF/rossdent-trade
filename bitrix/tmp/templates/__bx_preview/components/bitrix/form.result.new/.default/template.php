<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>




<div class="box form">
	<hr class="catalog__hr">
		<?if ($arResult["isFormTitle"]):?>
		<div class="catalog__header">
			<?=$arResult["FORM_TITLE"]?>
		</div>
		<?endif?>

		<?if ($arResult["FORM_NOTE"]) {echo "<span style='color: #96bf30'>Спасибо, с Вами свяжется наш специалист</span>";}?>

<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?=$arResult["FORM_HEADER"]?>

<?
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
?>
	<tr>
		<td><?
/***********************************************************************************
					form header
***********************************************************************************/


	if ($arResult["isFormImage"] == "Y")
	{
	?>
	<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
	<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
	<?
	} //endif
	?>

			<p><?=$arResult["FORM_DESCRIPTION"]?></p>
		</td>
	</tr>
</table>
<br />
<?
/***********************************************************************************
						form questions
***********************************************************************************/
?>

	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
	?>

				<div class="input-box">
					<div class="input-box__title">
						<?=$arQuestion["CAPTION"]?>
						<?if ($arQuestion["REQUIRED"] == 'Y') {echo "*";}?>
					</div>
					<?
					 // echo "<pre>"; print_r($arQuestion); echo "</pre";
					?>
					<?if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'image'):?>
					<!-- <input type="file" class="input-box__input" name="form_<?//=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?//=$arQuestion['STRUCTURE'][0]['ID']?>" value=""> -->
					<label class="file" title=""><input type="file" name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arQuestion['STRUCTURE'][0]['ID']?>" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" /></label>
					<?elseif($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'checkbox'):?>
					<?php foreach ($arQuestion['STRUCTURE'] as $cbId => $cbItem): ?>
						<input id="form_<?=$cbItem['FIELD_TYPE']?>_<?=$cbItem['ID']?>_<?=$cbId?>" class="checkbox" name="form_<?=$cbItem['FIELD_TYPE']?>_<?=$cbItem['ID']?>" type="checkbox"/>
						<label for="form_<?=$cbItem['FIELD_TYPE']?>_<?=$cbItem['ID']?>_<?=$cbId?>"><?=$cbItem['MESSAGE']?></label>
						<?/*echo "<pre>"; print_r($cbItem); echo "</pre";*/?>
					<?php endforeach; ?>
					<?else:?>
					<input type="<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>" class="input-box__input" name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arQuestion['STRUCTURE'][0]['ID']?>" value="<?if(isset($_GET['FIELD_'.$arQuestion['STRUCTURE'][0]['ID']])) {echo $_GET['FIELD_'.$arQuestion['STRUCTURE'][0]['ID']];}?>">
					<?endif?>
				</div>
	<?
		}
	} //endwhile
	?>
<?

if($arResult["isUseCaptcha"] == "Y")
{
?>
		<b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b>
		<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />

		<div class="input-box">
			<div class="input-box__title">
				<?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>
			</div>
			<input class="input-box__input" type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
		</div>

<?
} // isUseCaptcha
?>

<input class="btn-green-border" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
				<?if ($arResult["F_RIGHT"] >= 15):?>
				<input type="hidden" name="web_form_apply" value="Y" />
				<?endif;?>


<?=$arResult["FORM_FOOTER"]?>

<?
} //endif (isFormNote)
?>
<br>
<br>

<?=$arResult["FORM_FOOTER"]?>

</div>
