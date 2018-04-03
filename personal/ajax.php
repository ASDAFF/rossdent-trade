<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
CModule::IncludeModule("sale");
$response[status] = false;
$response[text] = 'Неверный вызов';

// Добавление товара в корзину
if ($_GET['C_ORDER'] == 'Y') {
  if (isset($_GET['ID'])) {
    $orderItems = CSaleBasket::GetList(Array(),Array("ORDER_ID" => $_GET['ID']));
    if (CModule::IncludeModule("catalog")) {
      $response[status] = true;
      while ($orderItem = $orderItems->GetNext()) {
        $res = Add2BasketByProductID($orderItem['PRODUCT_ID'], $orderItem['QUANTITY']);
        if (!$res) {$response[status] = false;}
      }
    }
    if (!$response[status]) {
      $response[text] = 'Ошибка при добавлении товаров в корзину. Возможно один из товаров отсутствует';
    }

  } else {
    $response[status] = false;
    $response[text] = 'Не передан ID';
  }
}

// Оформление заказа
if ($_REQUEST['create_order'] == 'Y') {
  if (isset($_REQUEST['address'])) {
    CModule::IncludeModule('iblock');
    CModule::IncludeModule('sale');

    # Получаем ID юзера
    $userId = IntVal($USER->GetID());
    if ($userId < 1) {
      # Гость
      $userId = 5;
    }

    # Высчитываем сумму в корзине
    $sum = 0;
    $dbBasketItems = CSaleBasket::GetList(
    array("NAME" => "ASC",
          "ID" => "ASC"),
    array("FUSER_ID" => CSaleBasket::GetBasketUserID(),
          "LID" => SITE_ID,
          "ORDER_ID" => "NULL"),
    false,
    false,
    array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT")
    );
    while ($arItems = $dbBasketItems->Fetch())
    {
        $sum += $arItems['PRICE'] * $arItems['QUANTITY'];
    }

    $arFields = array(
       "LID" => SITE_ID,
       "PERSON_TYPE_ID" => 1,
       "PAYED" => "N",
       "CANCELED" => "N",
       "STATUS_ID" => "N",
       "PRICE" => $sum,
       "CURRENCY" => "RUB",
       "USER_ID" => $userId,
       "PAY_SYSTEM_ID" => 6,
       "PRICE_DELIVERY" => 0.00,
       "DELIVERY_ID" => 5,
       "DISCOUNT_VALUE" => 0,
       "TAX_VALUE" => 0.0,
       "USER_DESCRIPTION" => $_REQUEST['address']
    );
    if($sum){

        $ORDER_ID = CSaleOrder::Add($arFields);

        if ($ORDER_ID == false or empty($sum)) {
            $response[status] = false;
            $response[text] = 'Ошибка при создании заказа';
        } else {
            CSaleBasket::OrderBasket($ORDER_ID, $_SESSION["SALE_USER_ID"], SITE_ID);
            $response[status] = true;
            $response[id] = $ORDER_ID;
            $response[text] = 'Сумма заказа '.$sum;
        }

    }
      
  } else {
    $response[status] = false;
    $response[text] = 'Не все параметры переданы';
  }
}

if ($_REQUEST['delete_order'] == 'Y') {
  if (isset($_REQUEST['id'])) {
    if (CSaleBasket::Delete($_REQUEST['id'])) {
      $response['status'] = true;
      $response['text'] = 'Удалено';
    } else {
      $response['status'] = false;
      $response['text'] = 'Ошибка удаления';
    }
  } else {
    $response['status'] = false;
    $response['text'] = 'Не передан ID';
  }
}

echo json_encode($response);
?>
