<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?

$data['status'] = false;
$data['text'] = '';

if (isset($_REQUEST['action'])) {
  switch ($_REQUEST['action']) {
    case 'add':
      if (isset($_REQUEST['productId'], $_REQUEST['quantity'])) {
        if (CModule::IncludeModule("catalog")) {
          $params =array();
          if (isset($_REQUEST['isImplant']) && $_REQUEST['isImplant'] == true) {
            if (isset($_REQUEST['productDiag'], $_REQUEST['productLength'])) {
              $params[] = array("CODE" => "PRODUCT_LENGTHS",
                               "VALUE" => $_REQUEST['productLength']);
              $params[] = array("CODE" => "PRODUCT_DIAMETRS",
                               "VALUE" => $_REQUEST['productDiag']);
            }  else {
              $data['status'] = false;
              $data['text'] = 'Переданы не все параметры импланта';
            }
          }
          $res = Add2BasketByProductID($_REQUEST['productId'], $_REQUEST['quantity'], $params);
          if ($res) {
            $data['status'] = true;
            // $data['text'] = 'Товар добавлен';
            $data['text'] = 'Товар добавлен'.$params;
          } else {
            $data['status'] = false;
            $data['text'] = 'Неверные параметы';
          }
        } else {
          $data['status'] = false;
          $data['text'] = 'Не удалось подключить модуль';
        }
      } else {
        $data['status'] = false;
        $data['text'] = 'Неверные параметы';
      }
      break;

    default:
    $data['status'] = false;
    $data['text'] = 'Не верное действие';
      break;
  }
} else {
  $data['status'] = false;
  $data['text'] = 'Не указано действие';
}

echo json_encode($data);

?>
