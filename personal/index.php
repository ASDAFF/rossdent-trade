<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Здесь вы можете оформить заказ и ознакомится с условиями доставки");
$APPLICATION->SetPageProperty("keywords", "оформление заказа");
$APPLICATION->SetPageProperty("title", "Оформление заказа");
//define("NEED_AUTH", true);
$APPLICATION->SetTitle("Персональный раздел");
global $USER;?>

<?

if ($_GET['login'] == 'yes') {
  if ($USER->IsAuthorized()) {
    LocalRedirect('/personal/', false, '301');
  } else {
    //echo "<div class='box'>";
    $APPLICATION->SetTitle("Авторизация");
    $APPLICATION->IncludeComponent(
    	"bitrix:system.auth.form",
    	"rossdent_account_block",
    	Array(
    		"COMPONENT_TEMPLATE" => "rossdent_account_block",
    		"FORGOT_PASSWORD_URL" => "/personal/forgot.php",
    		"PROFILE_URL" => "/personal",
    		"REGISTER_URL" => "/personal?register=yes",
    		"SHOW_ERRORS" => "N"
    	)
    );
    //echo "</div>";
  }
} else {



if ($_GET['forgot_password'] == 'yes') {
  $APPLICATION->IncludeComponent(
   "bitrix:system.auth.forgotpasswd",
   "",
   Array(
   "SHOW_ERRORS" => "Y"
   )
  );
}

if ($_GET['register'] == 'yes') {
  echo "<div class='auth background-green'>";
  $APPLICATION->IncludeComponent("bitrix:main.register", "", Array(
	"AUTH" => "Y",	// Автоматически авторизовать пользователей
		"COMPONENT_TEMPLATE" => ".default",
		"REQUIRED_FIELDS" => array(
			0 => "EMAIL",
			1 => "NAME",
			2 => "LAST_NAME",
			3 => "UF_RULE",
			//3 => "PERSONAL_PHOTO",
		),	// Поля, обязательные для заполнения
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"SHOW_FIELDS" => array(
			0 => "EMAIL",
			1 => "NAME",
			2 => "LAST_NAME",
			3 => "UF_RULE",
			//3 => "PERSONAL_PHOTO",
		),	// Поля, которые показывать в форме
		"SUCCESS_PAGE" => "/forum/",	// Страница окончания регистрации
		"USER_PROPERTY" => "",	// Показывать доп. свойства
		"USER_PROPERTY_NAME" => "",	// Название блока пользовательских свойств
		"USE_BACKURL" => "N",	// Отправлять пользователя по обратной ссылке, если она есть
	),
	false
  );
  echo "</div>";

} else {

$APPLICATION->SetTitle("Профиль");
?>

<section class="orders">
<div class="box">
	<hr class="orders__hr">
	<div class="orders__header">
		 Мои заказы
		<div class="orders__arrows">
			<!-- <div class="orders-slider__count">
				 1 из 4
			</div> -->
			<div class="orders-slider__arrows">
				<div class="orders-slider__prev">
 <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/arrow.png" class="orders-slider__arrow-img">
				</div>
				<div class="orders-slider__next">
 <img src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/arrow.png" class="orders-slider__arrow-img">
				</div>
			</div>
		</div>
	</div>
	<table cellpadding="0" cellspacing="0" class="product-header">
	<tbody>
	<tr>
		<td>
			 Товары в заказе
		</td>
		<td>
			 Всего товаров
		</td>
		<td>
		</td>
		<td>
			 Общая сумма
		</td>
		<td>
			<div class="product-header__last-item">
				 Статус
			</div>
		</td>
	</tr>
	</tbody>
	</table>
	<div class="swiper-container orders-slider">
		<div class="swiper-wrapper">

			<?// Выводим содержимое корзины?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:sale.basket.basket.small",
				"rossdent_order-basket",
				Array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH_TO_BASKET" => "/personal/basket.php",
					"PATH_TO_ORDER" => "/personal/order.php",
					"SHOW_DELAY" => "N",
					"SHOW_NOTAVAIL" => "Y",
					"SHOW_SUBSCRIBE" => "N"
				)
			);?>

      <? if ($USER->IsAuthorized()) {
        $_REQUEST['show_all']='Y';
        $APPLICATION->IncludeComponent("bitrix:sale.personal.order.list", "rossdent_order-list", Array(
        	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
        		"CACHE_GROUPS" => "N",	// Учитывать права доступа
        		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
        		"CACHE_TYPE" => "A",	// Тип кеширования
        		"COMPONENT_TEMPLATE" => ".default",
        		"HISTORIC_STATUSES" => "F",	// Перенести в историю заказы в статусах
        		"ID" => $ID,	// Идентификатор заказа
        		"NAV_TEMPLATE" => "",	// Имя шаблона для постраничной навигации
        		"ORDERS_PER_PAGE" => "20",	// Количество заказов, выводимых на страницу
        		"PATH_TO_BASKET" => "",	// Страница корзины
        		"PATH_TO_CANCEL" => "",	// Страница отмены заказа
        		"PATH_TO_COPY" => "",	// Страница повторения заказа
        		"PATH_TO_DETAIL" => "",	// Страница c подробной информацией о заказе
        		"SAVE_IN_SESSION" => "Y",	// Сохранять установки фильтра в сессии пользователя
        		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
        		"STATUS_COLOR_F" => "gray",	// Цвет статуса "Выполнен"
        		"STATUS_COLOR_N" => "green",	// Цвет статуса "Принят, ожидается оплата"
        		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",	// Цвет отменённых заказов
        	),
        	false
        );
      };?>

    </div>
  </div>
