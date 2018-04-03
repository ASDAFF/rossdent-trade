<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Помощь и поддержка наших партнеров, пользующихся нашими услугами.");
$APPLICATION->SetPageProperty("description", "Получайте информацию о наших мероприятиях, обучающих курсах, акциях и спецпредложениях, новинок компании.");
$APPLICATION->SetPageProperty("keywords", "клуб стоматологов, краснодар");
$APPLICATION->SetTitle("Россдент | Клуб");
?>
<?if (!$USER->IsAuthorized()) {LocalRedirect('/personal/?register=yes', 301);}?>
<section class="catalog doctor">
<div class="box">
	<hr class="catalog__hr">
	<div class="catalog__header">
		 ДОБРО ПОЖАЛОВАТЬ<br>
		 В КЛУБ «РОСС-ДЕНТ»
	</div>
	<div class="catalog__text">
		<p>
			 Основная задача нашего клуба - помощь и поддержка наших партнеров, пользующихся нашими услугами.
		</p>
		<p>
			 В клубе представлены основные разделы, призванные обеспечить максимально быстрое взаимодействие и получение информации по интересующему вопросу. Консультации специалистов по использованию того или иного материала, помощь в планировании и много другое.
		</p>
		<p>
			 У вас будет возможность одними из первых получать информацию о наших мероприятиях, обучающих курсах, акциях и спецпредложениях, новинок компании.
		</p>
	</div>
</div>
</section>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"rossdent_club-worker",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "rossdent_club-worker",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"",1=>"",),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "17",
		"IBLOCK_TYPE" => "workers",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"JOB",1=>"",),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC"
	)
);?>

<?
$APPLICATION->IncludeComponent(
  "bitrix:main.include",
  ".default",
  Array(
    "AREA_FILE_SHOW" => "file",
    "AREA_FILE_SUFFIX" => "inc",
    "COMPONENT_TEMPLATE" => ".default",
    "EDIT_TEMPLATE" => "",
    "PATH" => "/bitrix/templates/rossdent/include_areas/next_action.php"
  )
);?>


<?
$arFillter = array(
	"PROPERTY_NEWS_IN_CLUB" => 6
);
$APPLICATION->IncludeComponent(
 "bitrix:news.list",
 "rossdent_club-article",
 Array(
	 "ACTIVE_DATE_FORMAT" => "d.m.Y",
	 "ADD_SECTIONS_CHAIN" => "Y",
	 "AJAX_MODE" => "N",
	 "AJAX_OPTION_ADDITIONAL" => "",
	 "AJAX_OPTION_HISTORY" => "N",
	 "AJAX_OPTION_JUMP" => "N",
	 "AJAX_OPTION_STYLE" => "Y",
	 "CACHE_FILTER" => "N",
	 "CACHE_GROUPS" => "Y",
	 "CACHE_TIME" => "36000000",
	 "CACHE_TYPE" => "A",
	 "CHECK_DATES" => "Y",
	 "COMPONENT_TEMPLATE" => ".default",
	 "DETAIL_URL" => "",
	 "DISPLAY_BOTTOM_PAGER" => "Y",
	 "DISPLAY_DATE" => "Y",
	 "DISPLAY_NAME" => "Y",
	 "DISPLAY_PICTURE" => "Y",
	 "DISPLAY_PREVIEW_TEXT" => "Y",
	 "DISPLAY_TOP_PAGER" => "N",
	 "FIELD_CODE" => array("", ""),
	 "FILTER_NAME" => "arFillter",
	 "HIDE_LINK_WHEN_NO_DETAIL" => "N",
	 "IBLOCK_ID" => "8",
	 "IBLOCK_TYPE" => "news",
	 "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
	 "INCLUDE_SUBSECTIONS" => "Y",
	 "MESSAGE_404" => "",
	 "NEWS_COUNT" => "20",
	 "PAGER_BASE_LINK_ENABLE" => "N",
	 "PAGER_DESC_NUMBERING" => "N",
	 "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	 "PAGER_SHOW_ALL" => "N",
	 "PAGER_SHOW_ALWAYS" => "N",
	 "PAGER_TEMPLATE" => ".default",
	 "PAGER_TITLE" => "Новости",
	 "PARENT_SECTION" => "",
	 "PARENT_SECTION_CODE" => "",
	 "PREVIEW_TRUNCATE_LEN" => "",
	 "PROPERTY_CODE" => array("NEWS_TYPE", "NEWS_IN_CLUB", ""),
	 "SET_BROWSER_TITLE" => "Y",
	 "SET_LAST_MODIFIED" => "N",
	 "SET_META_DESCRIPTION" => "Y",
	 "SET_META_KEYWORDS" => "Y",
	 "SET_STATUS_404" => "N",
	 "SET_TITLE" => "Y",
	 "SHOW_404" => "N",
	 "SORT_BY1" => "ACTIVE_FROM",
	 "SORT_BY2" => "SORT",
	 "SORT_ORDER1" => "DESC",
	 "SORT_ORDER2" => "ASC"
 )
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
