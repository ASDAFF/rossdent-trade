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
						<select name="THEME" id="theme">
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
						Контактный e-mail
						<span class="mf-req">*</span>:
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
						<select name="PERSON" id="person">
							<option selected>Госуд. /муниц. медицинское учреждение</option>
							<option>Частное медицинское учреждение</option>
							<option>Торговая организация</option>
							<option value="Другое">Другое (напишите в тексте сообщения)</option>
						</select>
					</div>
				</div>



				<div class="mf-name">
					<div class="mf-text">
						Регион
						<span class="mf-req">*</span>:
					</div>

					<div class="select-arrow">
						<select name="REGION">
							<? foreach($arResult['REGION_AR'] as $k => $r):?>
							<option <?=($k == 0) ? "selected" : ""?>><?=$r?></option>
							<? endforeach; ?>
						</select>
					</div>
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

				<input type="hidden" id="source" name="source" value="Заявка с сайта">
				<input type="hidden" id="zapros" name="zapros" value="">
				<input type="hidden" id="lead_type" name="lead_type" value="Входящий">
				<input type="hidden" id="status" name="status" value="17197705">
				<!--<input type="hidden" id="intr_group" name="intr_group" value="info@rossdent.ru;yaschenko@rossdent.ru;grydcina@rossdent.ru;bezus@rossdent.ru">-->

				<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
				<input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
			</form>

		</div>

	</div>

</section>

<script>
	$(function(){

		$('#theme').change(function(){


			$('#nolead').remove();
			$('#zapros').val("");
			$('#status').val("");
			//$('#intr_group').val("");

			var field = $(this).val();
			if(field == "Росс-Дент Трейд (заказ товара)"){
				$('#status').val("17197705");
				//$('#intr_group').attr("name","intr_group").val("info@rossdent.ru;yaschenko@rossdent.ru;grydcina@rossdent.ru;bezus@rossdent.ru");
			}
			if(field == "Практик-центр (мастер-классы)"){
				$('#status').val("18188902");
				//$('#intr_group').attr("name","intr_group").val("maximova@rossdent.ru;marina@rossdent.ru");
			}
			if(field == "Оборудование KaVo"){
				$('#status').val("18188911");
				//$('#intr_group').attr("name","intr_group").val("sherer@rossdent.ru;a.akopyan@rossdent.ru;igor@rossdent.ru;balaev@rossdent.ru");
			}
			if(field == "Сервисные услуги"){
				$('<input type="hidden" id="nolead" name="nolead" value="1">').appendTo('.mfeedback form');
				//$('#intr_group').attr("name","manager").val("1994722");
				$('#zapros').val("Сервисные услуги");
			}
			if(field == "Перезвоните мне/другое"){
				$('<input type="hidden" id="nolead" name="nolead" value="1">').appendTo('.mfeedback form');
				$('#zapros').val("Перезвоните мне/другое");
				//$('#intr_group').attr("name","manager").val("1994722");
			}
		});

	});
	$("#phone").mask("+7 (999) 999 99 99");
</script>
