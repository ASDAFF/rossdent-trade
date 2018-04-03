<?
/*
You can place here your functions and event handlers

AddEventHandler("module", "EventName", "FunctionName");
function FunctionName(params)
{
	//code
}
*/


function GetRateFromCBR($CURRENCY)
      {
         global $DB;
         global $APPLICATION;

         CModule::IncludeModule('currency');
       if(!CCurrency::GetByID($CURRENCY))
    //такой валюты нет на сайте, агент в этом случае удаляется
       return false;

         $DATE_RATE=date("d.m.Y");//сегодня
         $QUERY_STR = "date_req=".$DB->FormatDate($DATE_RATE, CLang::GetDateFormat("SHORT", $lang), "D.M.Y");

      //делаем запрос к www.cbr.ru с просьбой отдать курс на нынешнюю дату
      $strQueryText = QueryGetData("www.cbr.ru", 80, "/scripts/XML_daily.asp", $QUERY_STR, $errno, $errstr);

      //получаем XML и конвертируем в кодировку сайта
       $charset = "windows-1251";
         if (preg_match("/<"."\?XML[^>]{1,}encoding=[\"']([^>\"']{1,})[\"'][^>]{0,}\?".">/i", $strQueryText, $matches))
               {
                  $charset = Trim($matches[1]);
               }
         $strQueryText = eregi_replace("<!DOCTYPE[^>]{1,}>", "", $strQueryText);
         $strQueryText = eregi_replace("<"."\?XML[^>]{1,}\?".">", "", $strQueryText);
         $strQueryText = $APPLICATION->ConvertCharset($strQueryText, $charset, SITE_CHARSET);

         require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");

      //парсим XML
         $objXML = new CDataXML();
         $res = $objXML->LoadString($strQueryText);
         if($res !== false)
                  $arData = $objXML->GetArray();
               else
                  $arData = false;

         $NEW_RATE=Array();

       //получаем курс нужной валюты $CURRENCY
         if (is_array($arData) && count($arData["ValCurs"]["#"]["Valute"])>0)
               {
                  for ($j1 = 0; $j1<count($arData["ValCurs"]["#"]["Valute"]); $j1++)
                  {
                     if ($arData["ValCurs"]["#"]["Valute"][$j1]["#"]["CharCode"][0]["#"]==$CURRENCY)
                     {
                        $NEW_RATE['CURRENCY']=$CURRENCY;
                        $NEW_RATE['RATE_CNT'] = IntVal($arData["ValCurs"]["#"]["Valute"][$j1]["#"]["Nominal"][0]["#"]);
                        $NEW_RATE['RATE'] = DoubleVal(str_replace(",", ".", $arData["ValCurs"]["#"]["Valute"][$j1]["#"]["Value"][0]["#"]));
                        $NEW_RATE['DATE_RATE']=$DATE_RATE;
                        break;
                     }
                  }
               }

         if ((isset($NEW_RATE['RATE']))&&(isset($NEW_RATE['RATE_CNT'])))
            {

            //курс получили, возможно, курс на нынешнюю дату уже есть на сайте, проверяем
                CModule::IncludeModule('currency');
                $arFilter = array(
                           "CURRENCY" => $NEW_RATE['CURRENCY'],
                           "DATE_RATE"=>$NEW_RATE['DATE_RATE']
                              );
                     $by = "date";
                     $order = "desc";

                     $db_rate = CCurrencyRates::GetList($by, $order, $arFilter);
                     if(!$ar_rate = $db_rate->Fetch())
                //такого курса нет, создаём курс на нынешнюю дату
                           CCurrencyRates::Add($NEW_RATE);

            }

         //возвращаем код вызова функции, чтобы агент не "убился"
         return 'GetRateFromCBR("'.$CURRENCY.'");';
      }




