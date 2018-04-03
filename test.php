<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Тестовая страница");
$APPLICATION->SetTitle("test");?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.recommended.products",
	"",
	Array(
		"ACTION_VARIABLE" => "action_crp",
		"ADDITIONAL_PICT_PROP_16" => "PRODUCT_IMAGES",
		"ADDITIONAL_PICT_PROP_18" => "",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"BASKET_URL" => "/personal/",
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CART_PROPERTIES_16" => array("",""),
		"CART_PROPERTIES_18" => array("",""),
		"CODE" => $_REQUEST["PRODUCT_CODE"],
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "16",
		"IBLOCK_TYPE" => "catalog",
		"ID" => $_REQUEST["PRODUCT_ID"],
		"LABEL_PROP_16" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFERS_PROPERTY_LINK" => "PRODUCT_VENDOR",
		"OFFER_TREE_PROPS_18" => array(),
		"PAGE_ELEMENT_COUNT" => "30",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array("BASE"),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE_16" => array("PRODUCT_VENDOR",""),
		"PROPERTY_CODE_18" => array("",""),
		"PROPERTY_LINK" => "PRODUCT_VENDOR",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_IMAGE" => "Y",
		"SHOW_NAME" => "Y",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_PRODUCTS_16" => "Y",
		"TEMPLATE_THEME" => "site",
		"USE_PRODUCT_QUANTITY" => "N"
	)
);?><br>
 <br>
 <?$APPLICATION->IncludeComponent("bitrix:menu", "rossdent_menu", Array(
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
		"CHILD_MENU_TYPE" => "top",	// Тип меню для остальных уровней
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
			0 => "",
		),
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_TYPE" => "N",	// Тип кеширования
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
		"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>