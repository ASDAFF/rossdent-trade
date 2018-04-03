<div class="header__item-left">
 <a href="#" class="hamburger"></a>
	<div class="header__text">
		 Надежный партнер для развития<br>
		 стоматологического бизнеса
	</div>
</div>
<h3 class="header__item-center">
<?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        ".default",
        Array(
          "AREA_FILE_SHOW" => "file",
          "AREA_FILE_SUFFIX" => "inc",
          "COMPONENT_TEMPLATE" => ".default",
          "EDIT_TEMPLATE" => "",
          "PATH" => "/bitrix/templates/rossdent/include_areas/header-number.php"
        )
      );?>
<a href="/contacts" class="btn-green-border">Контакты</a></h3>
<div>
	 <?include "avatar.php";?>
</div>