// Обновление цен для торговых предложений
/*
AddEventHandler('iblock', 'OnAfterIBlockElementUpdate', 'afterSave');
AddEventHandler('iblock', 'OnAfterIBlockElementAdd', 'afterSave');
AddEventHandler('catalog', 'OnPriceAdd', 'afterSave');
AddEventHandler('catalog', 'OnPriceUpdate', 'afterSave');

function afterSave($arg1, $arg2 = false) {
    $element_id = false;
    $iblock_id = false;
    $offers_iblock_id = false;
    $offers_property_id = false;
    $current_iblock_id = false;
    if (CModule::IncludeModule('currency')) {
        $strDefaultCurrency = CCurrency::GetBaseCurrency();
    }
    //check for catalog event
    if(is_array($arg2) && $arg2['PRODUCT_ID'] > 0) {
        //get iblock element
        $rsPriceElement = CIBlockElement::GetList(
            array(),
            array(
             'ID' => $arg2['PRODUCT_ID'],
            ),
            false,
            false,
            array('ID', 'IBLOCK_ID')
        );
        if($arPriceElement = $rsPriceElement->Fetch()) {
            $arCatalog = CCatalog::GetByID($arPriceElement['IBLOCK_ID']);
            if(is_array($arCatalog)) {
                //check if it is offers iblock
                if($arCatalog['OFFERS'] == 'Y') {
                    //find product element
                    $rsElement = CIBlockElement::GetProperty(
                        $arPriceElement['IBLOCK_ID'],
                        $arPriceElement['ID'],
                        'sort',
                        'asc',
                        array('ID' => $arCatalog['SKU_PROPERTY_ID'])
                    );
                    $arElement = $rsElement->Fetch();
                    if($arElement && $arElement['VALUE'] > 0) {
                        $element_id = $arElement['VALUE'];
                        $iblock_id = $arCatalog['PRODUCT_IBLOCK_ID'];
                        $offers_iblock_id = $arCatalog['IBLOCK_ID'];
                        $offers_property_id = $arCatalog['SKU_PROPERTY_ID'];
                        $current_iblock_id = $arPriceElement['IBLOCK_ID'];
                    }
                }
                //or iblock which has offers
                elseif($arCatalog['OFFERS_IBLOCK_ID'] > 0) {
                    $element_id = $arPriceElement['ID'];
                    $iblock_id = $arPriceElement['IBLOCK_ID'];
                    $offers_iblock_id = $arCatalog['OFFERS_IBLOCK_ID'];
                    $offers_property_id = $arCatalog['OFFERS_PROPERTY_ID'];
                    $current_iblock_id = $arPriceElement['IBLOCK_ID'];
                }
                //or it's regular catalog
                else {
                    $element_id = $arPriceElement['ID'];
                    $iblock_id = $arPriceElement['IBLOCK_ID'];
                    $offers_iblock_id = false;
                    $offers_property_id = false;
                    $current_iblock_id = $arPriceElement['IBLOCK_ID'];
                }
            }
        }
    }
    //check for iblock event
    elseif(is_array($arg1) && $arg1['ID'] > 0 && $arg1['IBLOCK_ID'] > 0) {
        //check if iblock has offers
        $arOffers = CIBlockPriceTools::GetOffersIBlock($arg1['IBLOCK_ID']);
        if(is_array($arOffers)) {
            $element_id = $arg1['ID'];
            $iblock_id = $arg1['IBLOCK_ID'];
            $offers_iblock_id = $arOffers['OFFERS_IBLOCK_ID'];
            $offers_property_id = $arOffers['OFFERS_PROPERTY_ID'];
            $current_iblock_id =  $arg1['IBLOCK_ID'];
        }
    }
    if($element_id) {
        static $arPropCache = array();
        if(!array_key_exists($iblock_id, $arPropCache)) {
            //check for MIN_PRICE property
            $rsProperty = CIBlockProperty::GetByID('MINIMUM_PRICE', $iblock_id);
            $arProperty = $rsProperty->Fetch();
            if($arProperty) {
                $arPropCache[$iblock_id] = $arProperty['ID'];
            } else {
                $arPropCache[$iblock_id] = false;
            }
        }
        if($arPropCache[$iblock_id]) {
            //compose elements filter
            if($offers_iblock_id) {
                $rsOffers = CIBlockElement::GetList(
                    array(),
                    array(
                        'IBLOCK_ID' => $offers_iblock_id,
                        'PROPERTY_'.$offers_property_id => $element_id,
                    ),
                    false,
                    false,
                    array('ID')
                );
                while($arOffer = $rsOffers->Fetch())
                    $arProductID[] = $arOffer['ID'];
                if (!is_array($arProductID))
                    $arProductID = array($element_id);
            } else {
                $arProductID = array($element_id);
            }
            $minPrice = false;
            $maxPrice = false;
            //get price
            $rsPrices = CPrice::GetList(
                array(),
                array(
                    'PRODUCT_ID' => $arProductID,
                )
            );
            while($arPrice = $rsPrices->Fetch()) {
                if(
                    CModule::IncludeModule('currency') &&
                    $strDefaultCurrency != $arPrice['CURRENCY']
                )
                    $arPrice['PRICE'] = CCurrencyRates::ConvertCurrency(
                        $arPrice['PRICE'],
                        $arPrice['CURRENCY'],
                        $strDefaultCurrency
                    );
                $price = $arPrice['PRICE'];

                if($minPrice === false || $minPrice > $price)
                    $minPrice = $price;

                if($maxPrice === false || $maxPrice < $price)
                    $maxPrice = $price;
            }
            //save found min, max price into property
            if($minPrice !== false) {
                CIBlockElement::SetPropertyValuesEx(
                    $element_id,
                    $iblock_id,
                    array(
                        'MIN_PRICE' => $minPrice,
                        'MAX_PRICE' => $maxPrice,
                    )
                );
            }
        }
    }
}*/





