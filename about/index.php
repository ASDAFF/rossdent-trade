<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Мы являемся надежным партнером для развития стоматологического бизнеса в ЮФО");
$APPLICATION->SetPageProperty("keywords", "Инструменты для стоматолога, физиодеспансер, Остеопластический материал, Стоматологические расходные материалы, импланты, формирователи, абатмент, лабораторный аналог, парадонтологические инструменты  краснодар, curaprox, bonetrust, carl-martin, hu-friedy, osstem, botiss, NSK, шовные материалы, имплантационные системы");
$APPLICATION->SetPageProperty("title", "Росс Дент - Продажа стоматологического оборудования и расходных материалов в Краснодаре и ЮФО");
$APPLICATION->SetTitle("О компании Россдент");
?><section class="catalog about">
    <div class="box">
        <hr class="catalog__hr">
        <div class="catalog__header" id="about">
            О компании
        </div>
    </div>
    <div class="box">
        <div class="catalog__text">
            <p>
                Росс-Дент Трейд — компания, которая объединила в себе два направления: <a href="http://trade.rossdent.ru/practic-centr/">практический центр</a> и <a href="http://trade.rossdent.ru/catalog/implant-bonetrust?first-menu-mobile=y">торговую фирму</a>.
            </p>
            <p>
                Основной деятельностью компании Росс-Дент Трейд является дентальная имплантация и в ее портфеле бренды мирового уровня:
            </p>
            <p>
            </p>
            <ul>
                <li>Geistlich</li>
                <li>BoneTrust</li>
                <li>Hu-Friedy</li>
                <li>KaVo и др.&nbsp;</li>
            </ul>
            Это позволяет обеспечивать всем необходимым хирургов и ортопедов Юга России, работающих в области стоматологической имплантологии.<br>
            <p>
            </p>
            <p>
                <a href="http://trade.rossdent.ru/practic-centr/">Практик-Центр Росс-Дент</a> предоставляет возможность выбора курсов для разного уровня профессиональной подготовки врачей-стоматологов и проводит обучение по направлениям: стоматология хирургическая (имплантология); стоматология ортопедическая; стоматология терапевтическая; зуботехническая лаборатория; управление клиникой
            </p>
            <p>
                Мощная материально-техническая база Центра, соответствующая самым высоким современным стандартам, позволяет обеспечить высокопрофессиональную подготовку специалистов. Практик-класс оснащен европейским стоматологическим зуботехническим оборудованием; практические занятия проходят с использованием самых современных расходных материалов.
            </p>
            <p>
                <a href="http://trade.rossdent.ru/practic-centr/lektors/">Преподавательский состав</a> — высококвалифицированные врачи-имплантологи и зубные техники с колоссальным опытом!<br>
            </p>
        </div>
    </div>
</section>
<?
global $arrFilterNews;
$arrFilterNews = Array("PROPERTY_NEWS_PUBLIC" => 106); // YES
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "rossdent_horizontal",
    array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "COMPONENT_TEMPLATE" => "rossdent_horizontal",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array(
            0 => "SHOW_COUNTER",
            1 => "",
        ),
        "FILTER_NAME" => "arrFilterNews",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "8",
        "IBLOCK_TYPE" => "news",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "Y",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "6",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO"
    ),
    false
);?> <?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "rossdent_reviews-list",
    array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "COMPONENT_TEMPLATE" => "rossdent_reviews-list",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "21",
        "IBLOCK_TYPE" => "review",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "Y",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "3",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(
            0 => "REVIEW_JOB",
            1 => "REVIEW_FIO",
            2 => "",
        ),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO"
    ),
    false
);?> <section class="catalog contacts contacts-about bg-white">
<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "COMPONENT_TEMPLATE" => ".default",
        "EDIT_TEMPLATE" => "",
        "PATH" => "/include/map.php"
    )
);?> </section><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>