<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<script src="<?=SITE_TEMPLATE_PATH?>/script/jquery.maskinput.js"></script>
<section class="forms">

	<div class="box">
		<hr class="catalog__hr">
		<div class="catalog__header" id="about">
			Задать вопрос
		</div>
	</div>

	<div class="box">

		<div class="mfeedback">


			<?if(!empty($arResult["ERROR_MESSAGE"]))
			{
				foreach($arResult["ERROR_MESSAGE"] as $v)
					ShowError($v);
			}

			if(strlen($arResult["OK_MESSAGE"]) > 0)
			{
				?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
			}
			?>

			<div class="f-req-text">
				<hr class="catalog__hr">
				<div class="f-req-text-body">
					<span class="mf-req">*</span> Поля, отмеченные звездочкой,
					обязательны для заполнения.
				</div>
			</div>

			<form action="<?=POST_FORM_ACTION_URI?>" method="POST" enctype="multipart/form-data">

				<?=bitrix_sessid_post()?>



				<div class="mf-name">
					<div class="mf-text">
						Тема
						<span class="mf-req">*</span>:
					</div>
					<div class="select-arrow">
						<select name="THEME">
							<option selected>Росс-Дент Трейд (заказ товара)</option>
							<option>Практик-центр (мастер-классы)</option>
							<option>Оборудование KaVo</option>
							<option>Сервисные услуги</option>
							<option>Перезвоните мне/другое</option>
						</select>
					</div>
				</div>

				<div class="mf-name">
					<div class="mf-text">
						Ваше имя
						<span class="mf-req">*</span>:
					</div>
					<input type="text" name="NAME" value="<?=$arResult['NAME']?>">
				</div>

				<div class="mf-name">
					<div class="mf-text">
						Контактный e-mail:
					</div>
					<input type="text" name="EMAIL" value="<?=$arResult['EMAIL']?>">
				</div>

				<div class="mf-name">
					<div class="mf-text">
						Контактный Телефон
						<span class="mf-req">*</span>:
					</div>
					<input type="text" name="PHONE" id="phone" placeholder="+7" value="<?=$arResult['PHONE']?>">
				</div>

				<div class="mf-name">
					<div class="mf-text">
						Вы представитель:
					</div>
					<div class="select-arrow">
						<select name="PERSON">
							<option selected>Госуд. /муниц. медицинское учреждение</option>
							<option>Частное медицинское учреждение</option>
							<option>Торговая организация</option>
							<option>Другое (напишите в тексте сообщения)</option>
						</select>
					</div>
				</div>

				<div class="mf-name">
					<div class="mf-text">
						Регион
						<span class="mf-req">*</span>:
					</div>
					<input type="text" name="REGION" value="<?=$arResult['REGION']?>">
				</div>

				<div class="mf-name mb">
					<div class="mf-text">
						Город
						<span class="mf-req">*</span>:
					</div>
					<input type="text" name="SITY" value="<?=$arResult['SITY']?>">
				</div>

				<div class="mf-name-textarea">
					<div class="mf-textarea">
						Текст сообщения:
					</div>
					<textarea name="MESSAGE"><?=$arResult['MESSAGE']?></textarea>
				</div>

				<div class="mf-rule">
						<label style="display: inline-block;">
							<input class="checkbox-cast" type="checkbox" name="RULE" id="rule" value="Y" checked>
							<span class="checkbox-custom" style="border: 1px solid"></span>
						</label>
						Нажимая на эту кнопку, я даю свое согласие на <a style="color: #949797;" href="/upload/compliance.pdf" target="_blank">обработку персональных данных</a> и соглашаюсь с условиями <a style="color: #949797;" href="/upload/politics.pdf" target="_blank">политики конфиденциальности</a>.
				</div>

				<?if($arParams["USE_CAPTCHA"] == "Y"):?>
					<div class="mf-captcha">
						<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
						<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
						<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
						<input type="text" name="captcha_word" size="30" maxlength="50" value="">
					</div>
				<?endif;?>


				<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
				<input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
			</form>




		</div>

	</div>


</section>
<script>
	$("#phone").mask("+7 (999) 999 99 99");
</script>
