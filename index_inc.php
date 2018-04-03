<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="information-block"> 	 	 
	<div class="information-block-head">Автокеширование</div>
	Обратите внимание: по умолчанию кеширование данных <b>включено</b>. Автокеширование позволяет значительно ускорить работу демо-сайта. Изменить настройки кеширования данных на сайте можно на специальной <a href="/bitrix/admin/cache.php">странице</a>.
</div>

<!-- SOCNETWORK_GROUPS -->

<!--VOTE_FORM-->


	<div class="information-block">
		<div class="information-block-head">Фото дня</div>
		<?$APPLICATION->IncludeComponent(
	"bitrix:photo.random",
	"",
	Array("IBLOCK_TYPE" => "gallery", 
		"IBLOCKS" => Array("6"), 
		"DETAIL_URL" => "/content/photo/#SECTION_ID#/#ELEMENT_ID#/", 
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "180")
	);?></div>