<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>


<?
$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket.line",
    "rossdent_basket_mobile",
    Array(
        "COMPONENT_TEMPLATE" => ".default",
        "PATH_TO_PERSONAL" => SITE_DIR."personal/",
        "PATH_TO_PROFILE" => SITE_DIR."personal/",
        "PATH_TO_REGISTER" => SITE_DIR."login/",
        "POSITION_FIXED" => "N",
        "SHOW_AUTHOR" => "N",
        "SHOW_EMPTY_VALUES" => "Y",
        "SHOW_NUM_PRODUCTS" => "Y",
        "SHOW_PERSONAL_LINK" => "N",
        "SHOW_PRODUCTS" => "N",
        "SHOW_TOTAL_PRICE" => "Y"
    )
);
?>
