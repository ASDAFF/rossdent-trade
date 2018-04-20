<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule("iblock");
$response['status'] = false;
$response['text'] = '';
$response['status'] = $_REQUEST['RULE'];

if (isset($_REQUEST['EVENT'])) {
  switch ($_REQUEST['EVENT']) {
    case 'FORM_ADD_FAST_ORDER':
      $arFields = Array(
              "NAME" => $_REQUEST['NAME'],
              "PHONE_NUMBER" => $_REQUEST['PHONE_NUMBER'],
              "TOVAR" => $_REQUEST['TOVAR']
          );
      $event = new CEvent;
      $event->Send($_REQUEST['EVENT'], 's1', $arFields, "N");
      $response['status'] = true;
      $response['text'] = 'Форма быстрого заказа отправлена';
      $event->CheckEvents();

      $el = new CIBlockElement;
      $PROP = array(
        87 => $_REQUEST['PHONE_NUMBER'], // Номер
        88 => $_REQUEST['NAME'],         // ФИО
        89 => $_REQUEST['TOVAR']         // Товар
      );

      require_once($_SERVER['DOCUMENT_ROOT'].'/introvert_consult.php');

      $arLoadProductArray = Array(
        "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,       // элемент лежит в корне раздела
        "IBLOCK_ID"      => 24,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => "Заказ от ".date('d.m.Y'),
        "ACTIVE"         => "Y"             // активен
      );

      if(!($PRODUCT_ID = $el->Add($arLoadProductArray))) {
        $response['status'] = false;
      }
      break;
    default:
      $response['status'] = false;
      $response['text'] = 'Такой шаблон отсутствует';
  }

} else {
  $response['status'] = false;
  $response['text'] = 'Не передано почтовое событие';
}

echo json_encode($response);
?>
