<?php

global $APPLICATION;
$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"bitrix:menu.sections",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DEPTH_LEVEL" => "1",
		"IBLOCK_ID" => CATALOG_ID,
		"IBLOCK_TYPE" => "catalog",
		"IS_SEF" => "Y",
		"SECTION_PAGE_URL" => "/#SECTION_CODE#",
		"SEF_BASE_URL" => "/catalog",
		"SECTION_URL" => ""
	)
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>