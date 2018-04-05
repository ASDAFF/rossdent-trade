<?
$APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list",
    "top.new.catalog",
    array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => 16,
        "SECTION_ID" => "",
        "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_GROUPS" => "Y",
        "COUNT_ELEMENTS" => "N",
        "TOP_DEPTH" => "1",
        "SECTION_URL" => "/catalog/#SECTION_CODE#",
        "VIEW_MODE" => "LINE",
        "SHOW_PARENT_NAME" => "Y",
        "HIDE_SECTION_NAME" => "Y",
        "ADD_SECTIONS_CHAIN" => "Y"
    ),
    $component,
    array("HIDE_ICONS" => "Y")
);?>