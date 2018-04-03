<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");
?>

<div class="background-green auth">
	<div class="box">

		<hr class="catalog__hr auth__hr">
		<div class="catalog__header auth__header">
			Авторизация
		</div>

<!-- Страница авторизации -->
<?if($arResult["FORM_TYPE"] == "login"):?>

<form class="form-auth" name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?if($arResult["BACKURL"] <> ''):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
<?foreach ($arResult["POST"] as $key => $value):?>
	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
<?endforeach?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />

			<div class="input-box__title">
				<?=GetMessage("AUTH_LOGIN")?>
			</div>
			<input class="input-box__input" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" size="17" /> <br>

			<div class="input-box__title">
				<?=GetMessage("AUTH_PASSWORD")?>
			</div>
			<input class="input-box__input" type="password" name="USER_PASSWORD" maxlength="50" size="17" autocomplete="off" /><br>

<?if($arResult["SECURE_AUTH"]):?>
				<span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>

				<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
				</noscript>

<script type="text/javascript">
document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
</script>
<?endif?>


<?/*if ($arResult["STORE_PASSWORD"] == "Y"):?>
	<input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" /></td>
	<label for="USER_REMEMBER_frm" title="<?=GetMessage("AUTH_REMEMBER_ME")?>"><?echo GetMessage("AUTH_REMEMBER_SHORT")?></label>
<?endif*/?>

<?if ($arResult["CAPTCHA_CODE"]):?>

	<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:<br />
	<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
	<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br /><br />
	<input type="text" name="captcha_word" maxlength="50" value="" />
<?endif?>
<br>

<div class="info__inputs" style="margin: 20px 0;">
						<div class="input-box__title">
							<label style="display: inline-block;">
								<input class="checkbox-cast" type="checkbox" name="rule" id="rule" value="Y" checked>
								<span class="checkbox-custom"></span>
							</label>
						Нажимая на эту кнопку, я даю свое согласие на <a href="/upload/compliance.pdf" target="_blank">обработку персональных данных</a> и соглашаюсь с условиями <a href="/upload/politics.pdf" target="_blank">политики конфиденциальности</a>.
						</div>
				</div>
<br>
<input class="btn-green-border btn-green-border--white" type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" />

<br>
<br>
<span>
	<noindex><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a></noindex>
</span>

<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
<span>  /  </span>
<span>
	<noindex><a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a></noindex>
</span>
<?endif?>

</form>
<script>
$(function(){
	$('#rule').change(function(){
		$('.btn-green-border').prop('disabled',$(this).is(':checked') ? false : true);
	});
	
});
</script>
</div>
</div>

<?endif?>
