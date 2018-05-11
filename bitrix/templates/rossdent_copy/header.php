<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <meta name="theme-color" content="#a4cd3e">
    <meta name="cmsmagazine" content="05873d095917ef72a757d3224c3c32cf" />
    <title><?$APPLICATION->ShowTitle()?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <?$APPLICATION->ShowHead();?>
    <script src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/script/jquery.cookie.js"></script>
    <link rel="stylesheet" href="/bitrix/css/main/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.2.7/css/swiper.min.css">
    <link rel="stylesheet" href="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/style/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/style/font.css">
    <link rel="stylesheet" href="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/style/normalize.css">
    <link rel="stylesheet" href="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/style/main.css">
    <link rel="stylesheet" href="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/style/media.css">
</head>
<body>

	<div class="f-form">
		<a href="/question/">
			<div class="f-header">
				<img src="/images/icons/conversation.png">
			</div>
			<div class="f-body">
				<div class="f-text">Задать</div>
				<div class="f-text">Вопрос</div>
			</div>
		</a>
	</div>


<?
$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	".default",
	Array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/include/basket-mobile.php"
	)
);?>

<script>
	$(function(){
		var panel = $('#panel');
		panel.toggleClass('hiddenz');
		$(document).keypress("z",function(e) {
			if(e.ctrlKey && e.keyCode == '26') {
				console.dir(e);
				console.dir('ctrl+z pressed');
				panel.toggleClass('hiddenz');
			}
		});
	});
</script>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>

<aside class="menu">
  <div id="menu">
    <div id="top" class="airSticky">
      <a href="/" class="logo"></a>

        <?
        $APPLICATION->IncludeComponent(
          "bitrix:main.include",
          ".default",
          Array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "COMPONENT_TEMPLATE" => ".default",
            "EDIT_TEMPLATE" => "",
            "PATH" => "/include/basket.php"
          )
        );?>

      <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"rossdent_menu", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "content_menu",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "rossdent_menu",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>

<!--     <?if(!$USER->IsAuthorized()):?>
    <div class="menu__banner">
        <div class="img-and-text">
            <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/club.png">
            <span class="img-and-text__text">
                Клуб<br>
                росс-дент
            </span>
        </div>
        <div class="menu__banner-text">
            Неограниченная консультация<br>
            со специалистами клиники,<br>
            лекции и мастер-классы
        </div>
        <a href="/personal/?register=yes" class="btn-white">
            Записаться в клуб
        </a>
    </div>
    <?endif?> -->
  </div>

  <div class="copyright">
  <div class="social">
      <a target="_blank" href="http://vkontakte.ru/id135912633"><img src="/upload/iblock/80d/social-vk.png" alt="ВКонтакте" class="social__icon"></a>
      <a target="_blank" href="https://business.facebook.com/RossDentPraktik/?business_id=485298995165602&ref=bookmarks "><img src="/upload/iblock/068/social-facebook.png" alt="Facebook" class="social__icon"></a>
      <a target="_blank" href="https://www.instagram.com/rossdentpraktik/"><img src="/upload/iblock/a4b/insta.png" alt="Instagram" class="social__icon"></a>
  </div>
<!--     <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"rossdent_social-groups", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
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
		"COMPONENT_TEMPLATE" => "rossdent_social-groups",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
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
		"IBLOCK_ID" => "22",
		"IBLOCK_TYPE" => "icons",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
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
			0 => "SOCIAL_LINK",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC"
	),
	false
);?> -->
    © 2015 ROSSDENT.<br>
    Все права защищены
  </div>
</div>
</aside>

<div class="menu__back"></div>

<div class="content">
  <header class="header">
	<div class="box top">
		  <div class="top-slogan">
			  <?= tplvar('TOP_DESC', true);?>
		  </div>

		  <div class="number-phone-top">

			<div class="mobile-number" onclick="$('.number-phone-top').toggleClass('active')">
				<img src="/bitrix/templates/<?=SITE_TEMPLATE_ID?>/img/call.png" class="">
					<?= tplvar('PHONE_t1', true);?>
				<img src="/bitrix/templates/rossdent/img/arrow-down.png">
			</div>

			<ul class="">
				<li>
					<a href="tel:<?= tplvar('PHONE_t1', true);?>">
						<img src="/bitrix/templates/<?=SITE_TEMPLATE_ID?>/img/call.png" class="">
						<?= tplvar('PHONE_t1', true);?>
					</a>
				</li>
				<li>
					<a href="tel:<?= tplvar('PHONE_t2', true);?>">
						<img src="/bitrix/templates/<?=SITE_TEMPLATE_ID?>/img/call.png" class="">
						<?= tplvar('PHONE_t2', true);?>
					</a>
				</li>

			</ul>
		  </div>


		<?include $_SERVER['DOCUMENT_ROOT']."/bitrix/templates/rossdent/include_areas/avatar.php";?>
	</div>

	  <div class="box">
		  <?$APPLICATION->IncludeComponent(
			  "bitrix:main.include",
			  ".default",
			  Array(
				  "AREA_FILE_SHOW" => "file",
				  "AREA_FILE_SUFFIX" => "inc",
				  "COMPONENT_TEMPLATE" => ".default",
				  "EDIT_TEMPLATE" => "",
				  "PATH" => "/bitrix/templates/rossdent/include_areas/header-top.php"
			  )
		  );?>

		  <?$APPLICATION->IncludeComponent("bitrix:search.form", "search.top", Array(
			  "COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
			  "COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
			  "PAGE" => "#SITE_DIR#search/index.php",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
			  "USE_SUGGEST" => "N",	// Показывать подсказку с поисковыми фразами
		  ),
			  false
		  );?>
	  </div>
  </header>

  <div class="content__main practic-centr">
<div class="box">
  <hr class="catalog__hr catalog__hr_left_mobile">
  <div class="catalog__header">
  	<?=($APPLICATION->GetCurPage() == "/service/") ? "Сервис" : "Практик-центр";?> «Росс-Дент»
     <div class="header-social-links">
     <a href="https://business.facebook.com/RossDentPraktik/?business_id=485298995165602&ref=bookmarks " target="_blank"><img src="/images/icons/h_fb.png" alt="Facebook"></a>
     <a href="https://www.instagram.com/rossdentpraktik/" target="_blank"><img src="/images/icons/h_inst.png" alt="Instagram"></a>
     </div>
  </div>

  <div class="content-menu hidden-xs hidden-sm">
		<?$APPLICATION->IncludeComponent("bitrix:menu","practic_centr_menu",Array(
				"ROOT_MENU_TYPE" => "content_menu",
				"MAX_LEVEL" => "1",
				"CHILD_MENU_TYPE" => "content_menu",
				"USE_EXT" => "Y",
				"DELAY" => "N",
				"ALLOW_MULTI_SELECT" => "Y",
				"MENU_CACHE_TYPE" => "N",
				"MENU_CACHE_TIME" => "3600",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_CACHE_GET_VARS" => ""
			)
		);?>
  </div>

  <?
      if($_SERVER['PHP_SELF']!='/courses/index.php')
      {
        ?>      
    <div class="header-title-content">
        <div class="header-breadcrumb" id="navigation">
          <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumb-new", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
		"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
		"START_FROM" => "1",	// Номер пункта, начиная с которого будет построена навигационная цепочка
		"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
	),
	false
);?>
        </div>
    </div>
    <? } ?>