</div>
</section>


 <? if ($USER->IsAuthorized()) {
   $APPLICATION->IncludeComponent(
  	"bitrix:main.profile",
  	"rossdent_profile",
  	Array(
  		"AJAX_MODE" => "N",
  		"AJAX_OPTION_ADDITIONAL" => "",
  		"AJAX_OPTION_HISTORY" => "N",
  		"AJAX_OPTION_JUMP" => "N",
  		"AJAX_OPTION_STYLE" => "Y",
  		"CHECK_RIGHTS" => "N",
  		"COMPONENT_TEMPLATE" => ".default",
  		"SEND_INFO" => "N",
  		"SET_TITLE" => "N",
  		"USER_PROPERTY" => "",
  		"USER_PROPERTY_NAME" => ""
  	),
  false,
  Array(
  	'ACTIVE_COMPONENT' => 'Y'
  )
); } else {?>
    <section class="info">
    <div class="box">
    	<div class="info__header">
    		 Личная информация
    	</div>
    	<div class="info__form-box">
    		<form class="info__form" name="form1">
    			<hr class="info__hr">
    			<div class="info__title">
    				 Контактные данные
    			</div>
    			<div class="info__inputs">
    				<div class="input-box">
    					<div class="input-box__title">
    						 Фамилия
    					</div>
     <input placeholder="Введите фамилию" class="input-box__input" type="text" name="LAST_NAME" maxlength="50" value="" />
    				</div>
    				<div class="input-box">
    					<div class="input-box__title">
    						 Имя
    					</div>
     					<input placeholder="Введите имя" class="input-box__input" type="text" name="NAME" maxlength="50" value="" />
    				</div>
    				<div class="input-box">
    					<div class="input-box__title">
    						 Отчество
    					</div>
     <input placeholder="Введите отчество" class="input-box__input" type="text" name="SECOND_NAME" maxlength="50" value="" />
    				</div>
    				<div class="input-box">
    					<div class="input-box__title">
    						 Почта
    					</div>
     <input placeholder="Введите почту" class="input-box__input" type="text" name="EMAIL" maxlength="50" value="" />
    				</div>
    				<div class="input-box">
    					<div class="input-box__title">
    						 Телефон
    					</div>
     <input placeholder="Введите телефон" class="input-box__input" type="text" name="PERSONAL_PHONE" maxlength="255" value="" />
    				</div>
    			</div>
    			<hr class="info__hr">
    			<div class="info__title js-address">
    				 Адрес доставки
    			</div>
    			<div class="info__inputs">
    				<div class="input-box">
    					<div class="input-box__title">
    						 Страна
    					</div>
              <?// выведем выпадающий список стран
     					echo SelectBoxFromArray(
     					    "PERSONAL_COUNTRY",
     					    GetCountryArray(),
     					    1,
     					    "< выберите страну >"
     					    );
     					?>
    				</div>

    				<div class="input-box">
    					<div class="input-box__title">
    						 Город
    					</div>
     <input placeholder="Введите город" class="input-box__input" type="text" name="PERSONAL_CITY" maxlength="255" value="" />
    				</div>
    				<div class="input-box">
    					<div class="input-box__title">
    						 Улица, дом
    					</div>
     <input placeholder="Введите улицу, дом" class="input-box__input" cols="30" rows="5" name="PERSONAL_STREET" value="" />
    				</div>
    			</div>
				<div class="info__inputs" style="margin-bottom: 40px;">
						<div class="input-box__title">
							<label style="display: inline-block;">
								<input class="checkbox-cast" type="checkbox" name="RULE" id="rule" value="Y" checked>
								<span class="checkbox-custom" style="border: 1px solid"></span>
							</label>
						Нажимая на эту кнопку, я даю свое согласие на <a style="color: #949797;" href="/upload/compliance.pdf" target="_blank">обработку персональных данных</a> и соглашаюсь с условиями <a style="color: #949797;" href="/upload/politics.pdf" target="_blank">политики конфиденциальности</a>.
						</div>
				</div>
				
				<div class="btn-green-border ajax-btn-order">
					 Оформить
				</div>
    		</form>
    		<div class="subscription">
    			<?if ($USER->IsAuthorized()) {$APPLICATION->IncludeComponent(
    			 "bitrix:subscribe.simple",
    			 "rossdent_subscribe",
    			 Array(
    				 "AJAX_MODE" => "N",
    				 "AJAX_OPTION_ADDITIONAL" => "",
    				 "AJAX_OPTION_HISTORY" => "N",
    				 "AJAX_OPTION_JUMP" => "N",
    				 "AJAX_OPTION_STYLE" => "Y",
    				 "CACHE_TIME" => "3600",
    				 "CACHE_TYPE" => "A",
    				 "COMPONENT_TEMPLATE" => ".default",
    				 "SET_TITLE" => "N",
    				 "SHOW_HIDDEN" => "N"
    			 )
         );} else {
           echo "<p>Управление подписками возможно только для зарегистрированных и авторизованных пользователей.</p>";
         }?>
    		</div>
    	</div>
    </div>
     </section>
  <?}?>


<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
      "AREA_FILE_SHOW" => "file",
      "AREA_FILE_SUFFIX" => "inc",
      "COMPONENT_TEMPLATE" => ".default",
      "EDIT_TEMPLATE" => "",
      "PATH" => "/bitrix/templates/rossdent/include_areas/next_action.php"
    )
  );
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"rossdent_gallery", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
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
		"IBLOCK_ID" => "23",
		"IBLOCK_TYPE" => "media",
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
			0 => "",
			1 => "MEDIA_PICTURES",
			2 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"COMPONENT_TEMPLATE" => "rossdent_gallery",
		"STRICT_SECTION_CHECK" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
 <?

}
}
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
