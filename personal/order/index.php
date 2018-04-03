<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подробности заказа");?>

<?$orderId = $_REQUEST['id'];
$APPLICATION->IncludeComponent("bitrix:sale.personal.order.detail","rossdent_order-detail",Array(
        "PATH_TO_LIST" => "/personal/",
        "ID" => $orderId,
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_GROUPS" => "Y",
        "SET_TITLE" => "Y",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "PREVIEW_PICTURE_WIDTH" => "110",
        "PREVIEW_PICTURE_HEIGHT" => "110",
        "RESAMPLE_TYPE" => "1",
        "CUSTOM_SELECT_PROPS" => array(),
        "PROP_1" => Array(),
        "PROP_2" => Array()
    )
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