/*Version 0.3 2011-04-25*/
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "DoIBlockAfterSave");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "DoIBlockAfterSave");
AddEventHandler("catalog", "OnPriceAdd", "DoIBlockAfterSave");
AddEventHandler("catalog", "OnPriceUpdate", "DoIBlockAfterSave");
function DoIBlockAfterSave($arg1, $arg2 = false)
{
$ELEMENT_ID = false;
$IBLOCK_ID = false;
$OFFERS_IBLOCK_ID = false;
$OFFERS_PROPERTY_ID = false;
if (CModule::IncludeModule('currency'))
$strDefaultCurrency = CCurrency::GetBaseCurrency();

//Check for catalog event
if(is_array($arg2) && $arg2["PRODUCT_ID"] > 0)
{
//Get iblock element
$rsPriceElement = CIBlockElement::GetList(
array(),
array(
"ID" => $arg2["PRODUCT_ID"],
),
false,
false,
array("ID", "IBLOCK_ID")
);
if($arPriceElement = $rsPriceElement->Fetch())
{
$arCatalog = CCatalog::GetByID($arPriceElement["IBLOCK_ID"]);
if(is_array($arCatalog))
{
//Check if it is offers iblock
if($arCatalog["OFFERS"] == "Y")
{
//Find product element
$rsElement = CIBlockElement::GetProperty(
$arPriceElement["IBLOCK_ID"],
$arPriceElement["ID"],
"sort",
"asc",
array("ID" => $arCatalog["SKU_PROPERTY_ID"])
);
$arElement = $rsElement->Fetch();
if($arElement && $arElement["VALUE"] > 0)
{
$ELEMENT_ID = $arElement["VALUE"];
$IBLOCK_ID = $arCatalog["PRODUCT_IBLOCK_ID"];
$OFFERS_IBLOCK_ID = $arCatalog["IBLOCK_ID"];
$OFFERS_PROPERTY_ID = $arCatalog["SKU_PROPERTY_ID"];
}
}
//or iblock which has offers
elseif($arCatalog["OFFERS_IBLOCK_ID"] > 0)
{
$ELEMENT_ID = $arPriceElement["ID"];
$IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
$OFFERS_IBLOCK_ID = $arCatalog["OFFERS_IBLOCK_ID"];
$OFFERS_PROPERTY_ID = $arCatalog["OFFERS_PROPERTY_ID"];
}
//or it's regular catalog
else
{
$ELEMENT_ID = $arPriceElement["ID"];
$IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
$OFFERS_IBLOCK_ID = false;
$OFFERS_PROPERTY_ID = false;
}
}
}
}
//Check for iblock event
elseif(is_array($arg1) && $arg1["ID"] > 0 && $arg1["IBLOCK_ID"] > 0)
{
//Check if iblock has offers
$arOffers = CIBlockPriceTools::GetOffersIBlock($arg1["IBLOCK_ID"]);
if(is_array($arOffers))
{
$ELEMENT_ID = $arg1["ID"];
$IBLOCK_ID = $arg1["IBLOCK_ID"];
$OFFERS_IBLOCK_ID = $arOffers["OFFERS_IBLOCK_ID"];
$OFFERS_PROPERTY_ID = $arOffers["OFFERS_PROPERTY_ID"];
}
}

if($ELEMENT_ID)
{
static $arPropCache = array();
if(!array_key_exists($IBLOCK_ID, $arPropCache))
{
//Check for MINIMAL_PRICE property
$rsProperty = CIBlockProperty::GetByID("MINIMUM_PRICE", $IBLOCK_ID);
$arProperty = $rsProperty->Fetch();
if($arProperty)
$arPropCache[$IBLOCK_ID] = $arProperty["ID"];
else
$arPropCache[$IBLOCK_ID] = false;
}

if($arPropCache[$IBLOCK_ID])
{
//Compose elements filter
if($OFFERS_IBLOCK_ID)
{
$rsOffers = CIBlockElement::GetList(
array(),
array(
"IBLOCK_ID" => $OFFERS_IBLOCK_ID,
"PROPERTY_".$OFFERS_PROPERTY_ID => $ELEMENT_ID,
),
false,
false,
array("ID")
);
while($arOffer = $rsOffers->Fetch())
$arProductID[] = $arOffer["ID"];

if (!is_array($arProductID))
$arProductID = array($ELEMENT_ID);
}
else
$arProductID = array($ELEMENT_ID);

$minPrice = false;
$maxPrice = false;
//Get prices
$rsPrices = CPrice::GetList(
array(),
array(
"PRODUCT_ID" => $arProductID,
)
);
while($arPrice = $rsPrices->Fetch())
{
if (CModule::IncludeModule('currency') && $strDefaultCurrency != $arPrice['CURRENCY'])
$arPrice["PRICE"] = CCurrencyRates::ConvertCurrency($arPrice["PRICE"], $arPrice["CURRENCY"], $strDefaultCurrency);

$PRICE = $arPrice["PRICE"];

if($minPrice === false || $minPrice > $PRICE)
$minPrice = $PRICE;

if($maxPrice === false || $maxPrice < $PRICE)
$maxPrice = $PRICE;
}

//Save found minimal price into property
if($minPrice !== false)
{
CIBlockElement::SetPropertyValuesEx(
$ELEMENT_ID,
$IBLOCK_ID,
array(
"MINIMUM_PRICE" => $minPrice,
"MAXIMUM_PRICE" => $maxPrice,
)
);
}
}
}
}


function CatalogPriceUpdate() {

}


//Удаление keywords и description
AddEventHandler("main", "OnEndBufferContent", "deleteMetaTags");
function deleteMetaTags(&$content)
{
	$content = preg_replace(array('/<meta(.*?)keywords(.*?)>/','/<meta(.*?)description(.*?)>/'),"",$content);
}

?>
