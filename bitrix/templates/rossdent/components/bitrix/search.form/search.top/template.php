<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="search-form input-group">

<form action="<?=$arResult["FORM_ACTION"]?>">

	<input type="text" name="q" value="<?=$_REQUEST['q']?>" placeholder="Поиск" size="26" maxlength="50" class="form-control" />
	<span class="input-group-btn">
		<button name="s" type="submit"></button>
	</span>

</form>

</div>