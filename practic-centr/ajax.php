<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("");?><?
// Без этого не работает фильтр
global $arFilter;

// Определяем месяц для показа
$selectMonth = (!isset($_REQUEST['month']) || ($_REQUEST['month'] > 12 && $_REQUEST['month'] < 1)) ? date('n') : $_REQUEST['month'];


// Формируем фильтр
if ($selectMonth < 10) {
	$arFilter = Array(
		'>=PROPERTY_LESSON_DATE' => date("2017-0".$selectMonth."-01"),
	  '<=PROPERTY_LESSON_DATE' => date("2017-0".$selectMonth."-t")
	);
} else {
	$arFilter = Array(
		'>=PROPERTY_LESSON_DATE' => date("2017-".$selectMonth."-01"),
	  '<=PROPERTY_LESSON_DATE' => date("2017-".$selectMonth."-t")
	);
}


// Выводим курсы
$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"rossdent_lessons", 
	array(
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
		"COMPONENT_TEMPLATE" => "rossdent_lessons",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "arFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "20",
		"IBLOCK_TYPE" => "lessons",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "",
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
		"PROPERTY_CODE" => array(
			0 => "LESSON_COUNTRY",
			1 => "LESSON_COUNTRY_FULL",
			2 => "LESSON_DATE",
			3 => "LESSON_TEACHER",
			4 => "LESSON_LINE",
			5 => "LESSON_ORGANIZER",
			6 => "LESSON_PRICE",
			7 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "PROPERTY_LESSON_DATE",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	),
	false
);?>