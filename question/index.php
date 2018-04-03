<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Задать вопрос");
?><?$APPLICATION->IncludeComponent(
	"nbrains:main.feedback", 
	"question", 
	array(
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"EMAIL_TO" => "Galina@rossdent.ru",
		"EVENT_MESSAGE_ID" => array(
			0 => "57",
		),
		"IBLOCK_ID" => "31",
		"IBLOCK_TYPE" => "review",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"PROPERTY_CODE" => array(
			0 => "PERSON",
			1 => "REGION",
			2 => "SITY",
			3 => "MESSAGE",
			4 => "RULE",
			5 => "THEME",
			6 => "NAME",
			7 => "EMAIL",
			8 => "PHONE",
		),
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => "question"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>