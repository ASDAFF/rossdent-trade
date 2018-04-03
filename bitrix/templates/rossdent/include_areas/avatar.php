<?

 ?>
 <?if ($USER->IsAuthorized()):?>
 <?
   $width = 100; // указываете ширину аватара пользователя
   $height = 100; // указываете ширину аватара пользователя
   $user_id=$USER->GetID(); //   $user_id - id необходимого пользователя
   // логика
   $imgSrc = '/bitrix/templates/'.SITE_TEMPLATE_ID.'/img/no-image-m.png';
   if(isset($user_id) && $user_id!='') {
       // получаем объект класса CDbResult
      $rsUser = $USER->GetByID($user_id);
      // считаем кол-во выбранных записей
      $rows_q = $rsUser -> SelectedRowsCount();
      if($rows_q > 0) {
          $arUser = $rsUser->Fetch();
          // создаем тег изображения - фото пользователя
         if (intval($arUser["PERSONAL_PHOTO"]) > 0) {
           $imageFile = CFile::GetFileArray($arUser["PERSONAL_PHOTO"]);
           if ($imageFile !== false) {
                $arFileTmp = CFile::ResizeImageGet(
                   $imageFile,
                   array("width" => $width, "height" => $height),
                   BX_RESIZE_IMAGE_PROPORTIONAL,
                   false
                );
                $imgSrc = $arFileTmp['src'];
           }
         }
      }
   }
 ?>
<div class="user">
<!--    <a href="/personal"><img src="--><?//=$imgSrc?><!--" class="user__img"></a>-->
		<div>
				<div class="user__name"><?=$USER->GetFirstName()?> <?=$USER->GetLastName()?></div>
				<a href="/personal?logout=yes" class="user__exit">Выход</a>
		</div>
</div>
<?else:?>
<div class="user">
    <img src="/bitrix/templates/<?=SITE_TEMPLATE_ID?>/img/avatar.svg" class="user__img--none">
		<div>
				<a href="/personal?login=yes" class="user__green">Личный кабинет</a>
		</div>
</div>
<?endif?>
