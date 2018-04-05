<? require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?
use \Bitrix\Main\Web\Cookie;

if ($_REQUEST['PAGEN_1'] > 0 && !$stop_rewrite_cookie) {
    $context = \Bitrix\Main\Context::getCurrent();
    $response = $context->getResponse();
    $c = new Cookie('LP', (int)$_REQUEST['PAGEN_1']);
   // $c->setPath($APPLICATION->GetCurDir());
    $response->addCookie($c);
    $response->flush();
} else {

}
if (!empty($_GET['clear'])) {
    $context = \Bitrix\Main\Context::getCurrent();
    $response = $context->getResponse();
    $c = new Cookie('LP', '');
   // $c->setPath($APPLICATION->GetCurDir());
    $response->addCookie($c);
    $response->flush();
    exit;
}
// Узнаем количество товаров на страницу
$limit = (isset($_GET['limit']) && $_GET['limit'] > 0) ? $_GET['limit'] : 6;

// Получаем ID секции
$sectionID = 0;
if (isset($_GET["SECTION_ID"])) {
    $sectionID = $_GET["SECTION_ID"];
} elseif (isset($_GET["SECTION_CODE"])) {

    $sections = CIBlockSection::GetList(
        Array("SORT" => "ASC"),
        Array("IBLOCK_ID" => CATALOG_ID, "ACTIVE" => "Y"),
        false,
        Array(),
        false);

    while ($section = $sections->getNext()) {

        if ($section['CODE'] == $_GET["SECTION_CODE"]) {
            $sectionID = $section['ID'];
            break;
        }
    }
}

// Фильтрация
$filterSort = isset($_GET['sort']) ? $_GET['sort'] : 'sort';
if ($_GET['sort'] == 'price') {
    //$filterSort = 'property_MINIMUM_PRICE';
    //$filterSort = 'catalog_PRICE_1';
    $filterSort = 'catalog_PRICE_SCALE_1';
}
$filterOrder = isset($_GET['order']) ? $_GET['order'] : 'asc';


$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "rossdent_catalog",
    Array(
        "ACTION_VARIABLE" => "action",
        "ADD_PICT_PROP" => "-",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "ADD_TO_BASKET_ACTION" => "ADD",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BACKGROUND_IMAGE" => "-",
        "BASKET_URL" => "/personal/basket.php",
        "BROWSER_TITLE" => "-",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => "rossdent_catalog",
        "CONVERT_CURRENCY" => "Y",
        "CURRENCY_ID" => "RUB",
        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
        "DETAIL_URL" => "/catalog/#SECTION_CODE#/#ELEMENT_CODE#",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_SORT_FIELD" => $filterSort,
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER" => $filterOrder,
        "ELEMENT_SORT_ORDER2" => "desc",
        "FILTER_NAME" => "arrFilter",
        "HIDE_NOT_AVAILABLE" => "N",
        "IBLOCK_ID" => CATALOG_ID,
        "IBLOCK_TYPE" => "catalog",
        "INCLUDE_SUBSECTIONS" => "Y",
        "LABEL_PROP" => "-",
        "LINE_ELEMENT_COUNT" => "3",
        "MESSAGE_404" => "",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "OFFERS_CART_PROPERTIES" => array(),
        "OFFERS_FIELD_CODE" => array("", ""),
        "OFFERS_LIMIT" => "5",
        "OFFERS_PROPERTY_CODE" => array("PRODUCT_DIAM", "PRODUCT_LENGTH", "MINIMUM_PRICE", ""),
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_FIELD2" => "id",
        "OFFERS_SORT_ORDER" => "asc",
        "OFFERS_SORT_ORDER2" => "desc",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Товары",
        "PAGE_ELEMENT_COUNT" => $limit,
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRICE_CODE" => array("BASE", "RETAIL"),
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPERTIES" => array(),
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "",
        "PRODUCT_SUBSCRIPTION" => "N",
        "PROPERTY_CODE" => array("PRODUCT_TYPE", ""),
        "SECTION_ID" => $sectionID,
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SECTION_URL" => "",
        "SECTION_USER_FIELDS" => array("", ""),
        "SEF_MODE" => "N",
        "SET_BROWSER_TITLE" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "Y",
        "SHOW_404" => "N",
        "SHOW_ALL_WO_SECTION" => "N",
        "SHOW_CLOSE_POPUP" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "TEMPLATE_THEME" => "blue",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "USE_PRICE_COUNT" => "N",
        "USE_PRODUCT_QUANTITY" => "N"
    )
);

?>
