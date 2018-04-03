<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");
?>

<div class="page-404 background-green">
	<span class="page-404__404">404</span>
	<span class="page-404__text">Такой страницы не существует</span>
	<br>
	<br>
	<a href="/" class="page-404__btn btn-green-border btn-green-border--white">
		На главную страницу
	</a>
</div>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
