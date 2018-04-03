<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="background-green auth">
	<div class="box">
		<hr class="catalog__hr auth__hr">
		<div class="catalog__header">
			Восстановление пароля
		</div>

		<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<?
		if (strlen($arResult["BACKURL"]) > 0)
		{
		?>
		<?if ($arParams["~AUTH_RESULT"]['TYPE'] == 'ERROR'):?>
			<p style="color: #A20000;">
				<?=$arParams["~AUTH_RESULT"]['MESSAGE'];?>
			</p>
		<?else:?>
			<p style="color:#C3FDAE;">
				<?=$arParams["~AUTH_RESULT"]['MESSAGE'];?>
			</p>
		<?endif?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?
		}
		?>
			<input type="hidden" name="AUTH_FORM" value="Y">
			<input type="hidden" name="TYPE" value="SEND_PWD">

		<p>
			Если вы забыли пароль, введите логин или E-Mail.
		</p>

		<div class="input-box">
			<span class="input-box__title">Логин</span>
			<input class="input-box__input" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />
		</div>

		<div class="input-box">
			<span class="input-box__title">E-Mail</span>
			<input class="input-box__input" type="text" name="USER_EMAIL" maxlength="255" />
		</div>

		<input class="btn-green-border btn-green-border--white" type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" /><br><br>

		<p>
		<a href="/personal"><?=GetMessage("AUTH_AUTH")?></a>
		</p>
		</form>

	</div>
</div>
