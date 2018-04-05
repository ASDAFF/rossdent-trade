<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Каталог стоматологического оборудования и инструментов ведущих мировых производителей.");
$APPLICATION->SetPageProperty("keywords", "Инструменты для стоматолога, физиодеспансер, Остеопластический материал, Стоматологические расходные материалы, импланты, формирователи, абатмент, лабораторный аналог, парадонтологические инструменты  краснодар, curaprox, bonetrust, carl-martin, hu-friedy, osstem, botiss, NSK, шовные материалы, имплантационные системы");
$APPLICATION->SetPageProperty("title", "Каталог стоматологического оборудования и инструментов ведущих мировых производителей");
$APPLICATION->SetTitle("Россдент | Каталог");

use \Bitrix\Main\Web\Cookie;

# Include catalog menu
$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "COMPONENT_TEMPLATE" => ".default",
        "EDIT_TEMPLATE" => "",
        //"PATH" => "/bitrix/templates/rossdent/include_areas/catalog.php"
        "PATH" => "/bitrix/templates/rossdent/include_areas/catalog-new.php"
    )
);

$LASTPAGE = null;
$stop_rewrite_cookie = false;

$ref = trim(parse_url($_SERVER['HTTP_REFERER'])['path'],'/');
$cur = trim($APPLICATION->GetCurPage(), '/');
$http_reffer = (explode('/', $ref));
$from_detail = sizeof($http_reffer)==3;
if ($from_detail) {

    $code = $http_reffer[2];
    $sel_id = 0;
    \Bitrix\Main\Loader::includeModule('iblock');
    $res = CIBlockElement::GetList(false, array('IBLOCK_ID'=>16, 'CODE'=>$code));
    if ($res->SelectedRowsCount() == 1) {
        $prod = $res->GetNext();
        $sel_id = $prod['ID'];
    }

    $context = \Bitrix\Main\Context::getCurrent();
    $request = $context->getRequest();
    $LASTPAGE = $request->getCookie('LP');
    ?>
    <script>
        var prod_id=<?=(int)$sel_id;?>;
        <?
        if ($LASTPAGE) {
            $_GET['PAGEN_1'] = $_REQUEST['PAGEN_1'] = $LASTPAGE;
            $stop_rewrite_cookie = true;
            ?>
            var lastpage_ref = <?=$LASTPAGE;?>;
            <?
        }
        ?>
    </script><?
} else if (sizeof($http_reffer) == 2 && $cur != $ref) {
    $context = \Bitrix\Main\Context::getCurrent();
    $response = $context->getResponse();
    $c = new Cookie('LP', '');
    $response->addCookie($c);
    $response->flush();
}

# Prepare info for opened section.
$section = null;
$sectionID = 0;
$sectionTitle = "";
$sectionDescription = "";
$sectionCount = 0;
$limit = 6;

// Фильтрация
$filterSort = isset($_GET['sort']) ? $_GET['sort'] : 'sort';
$filterOrder = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Узнаем количество товаров на страницу
$limit = isset($_GET['limit']) ? $_GET['limit'] : $limit;

// Получаем имя секции
if (isset($_GET["SECTION_ID"])) {

    $sectionID = $_GET["SECTION_ID"];
    $res = CIBlockSection::GetByID($_GET["SECTION_ID"]);
    if ($section = $res->getNext()) {
        $sectionTitle = $section['NAME'];
        $sectionDescription = $section['DESCRIPTION'];
    }

} elseif (isset($_GET["SECTION_CODE"])) {

    $sections = CIBlockSection::GetList(
        Array("SORT" => "ASC"),
        Array("IBLOCK_ID" => 16, "ACTIVE" => "Y"),
        false,
        Array(),
        false
    );

    while ($section = $sections->getNext()) {

        if ($section['CODE'] == $_GET["SECTION_CODE"]) {
            $sectionID = $section['ID'];
            $sectionTitle = $section['NAME'];
            $sectionDescription = $section['DESCRIPTION'];
            break;
        }
    }
}

$sectionCount = CIBlockElement::GetList(Array(),
    Array("IBLOCK_ID" => 16,
        "SECTION_ID" => $sectionID,
        "INCLUDE_SUBSECTIONS" => "Y",
        "ACTIVE" => "Y"),
    Array()
);
?>

<?
    $show = false;
$a = CIBlockSection::GetNavChain(16, $sectionID);
while($r = $a->Fetch()) {
    if ($r['ID'] == 411) {
        $show = true;
    }
}
if ($show) {
    ?><div class="dent_info_message">Указанные цены действуют только для аптек и организаций, занимающихся стоматологической практикой.</div><?
}
?>

<section id='catalog-view' class="catalog-view">
    <div class="box">
        <div class="catalog-view__header">
            <?//= $sectionTitle ?>
            <div>
                <a href="?sort=<?= $filterSort ?>&order=<?= $filterOrder ?>&limit=6"
                   class="catalog-view__filter <?= ($limit == 6) ? 'catalog-view__filter--active' : '' ?>">по 6</a>
                <a href="?sort=<?= $filterSort ?>&order=<?= $filterOrder ?>&limit=18"
                   class="catalog-view__filter <?= ($limit == 18) ? 'catalog-view__filter--active' : '' ?>">по 18</a>
                <a href="?sort=<?= $filterSort ?>&order=<?= $filterOrder ?>&limit=36"
                   class="catalog-view__filter <?= ($limit == 36) ? 'catalog-view__filter--active' : '' ?>">по 36</a>
                <a href="?sort=<?= $filterSort ?>&order=<?= $filterOrder ?>&limit=200"
                   class="catalog-view__filter <?= ($limit == 200) ? 'catalog-view__filter--active' : '' ?>">Все</a>
            </div>
        </div>
        <div class="catalog-view__items" data-count="<?= $sectionCount ?>" data-limit="<?= $limit ?>"
             data-section-id="<?= $sectionID ?>">

            <? $APPLICATION->IncludeFile("/include/catalog_list.php", array("lastpage" => $LASTPAGE, "stop_rewrite_cookie" => $stop_rewrite_cookie)); ?>

        </div>
        <a id="catalog-show-more" href="#" class="btn-green-border">Показать еще</a>
    </div>
</section>


<? if (strlen($sectionDescription) > 0): ?>
    <section class="catalog about">
        <div class="box">
            <hr class="catalog__hr">
            <div class="catalog__header">
                <?= $sectionTitle ?>
            </div>
        </div>
        <div class="box">
            <div class="catalog__text">
                <?= $sectionDescription ?>
            </div>
        </div>
    </section>
<? endif ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
