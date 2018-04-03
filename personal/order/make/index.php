<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?><div class="box">
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax",
	"rossdent_order",
	array(
		"ALLOW_AUTO_REGISTER" => "Y",
		"COUNT_DELIVERY_TAX" => "Y",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"DELIVERY_NO_SESSION" => "Y",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PATH_TO_PERSONAL" => "/personal/",
		"PAY_FROM_ACCOUNT" => "N",
		"SEND_NEW_USER_NOTIFY" => "N",
		"SET_TITLE" => "Y",
		"COMPONENT_TEMPLATE" => "rossdent_order",
		"DELIVERY_NO_AJAX" => "N",
		"TEMPLATE_LOCATION" => "popup",
		"DELIVERY_TO_PAYSYSTEM" => "p2d",
		"USE_PREPAYMENT" => "N",
		"PROP_1" => array(
		),
		"PROP_2" => array(
		),
		"ALLOW_NEW_PROFILE" => "Y",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "Y",
		"PATH_TO_AUTH" => "/auth/",
		"DISABLE_BASKET_REDIRECT" => "N",
		"PRODUCT_COLUMNS" => array(
		)
	),
	false
);?>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
