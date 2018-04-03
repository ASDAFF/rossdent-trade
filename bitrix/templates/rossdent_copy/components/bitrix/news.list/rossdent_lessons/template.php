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
        <article class="lesson-item">
            <div class="lesson-item__date">
                <?
                $d1=new DateTime($arItem['PROPERTIES']['LESSON_DATE']['VALUE']);
                echo $d1->format('j ');
                echo $month[$d1->format('n')]?>
            </div>
            <div class="lesson-item__title">
                <?=$arItem['NAME']?>
            </div>
            <div class="lesson-item__table">
                <div class="lesson-item__table-item">
                    <div class="lesson-item__table-item-title">
                        Город
                    </div>
                    <div class="lesson-item__table-item-text">
                        <?=$arItem['PROPERTIES']['LESSON_COUNTRY']['VALUE']?>
                    </div>
                </div>
                <div class="lesson-item__table-item">
                    <div class="lesson-item__table-item-title">
                        Лектор
                    </div>
                    <div class="lesson-item__table-item-text">
                        <?=$arItem['PROPERTIES']['LESSON_TEACHER']['VALUE']?>
                    </div>
                </div>
                <div class="lesson-item__table-item">
                    <div class="lesson-item__table-item-title">
                        Организатор
                    </div>
                    <div class="lesson-item__table-item-text">
                        <?=$arItem['PROPERTIES']['LESSON_ORGANIZER']['VALUE']?>
                    </div>
                </div>
          
               
                <div class="lesson-item__table-item">
                    <div class="lesson-item__table-item-title">
                        Цена
                    </div>
                    <div class="lesson-item__table-item-text">
                        <?=$arItem['PROPERTIES']['LESSON_PRICE']['VALUE']?>
                    </div>
                </div>
            </div>
            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" style="margin-top: 16px;" class="btn-green-border">Подробнее</a>
        </article>
    <?endforeach?>

<?else:?>
    <article class="lesson-item">
        На этот месяц мероприятий учебного центра не запланировано.
    </article>
<?endif?>