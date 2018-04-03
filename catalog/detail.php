<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Каталог стоматологического оборудования и инструментов ведущих мировых производителей");
$APPLICATION->SetPageProperty("keywords", "Инструменты для стоматолога, физиодеспансер, Остеопластический материал, Стоматологические расходные материалы, импланты, формирователи, абатмент, лабораторный аналог, парадонтологические инструменты  краснодар, curaprox, bonetrust, carl-martin, hu-friedy, osstem, botiss, NSK, шовные материалы, имплантационные системы");
$APPLICATION->SetPageProperty("title", "Каталог стоматологического оборудования и инструментов ведущих мировых производителей");
$APPLICATION->SetTitle("");?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.element",
	"rossdent_catalog-inner-1",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_DETAIL_TO_SLIDER" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_TO_BASKET_ACTION" => array("ADD"),
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/cart/",
		"BRAND_USE" => "N",
		"BROWSER_TITLE" => "-",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_SECTION_ID_VARIABLE" => "N",
		"COMPONENT_TEMPLATE" => "rossdent_catalog-inner-1",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_PICTURE_MODE" => "IMG",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PREVIEW_TEXT_MODE" => "E",
		"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],
		"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "16",
		"IBLOCK_TYPE" => "catalog",
		"LABEL_PROP" => "-",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"LINK_IBLOCK_ID" => "",
		"LINK_IBLOCK_TYPE" => "",
		"LINK_PROPERTY_SID" => "",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array("PRODUCT_DIAM", "PRODUCT_LENGTH", ""),
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array("BASE","RETAIL"),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array("",""),
		"SECTION_CODE" => "",
		"SECTION_CODE_PATH" => "",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SEF_MODE" => "Y",
		"SEF_RULE" => "/catalog/#SECTION_CODE#/#ELEMENT_CODE#/",
		"SET_BROWSER_TITLE" => "Y",
		"SET_CANONICAL_URL" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SET_VIEWED_IN_COMPONENT" => "N",
		"SHOW_404" => "N",
		"SHOW_BASIS_PRICE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DEACTIVATED" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "green",
		"USE_COMMENTS" => "N",
		"USE_ELEMENT_COUNTER" => "Y",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"USE_VOTE_RATING" => "N"
	)
);?>

<!-- Social -->
<div class="box">
  <span class="ya-share2__box-title">Поделиться в социальных сетях:</span>
  <script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/vendor/share.js" charset="utf-8"></script>
  <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki"></div>
</div>

<!-- Comments -->
<div class="box">
  <div id="hypercomments_widget"></div>
  <script type="text/javascript">
  _hcwp = window._hcwp || [];
  _hcwp.push({widget:"Stream", widget_id: 73733, hc_disable: 1, quote_disable: 1});
  (function() {
  if("HC_LOAD_INIT" in window)return;
  HC_LOAD_INIT = true;
  var lang = (navigator.language || navigator.systemLanguage || navigator.userLanguage || "en").substr(0, 2).toLowerCase();
  var hcc = document.createElement("script"); hcc.type = "text/javascript"; hcc.async = true;
  hcc.src = ("https:" == document.location.protocol ? "https" : "http")+"://w.hypercomments.com/widget/hc/73733/"+lang+"/widget.js";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hcc, s.nextSibling);
  })();
  </script>
  <!-- <a href="http://hypercomments.com" class="hc-link" title="comments widget">comments powered by HyperComments</a> -->
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
