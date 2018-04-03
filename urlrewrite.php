<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/practic-centr/raspisanie-master-klassov/master-klassy/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/practic-centr/raspisanie-master-klassov/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/([\\w\\d-_]+)/([\\w\\d-_]+)?(.*)#",
		"RULE" => "SECTION_CODE=\$1&ELEMENT_CODE=\$2&\$3",
		"ID" => "",
		"PATH" => "/catalog/detail.php",
	),
	array(
		"CONDITION" => "#^/catalog/([^/]+?)/([^/]+?)/\\??(.*)#",
		"RULE" => "SECTION_CODE=\$1&ELEMENT_CODE=\$2&\$3",
		"ID" => "bitrix:catalog.element",
		"PATH" => "/catalog/detail.php",
	),
	array(
		"CONDITION" => "#^/include/catalog_list.php\\?(?)#",
		"RULE" => "\$1&\$2",
		"ID" => "",
		"PATH" => "/include/catalog_list.php",
	),
	array(
		"CONDITION" => "#^/bitrix/services/ymarket/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/bitrix/services/ymarket/index.php",
	),
	array(
		"CONDITION" => "#^/practic-centr/lektors/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/practic-centr/lektors/index.php",
	),
	array(
		"CONDITION" => "#^/courses/([\\w\\d-_]+)#",
		"RULE" => "ELEMENT_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/courses/detail.php",
	),
	array(
		"CONDITION" => "#^/reviews/([\\w\\d-_]+)#",
		"RULE" => "ID=\$1&\$2",
		"ID" => "",
		"PATH" => "/reviews/detail.php",
	),
	array(
		"CONDITION" => "#^/catalog/([\\w\\d-_]+)#",
		"RULE" => "SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/catalog/list.php",
	),
	array(
		"CONDITION" => "#^/courses/schedule/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/courses/schedule/index.php",
	),
	array(
		"CONDITION" => "#^/media/([\\w\\d-_]+)#",
		"RULE" => "ELEMENT_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/media/detail.php",
	),
	array(
		"CONDITION" => "#^/news/([\\w\\d-_]+)#",
		"RULE" => "ELEMENT_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/news/detail.php",
	),
	array(
		"CONDITION" => "#^/content/gallery/#",
		"RULE" => "",
		"ID" => "bitrix:photogallery_user",
		"PATH" => "/content/gallery/index.php",
	),
	array(
		"CONDITION" => "#^/frezernyy-centr#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/frezernyy-centr.php",
	),
	array(
		"CONDITION" => "#^/content/photo/#",
		"RULE" => "",
		"ID" => "bitrix:photogallery",
		"PATH" => "/content/photo/index.php",
	),
	array(
		"CONDITION" => "#^/service/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/service/index.php",
	),
	array(
		"CONDITION" => "#^/account#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/account.php",
	),
	array(
		"CONDITION" => "#^/forum/#",
		"RULE" => "",
		"ID" => "bitrix:forum",
		"PATH" => "/forum/index.php",
	),
	array(
		"CONDITION" => "#^/club/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/club/index.php",
	),
	array(
		"CONDITION" => "#^/form/#",
		"RULE" => "",
		"ID" => "bitrix:form.result.new",
		"PATH" => "/form/index.php",
	),
	array(
		"CONDITION" => "#^/help#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/help.php",
	),
);

?>