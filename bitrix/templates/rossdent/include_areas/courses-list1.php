<section class="section-lessons">
<div class="box">
	<hr class="catalog__hr">
	<div id="courses" class="catalog__header">
		Расписание на 2017
	</div>


	<?// Выводим месяца для десктопа?>
	<div class="months">
		<?
		$months = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь",);

		$selectMonth;
		if (isset($_GET['month']) && $_GET['month'] > 0 && $_GET['month'] < 13) {
			$selectMonth = $_GET['month'];
		} else {
			$selectMonth = date('n');
		}

		foreach ($months as $monthId => $month):?>
			<a data-month="<?=($monthId+1)?>" class="months__item <?if(($selectMonth - 1) == $monthId) echo "months__item--select"?>"><?=$month?></a>
		<?endforeach?>
	</div>

	<?//Выводим месяца для мобильника?>
	<div class="select select--green js-lesson-months">
	    <input data-value="0" readonly="" class="select__input" value="<?=$months[$selectMonth-1]?>">
	    <div class="select__arrow"></div>
	    <div class="select__items select__items--close">
				<?foreach ($months as $monthId => $month):?>
					<a data-value="<?=($monthId+1)?>" class="select__item" onclick=""><?=$month?></a>
				<?endforeach?>
	    </div>
	</div>

	<?//Выводим список курсов?>
	<div class="lesson">
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			".default",
			Array(
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"COMPONENT_TEMPLATE" => ".default",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/courses/ajax1.php"
			)
		);?>
	</div>

</div>
</section>
