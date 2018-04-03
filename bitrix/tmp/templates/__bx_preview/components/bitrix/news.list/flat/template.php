
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

$month = [1 => "Января",
2 => "Февраля",
3 => "Марта",
4 => "Апреля",
5 => "Мая",
6 => "Июня",
7 => "Июля",
8 => "Августа",
9 => "Сентября",
10 => "Октября",
11 => "Ноября",
12 => "Декабря",]
?>

<?if(count($arResult['ITEMS']) > 0):?>

<?foreach($arResult["ITEMS"] as $arItem):?>
<article class="lesson-item lesson-item-new">
	<div class="lesson-item__date">
		<?if ($arItem["PROPERTIES"]["LESSON_DATE_END"]['VALUE']): //Условие, проверяющее, заполнено ли свойство?>

		<? $d1=new DateTime($arItem['PROPERTIES']['LESSON_DATE']['VALUE']);
		echo $d1->format('j ');
		echo $month[$d1->format('n')]?> - <?
		$d2=new DateTime($arItem['PROPERTIES']['LESSON_DATE_END']['VALUE']);
		echo $d2->format('j ');
		echo $month[$d2->format('n')]?>, <?=$arItem['PROPERTIES']['LESSON_COUNTRY']['VALUE']?>

		<?else:?>

		<? 
		$d1=new DateTime($arItem['PROPERTIES']['LESSON_DATE']['VALUE']);
		echo $d1->format('j ');
		echo $month[$d1->format('n')]?>, <?=$arItem['PROPERTIES']['LESSON_COUNTRY']['VALUE']?>

		<?endif //конец условия?>
	</div>


	<div class="lesson-item__title">
		<?=$arItem['NAME']?>
	</div>
	<div class="lesson-item__description">
		<?=$arItem['PREVIEW_TEXT']?>
	</div>

	<div class="lesson-item__place">
		<span>Место проведения: </span>
		<?=$arItem['PROPERTIES']['LESSON_COUNTRY_FULL']['VALUE']?>
	</div>
	<div class="lesson-item__time">
		<!-- <span>Время проведения: </span><?=$arItem['PROPERTIES']['LESSON_TIME']['VALUE']?> -->

		<?if($arItem['PROPERTIES']['LESSON_TIME']['VALUE']): //Условие, проверяющее, заполнено ли свойство?>
		<!--Общий див с названием и значением свойства открывается-->
		<span>Время проведения: </span><!--Див с названием свойства-->
		<?=$arItem['PROPERTIES']['LESSON_TIME']['VALUE']?><!--Див со значением свойства-->
		<!--Общий див с названием и значением свойства закрывается-->
		<?endif //конец условия?>


	</div>
	<div class="lesson-item__lector">
		<div class="lesson-item__table-item-text">
			<?foreach($arItem["PROPERTIES"]["LESSON_LECTOR"]["VALUE"] as $analog):?> 
			<?$res = CIBlockElement::GetByID($analog);
			?> 
			<?if($ar_res = $res->GetNext())?> 
			<div class="consultant_item">
			<img class="consultant__avatar consultant__avatar_mini" src="<?=CFile::GetPath($ar_res["PREVIEW_PICTURE"])?>">
			<div class="consultant__name consultant__name_mini">
				<?=$ar_res['NAME']?>
			</div>
			<div class="consultant__description">
				<?=$ar_res['PROPERTIES']['JOB']['VALUE']?> 
			</div>
			</div>
			<?endforeach;?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="lesson-item__btn">
		<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="btn-green-border" target="_blank">Подробнее</a>
	</div>
</article>
<?endforeach?>
<?else:?>
<article class="lesson-item">
	По заданным параметрам мероприятий учебного центра не найдено.
</article>
<?endif?>
