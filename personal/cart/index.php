<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Здесь вы можете оформить заказ и ознакомится с условиями доставки");
$APPLICATION->SetPageProperty("keywords", "оформление заказа");
$APPLICATION->SetPageProperty("title", "Здесь вы можете оформить заказ и ознакомится с условиями доставки");
$APPLICATION->SetTitle("Корзина");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket",
	"rossdent_basket_list",
	array(
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "PRICE",
			4 => "QUANTITY",
		),
		"PATH_TO_ORDER" => "/personal/order/make/",
		"HIDE_COUPON" => "N",
		"SET_TITLE" => "Y",
		"COMPONENT_TEMPLATE" => "rossdent_basket_list",
		"TEMPLATE_THEME" => "green",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"USE_PREPAYMENT" => "N",
		"QUANTITY_FLOAT" => "N",
		"ACTION_VARIABLE" => "action"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
