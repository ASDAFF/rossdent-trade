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
?>
<div class="courses-detail">
   <hr class="catalog__hr">
   <div class="catalog__header">
      <?=$arResult['NAME']?>
   </div>
   <div class="courses-detail__wrapper">
      <div class="courses-detail-header">
         <div class="row">
            <div class="col-sm-7">
               <img class="courses-detail__img" width="100%" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="" />
            </div>
            <div class="col-sm-5">
               <div class="courses-detail__table">
                  <div class="detail-table-item">
                     <b>Дата проведения:</b> <span> <?if ($arResult["PROPERTIES"]["LESSON_DATE_END"]['VALUE']): //Условие, проверяющее, заполнено ли свойство?>
                     <?=$arResult['PROPERTIES']['LESSON_DATE']['VALUE']?> - <?=$arResult['PROPERTIES']['LESSON_DATE_END']['VALUE']?>
                     <?else:?>
                     <?=$arResult['PROPERTIES']['LESSON_DATE']['VALUE']?>
                     <?endif //конец условия?></span>
                  </div>
                  <?if ($arResult["PROPERTIES"]["LESSON_TIME"]['VALUE']): //Условие, проверяющее, заполнено ли свойство?>
                  <div class="detail-table-item">
                     <b>Время проведения:</b> <span>  <?=$arResult['PROPERTIES']['LESSON_TIME']['VALUE']?> </span>
                  </div>
                  <?endif //конец условия?>

                  <?if ($arResult["PROPERTIES"]["LESSON_COUNTRY_FULL"]['VALUE']): //Условие, проверяющее, заполнено ли свойство?>
                  <div class="detail-table-item">
                     <b>Место проведения:</b> <span><?=$arResult['PROPERTIES']['LESSON_COUNTRY_FULL']['VALUE']?> </span>
                  </div>
                  <?endif //конец условия?>
                  <div class="detail-table-item">
                     <b>Уровень курса:</b> <span> <?=$arResult['PROPERTIES']['LESSON_LEVEL']['VALUE']?></span>
                  </div>                
                  <div class="margin25"></div>
                  <div class="detail-table-item detail-table-price">
                     <b>СТОИМОСТЬ: </b> <span><b><?=$arResult['PROPERTIES']['LESSON_PRICE']['VALUE']?> ₽</b></span>
                  </div>
                  <?if ($arResult["PROPERTIES"]["LESSON_BENEFIT"]['VALUE']): //Условие, проверяющее, заполнено ли свойство?>
                  <div class="detail-table-item detail-table-benefit">
                     <b>ВЫГОДА: </b> <span><b><?=$arResult['PROPERTIES']['LESSON_BENEFIT']['VALUE']?> ₽</b></span>
                  </div>
                  <?endif //конец условия?>
               </div>

               <div class="margin25"></div>

               <div>
                  <a class="btn-green btn-green--wide" href='/form/?WEB_FORM_ID=3&FIELD_23=<?=$arResult['NAME']?>'>
                     Зарегистрироваться
                  </a>
               </div>
            </div>
         </div>
      </div>


      <div class="courses-detail-main">
         <hr class="catalog__hr">
         <div class="row">
            <div class="col-sm-7">
            	<div class="main-detail-title">Описание курса</div>
               <?=$arResult['DETAIL_TEXT']?>

               <?if ($arResult["PROPERTIES"]["MODULE_LESSONS"]['VALUE']): //Условие, проверяющее, заполнено ли свойство?>
               <div class="main-detail-cours">
                  <hr class="catalog__hr">
                  <div class="main-cours-title"><h2>Учебный модуль включает в себя: </h2></div>
                  <div class="main-cours-content">
                     <ul>
                        <?foreach($arResult["PROPERTIES"]["MODULE_LESSONS"]["VALUE"] as $analog):?> 
                        <?$res = CIBlockElement::GetByID($analog);
                        ?> 
                        <?if($ar_res = $res->GetNext())?> 
                        <div class="cours_item">
                           <div class="cours__name cours__name_mini">
                              <li><h3><?=$ar_res['NAME']?></h3></li>
                           </div>
                           <div class="cours__description">
                              <p><?=$ar_res['PREVIEW_TEXT']?></p>
                           </div>
                           <div class="cours__read_more">
                              <a href="<?=$ar_res["DETAIL_PAGE_URL"];?>" class="btn-green-border">Подробнее</a>
                           </div>
                        </div>
                        <?endforeach;?>
                     </ul>
                  </div>
               </div>
               <?endif //конец условия?>

            </div>
            <div class="col-sm-5">
               <div class="courses-detail-sidebar">
                  <div class="detail-main-help">
                     <div class="help-text">
                        <div>Если у Вас остались вопросы, Вы можете обратиться к администратору курса:</div>
                        <div><span>МАРИНА АКОПЯН</span></div>
                     </div>
                     <div class="help-phone">
                        <span>тел:</span> +7 (861) 219-53-86
                        
                     </div>
                     <div class="help-mail">
                        <span>e-mail:</span>
                        <a class="link" href="mailto:marina@rossdent.ru">marina@rossdent.ru</a>
                     </div>
                  </div>
                  <div class="sidebar-detail-lector">
                     <div class="sidebar-lector-title">Информация о лекторе </div>
                     <div class="sidebar-lector-content">
                        <?foreach($arResult["PROPERTIES"]["LESSON_LECTOR"]["VALUE"] as $analog):?> 
                        <?$res = CIBlockElement::GetByID($analog);
                           $ar_res = GetIBlockElement($arResult["PROPERTIES"]["LESSON_LECTOR"]["VALUE"]);
                        ?> 
                        <?if($ar_res = $res->GetNext())?> 
                        <div class="consultant_item">
                           <img class="consultant__avatar consultant__avatar_mini" src="<?=CFile::GetPath($ar_res["PREVIEW_PICTURE"])?>">
                           <div class="consultant__name consultant__name_mini">
                              <a href="<?=$ar_res["DETAIL_PAGE_URL"];?>" class="link"><p><?=$ar_res['NAME']?></p></a>
                           </div>
                           <div class="consultant__description">
                              <?=$ar_res["PROPERTIES"]["JOB"]["VALUE"]?> 
                           </div>
                        </div>
                       <?endforeach;?>
                     </div>
                  </div>

                  <?if ($arResult["PROPERTIES"]["LESSON_GALERY"]['VALUE']): //Условие, проверяющее, заполнено ли свойство?>
                     <div class="sidebar-detail-galery">
                        <div class="sidebar-galery-title">Галерея к данному курсу</div>
                        <div class="row">
                           <?php if ($arResult["PROPERTIES"]["LESSON_GALERY"]["VALUE"]) {?> 
                           <?
                           $arPrice = GetIBlockElement($arResult["PROPERTIES"]["LESSON_GALERY"]["VALUE"]);
                           ?>
                           <?php if ($arPrice["PROPERTIES"]["MEDIA_CLINIC_PICTURES"]["VALUE"]) {?> 
                           <?if(count($arPrice["PROPERTIES"]["MEDIA_CLINIC_PICTURES"]["VALUE"])>0):?> 
                                   <?foreach($arPrice["PROPERTIES"]["MEDIA_CLINIC_PICTURES"]["VALUE"] as $PHOTO):?> 
                                         <div class="col-xs-12 col-sm-6">
                                         <div class="crop">
                                          <a class="gallery" rel="group"  title="<?=$arPrice["NAME"]?>" href="<?=CFile::GetPath($PHOTO); ?>">
                                             <img src="<?=CFile::GetPath($PHOTO); ?>"  alt="<?=$arPrice["NAME"]?>" title="<?=$arPrice["NAME"]?>" />
                                          </a>
                                       </div>
                                       </div>
                                      <?endforeach?> 
                                      <div class="clear"></div>

                                <?endif?> 
                                <?php } else { ?><?php }?>
                                <?php }?>

                             </div>
                              <a href="<?=$arPrice["DETAIL_PAGE_URL"];?>" class="btn-green-border" target="_blank">Посмотреть</a>
                             
                          </div>
                          <?endif //конец условия?>

               </div>
            </div>
         </div>
      </div>

   </div>
</div>
<!-- Social -->
<!-- <div style="text-align: center;"> 
   <span class="ya-share2__box-title">Поделиться в социальных сетях:</span> -->

<!--  <script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
   <script type="text/javascript" src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/vendor/share.js" charset="utf-8"></script>
   <div class="ya-share2" data-services="vkontakte,facebook,twitter"></div> -->
<!-- </div>
<br>
<a class="btn-green" style="margin: 0 auto; width: 240px" href="/form/?WEB_FORM_ID=3&FIELD_23=<?=$arResult['NAME']?>">
   Зарегистрироваться
</a> -->