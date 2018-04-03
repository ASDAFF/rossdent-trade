<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");?>

<?$APPLICATION->IncludeComponent("bitrix:search.page", "search", Array(
	"RESTART" => "N",	// Искать без учета морфологии (при отсутствии результата поиска)
		"CHECK_DATES" => "Y",	// Искать только в активных по дате документах
		"arrWHERE" => array(	// Значения для выпадающего списка "Где искать"
			0 => "forum",
			1 => "iblock_news",
			2 => "iblock_articles",
			3 => "iblock_books",
			4 => "blog",
		),
		"arrFILTER" => array(	// Ограничение области поиска
			0 => "no",
		),
		"SHOW_WHERE" => "Y",	// Показывать выпадающий список "Где искать"
		"PAGE_RESULT_COUNT" => "10",	// Количество результатов на странице
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"TAGS_SORT" => "NAME",	// Сортировка тегов
		"TAGS_PAGE_ELEMENTS" => "20",	// Количество тегов
		"TAGS_PERIOD" => "",	// Период выборки тегов (дней)
		"TAGS_URL_SEARCH" => "",	// Путь к странице поиска (от корня сайта)
		"TAGS_INHERIT" => "Y",	// Сужать область поиска
		"SHOW_RATING" => "Y",	// Включить рейтинг
		"FONT_MAX" => "50",	// Максимальный размер шрифта (px)
		"FONT_MIN" => "10",	// Минимальный размер шрифта (px)
		"COLOR_NEW" => "000000",	// Цвет позднего тега (пример: "C0C0C0")
		"COLOR_OLD" => "C8C8C8",	// Цвет раннего тега (пример: "FEFEFE")
		"PERIOD_NEW_TAGS" => "",	// Период, в течение которого считать тег новым (дней)
		"SHOW_CHAIN" => "Y",	// Показывать цепочку навигации
		"COLOR_TYPE" => "Y",	// Плавное изменение цвета
		"WIDTH" => "100%",	// Ширина облака тегов (пример: "100%" или "100px", "100pt", "100in")
		"PATH_TO_USER_PROFILE" => "#SITE_DIR#people/user/#USER_ID#/",	// Шаблон пути к профилю пользователя
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>