<?php
$brand_id = (int)trim(strip_tags($arResult['PROPERTIES']['ID_BRAND']['VALUE']));
$arResult['PAGE'] = ($_REQUEST['PAGEN_1']) ? $_REQUEST['PAGEN_1'] : 1;
$arSections = array();
$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL","PREVIEW_PICTURE","DETAIL_PICTURE","PREVIEW_TEXT","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array("IBLOCK_ID" => CATALOG_ID, "ACTIVE"=>"Y","PROPERTY_CML2_MANUFACTURER" => array("ID" => $brand_id));
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, Array('iNumPage' => $arResult['PAGE'], 'nPageSize' => 24, 'checkOutOfRange' => true), $arSelect);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
    $arResult['ITEMS'][$arFields['ID']] = $arFields;
    $arResult['ITEMS'][$arFields['ID']]['PRICE'] = priceDiscount($arFields['ID']);
    $arProps = $ob->GetProperties();
    $arResult['ITEMS'][$arFields['ID']]['PROPERTIES'] = $arProps;

    $arSections['ID'][$arFields['IBLOCK_SECTION_ID']] = $arFields['IBLOCK_SECTION_ID'];
}
$arResult['PAGES'] = (ceil($res->SelectedRowsCount()/24));


foreach($arSections['ID'] as $section){
    $res = CIBlockSection::GetByID($section);
    if($ar_res = $res->GetNext())
        $arResult['SECTIONS'][$section] = $ar_res;
}

