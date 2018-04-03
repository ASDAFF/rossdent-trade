<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if ($arParams['HOW_INC'] == 'local') {
	$APPLICATION->AddHeadScript($templateFolder.'/assests/share.js');
} else {
	$APPLICATION->AddHeadScript("//yastatic.net/share/share.js");
}
?>