<?php
namespace Bitrix\Sale\Helpers\Admin;

use Bitrix\Main\Error;
use Bitrix\Sale\Fuser;
use Bitrix\Sale\Order;
use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Result;
use Bitrix\Sale\Discount;
use Bitrix\Sale\Provider;
use Bitrix\Main\UserTable;
use Bitrix\Sale\BasketItem;
use Bitrix\Main\Page\Asset;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Config\Option;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\SystemException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Services\Company;
use Bitrix\Main\Entity\EntityError;
use Bitrix\Sale\UserMessageException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentTypeException;
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Sale\Helpers\Admin\Blocks\OrderBasket;

Loc::loadMessages(__FILE__);

Loader::registerAutoLoadClasses('sale',
	array(
		'\Bitrix\Sale\Helpers\Admin\Blocks\OrderShipmentStatus' => 'lib/helpers/admin/blocks/ordershipmentstatus.php',
		'\Bitrix\Sale\Helpers\Admin\Blocks\OrderFinanceInfo' => 'lib/helpers/admin/blocks/orderfinanceinfo.php',
		'\Bitrix\Sale\Helpers\Admin\Blocks\OrderAdditional' => 'lib/helpers/admin/blocks/orderadditional.php',
		'\Bitrix\Sale\Helpers\Admin\Blocks\OrderShipment' => 'lib/helpers/admin/blocks/ordershipment.php',
		'\Bitrix\Sale\Helpers\Admin\Blocks\OrderPayment' => 'lib/helpers/admin/blocks/orderpayment.php',
		'\Bitrix\Sale\Helpers\Admin\Blocks\OrderStatus' => 'lib/helpers/admin/blocks/orderstatus.php',
		'\Bitrix\Sale\Helpers\Admin\Blocks\OrderBasket' => 'lib/helpers/admin/blocks/orderbasket.php',
		'\Bitrix\Sale\Helpers\Admin\Blocks\OrderBuyer' => 'lib/helpers/admin/blocks/orderbuyer.php',
		'\Bitrix\Sale\Helpers\Admin\Blocks\OrderInfo' => 'lib/helpers/admin/blocks/orderinfo.php',
		'\Bitrix\Sale\Helpers\Admin\Blocks\OrderMarker' => 'lib/helpers/admin/blocks/ordermarker.php',
));

/**
 * Class OrderEdit
 * Helper class for order administration.
 * @package Bitrix\Sale\Helpers\Admin
 */
class OrderEdit
{
	protected static $productsDetails = null;
	public static $isTrustProductFormData = false;
	public static $needUpdateNewProductPrice = false;
	public static $isBuyerIdChanged = false;

	const BASKET_CODE_NEW = 'new';

	/**
	 * @param string $name
	 * @param array $data
	 * @param string $selected
	 * @param bool $showNotUse
	 * @param array $attributes
	 * @return string "<select>....</select>"
	 * @throws ArgumentTypeException
	 */
	public static function makeSelectHtml($name, array $data, $selected = "", $showNotUse = true, $attributes = array())
	{
		if(!is_array($data))
			throw new ArgumentTypeException("data", "array");

		if(!is_array($attributes))
			throw new ArgumentTypeException("attributies", "array");

		$result = '<select name="'.htmlspecialcharsbx($name).'"';

		foreach($attributes as $attrName => $attrValue )
			$result.=" ".$attrName."=\"".htmlspecialcharsbx($attrValue)."\"";

		$result .= '>';

		if($showNotUse)
			$result .= '<option value="">'.GetMessage("SALE_ORDEREDIT_NOT_USE").'</option>';

		foreach($data as $value => $title)
			$result .= '<option value="'.htmlspecialcharsbx($value).'"'.($selected == $value ? " selected" : "").'>'.htmlspecialcharsbx(TruncateText($title, 40)).'</option>';

		$result .= '</select>';

		return $result;
	}

	/**
	 * @param $name
	 * @param array $data
	 * @param string $selected
	 * @param bool|true $showNotUse
	 * @param array $attributes
	 * @return string
	 * @throws ArgumentTypeException
	 */
	public static function makeSelectHtmlWithRestricted($name, array $data, $selected = "", $showNotUse = true, $attributes = array())
	{
		if(!is_array($data))
			throw new ArgumentTypeException("data", "array");

		if(!is_array($attributes))
			throw new ArgumentTypeException("attributies", "array");

		$result = '<select name="'.htmlspecialcharsbx($name).'"';

		foreach($attributes as $attrName => $attrValue )
			$result .= " ".$attrName."=\"".htmlspecialcharsbx($attrValue)."\"";

		$result .= '>';

		$result .= self::makeSelectHtmlBodyWithRestricted($data, $selected, $showNotUse);
		$result .= '</select>';

		return $result;
	}

	/**
	 * @param $data
	 * @param string $selected
	 * @param bool|true $showNotUse
	 * @return string
	 */
	public static function makeSelectHtmlBodyWithRestricted($data, $selected = '', $showNotUse = true)
	{
		$activePaySystems = '';

		if($showNotUse)
			$activePaySystems .= '<option value="">'.GetMessage("SALE_ORDEREDIT_NOT_USE").'</option>';

		$restrictedPaySystems = '';
		foreach($data as $item)
		{
			if (!isset($item['RESTRICTED']))
			{
				$activePaySystems .= '<option value="'.htmlspecialcharsbx($item['ID']).'"'.($selected == $item['ID'] ? " selected" : "").'>'.htmlspecialcharsbx(TruncateText($item['NAME'], 40)).'</option>';
			}
			else
			{
				$restrictedPaySystems .= '<option value="'.htmlspecialcharsbx($item['ID']).'"'.($selected == $item['ID'] ? " selected" : "").' class="bx-admin-service-restricted">'.htmlspecialcharsbx(TruncateText($item['NAME'], 40)).'</option>';
			}
		}

		return $activePaySystems.$restrictedPaySystems;
	}

	/**
	 * @param Order $order
	 * @param $formId
	 * @return string
	 */
	public static function getScripts(Order $order, $formId)
	{
		Asset::getInstance()->addJs("/bitrix/js/sale/admin/order_edit.js");
		Asset::getInstance()->addJs("/bitrix/js/sale/admin/order_ajaxer.js");
		$currencyId = $order->getCurrency();
		$currencies = array();

		if(Loader::includeModule('currency'))
		{
			\CJSCore::Init(array('currency'));
			$currencyFormat = \CCurrencyLang::getFormatDescription($currencyId);
			$currencies = array(
				array(
					'CURRENCY' => $currencyId,
					'FORMAT' => array(
						'FORMAT_STRING' => $currencyFormat['FORMAT_STRING'],
						'DEC_POINT' => $currencyFormat['DEC_POINT'],
						'THOUSANDS_SEP' => $currencyFormat['THOUSANDS_SEP'],
						'DECIMALS' => $currencyFormat['DECIMALS'],
						'THOUSANDS_VARIANT' => $currencyFormat['THOUSANDS_VARIANT'],
						'HIDE_ZERO' => "N" //$currencyFormat['HIDE_ZERO']
					)
				)
			);
		}

		$curFormat = \CCurrencyLang::GetFormatDescription($currencyId);
		$currencyLang = preg_replace("/(^|[^&])#/", '$1', $curFormat["FORMAT_STRING"]);
		$langPhrases = array("SALE_ORDEREDIT_DISCOUNT_UNKNOWN", "SALE_ORDEREDIT_REFRESHING_DATA", "SALE_ORDEREDIT_FIX", "SALE_ORDEREDIT_UNFIX", "SALE_ORDEREDIT_CLOSE", "SALE_ORDEREDIT_MESSAGE");

		$result = '
			<script type="text/javascript">
				BX.ready(function(){
					BX.Sale.Admin.OrderEditPage.orderId = "'.$order->getId().'";
					BX.Sale.Admin.OrderEditPage.siteId = "'.$order->getSiteId().'";
					BX.Sale.Admin.OrderEditPage.languageId = "'.LANGUAGE_ID.'";
					BX.Sale.Admin.OrderEditPage.formId = "'.$formId.'_form";
					BX.Sale.Admin.OrderEditPage.adminTabControlId = "'.$formId.'";
					'.(!empty($currencies) ? 'BX.Currency.setCurrencies('.\CUtil::PhpToJSObject($currencies, false, true, true).');' : '').
					'BX.Sale.Admin.OrderEditPage.currency = "'.$currencyId.'";
					BX.Sale.Admin.OrderEditPage.currencyLang = "'.\CUtil::JSEscape($currencyLang).'";';

		if($formId == "sale_order_create")
			$result .= '
					BX.Sale.Admin.OrderEditPage.registerFieldsUpdaters(BX.Sale.Admin.OrderPayment.prototype.getCreateOrderFieldsUpdaters());';

		foreach($langPhrases as $phrase)
			$result .= ' BX.message({'.$phrase.': "'.\CUtil::JSEscape(Loc::getMessage($phrase)).'"});';

		$result .=
				'});
			</script>
		';

		return $result;
	}

	/**
	 * @param int $userId.
	 * @param string $siteId.
	 * @return string User name.
	 */
	public static function getUserName($userId, $siteId = "")
	{
		if(intval($userId) <= 0)
			return Loc::getMessage("SALE_ORDEREDIT_NAME_NULL");

		static $userNames = array();

		if(!isset($userNames[$userId]))
		{
			$res = UserTable::getById($userId);

			if($buyer = $res->fetch())
			{
				$userNames[$userId] = \CUser::FormatName(
					\CSite::GetNameFormat(
						null,
						$siteId
					),
					$buyer,
					true,
					false
				);
			}
		}

		return $userNames[$userId];
	}

	/**
	 * @param string $text The order problem description.
	 * @param int $orderId
	 * @return string HTML Problem block.
	 */
	public static function getProblemBlockHtml($text, $orderId)
	{
		if(strlen($text) <= 0)
			$result = "";
		else
			$result = '
				<div class="adm-bus-orderproblem" id="sale-adm-order-problem-block">
					<div class="adm-bus-orderproblem-container">
						<table>
							<tr>
								<td class="adm-bus-orderproblem-title">'.Loc::getMessage("SALE_ORDEREDIT_ORDER_PROBLEM").':</td>
								<td class="adm-bus-orderproblem-text">'.$text.'</td>
							</tr>
						</table>
						<span class="adm-bus-orderproblem-close" title="'.Loc::getMessage("SALE_ORDEREDIT_CLOSE").'" onclick="BX.Sale.Admin.OrderEditPage.onProblemCloseClick(\''.$orderId.'\',\'sale-adm-order-problem-block\');"></span>
					</div>
				</div>';

		return $result;
	}

	/**
	 * @param array $items.
	 * @return string HTML Navigation block.
	 */
	public static function getFastNavigationHtml(array $items, $formId = '', $tabId = '')
	{
		if(empty($items))
			return "";

		$result = '
			<div class="adm-bus-fastnav adm-detail-tabs-block-pin" id="sale-order-edit-block-fast-nav">
				<div class="adm-bus-fastnav-container">
					<table>
						<tr>
							<td class="adm-bus-fastnav-title">'.Loc::getMessage('SALE_ORDEREDIT_NAVIGATION').':</td>
							<td>
								<ul class="adm-bus-fastnav-navlist" id="adm-bus-fastnav-navlist">';

		foreach($items as $anchor => $itemName)
		{
			if(strlen($formId) > 0 && strlen($tabId) > 0)
			{
				$href = 'javascript:void(0);';
				$onClick = ' onclick="BX.Sale.Admin.OrderEditPage.fastNavigation.onClickItem(\''.$formId.'\', \''.$tabId.'\', \''.$anchor.'\')"';
			}
			else
			{
				$href = '#'.$anchor;
				$onClick = '';
			}

			if ($anchor == 'relprops')
				$result .= '<li style="display:none;"><a href="'.$href.'" id="nav_'.$anchor.'"'.$onClick.'>'.$itemName.'</a></li>';
			else
				$result .= '<li><a href="'.$href.'" id="nav_'.$anchor.'"'.$onClick.'>'.$itemName.'</a></li>';
		}

		$result .= '
								</ul>
							</td>
						</tr>
					</table>
					<div id="sale-order-edit-block-fast-nav-pin" onclick="BX.Sale.Admin.OrderEditPage.toggleFix(this.id, \'sale-order-edit-block-fast-nav\');" class="adm-detail-pin-btn-tabs" style="top: 9px;right: 0px;"></div>
				</div>
			</div>';

		$orderEditOpts  = \CUserOptions::GetOption("sale_admin", "sale_order_edit", array());
		$isFixed = isset($orderEditOpts["fix_sale-order-edit-block-fast-nav"]) && $orderEditOpts["fix_sale-order-edit-block-fast-nav"] == "Y" ? true : false;

		$result .= '
			<script type="text/javascript">
				BX.ready(function(){
					BX.bind(window, "scroll", BX.Sale.Admin.OrderEditPage.fastNavigation.markItem);
					setTimeout(function(){
						BX.Sale.Admin.OrderEditPage.fastNavigation.markItem();'
						.($isFixed ? 'BX.Sale.Admin.OrderEditPage.toggleFix("sale-order-edit-block-fast-nav-pin", "sale-order-edit-block-fast-nav");' : '').
						'
						},
						1
					);										
				});
			</script>';

		return $result;
	}

	/**
	 * @param Order $order
	 * @param array $formData
	 * @return bool|int|string
	 * @throws UserMessageException
	 */
	protected static function createUserFromForm(Order &$order, array $formData)
	{
		$errors = array();
		$orderProps = $order->getPropertyCollection();

		if($email = $orderProps->getUserEmail())
			$email = $email->getValue();

		if($name = $orderProps->getPayerName())
			$name = $name->getValue();

		$userId = \CSaleUser::DoAutoRegisterUser(
			$email,
			$name,
			$formData["SITE_ID"],
			$errors);

		if (!empty($errors))
		{
			$errorMessage = "";

			foreach($errors as $val)
				$errorMessage .= $val["TEXT"];

			throw new UserMessageException($errorMessage);
		}

		return $userId;
	}

	protected static function getUserId($order, $formData, $createUserIfNeed, \Bitrix\Sale\Result &$result)
	{
		if(intval($formData["USER_ID"]) > 0)
			return intval($formData["USER_ID"]);

		$userId = 0;

		if($createUserIfNeed && (!isset($formData["USER_ID"]) || intval($formData["USER_ID"]) <= 0))
		{
			try
			{
				$userId = self::createUserFromForm($order, $formData);
			}
			catch(UserMessageException $e)
			{
				$result->addError( new EntityError($e->getMessage()));
			}
		}

		return $userId;
	}

	/**
	 * @param array $formData
	 * @param $creatorUserId
	 * @param bool $createUserIfNeed
	 * @param array $files
	 * @param Result &$opResult
	 * @return Order
	 * @throws ArgumentNullException
	 * @throws SystemException
	 */
	public static function createOrderFromForm(array $formData, $creatorUserId, $createUserIfNeed = true, array $files = array(), Result &$opResult)
	{
		if(!isset($formData["SITE_ID"]) || strlen($formData["SITE_ID"]) <= 0)
			throw new ArgumentNullException('formData["SITE_ID"]');

		global $APPLICATION, $USER;

		$order = Order::create($formData["SITE_ID"]);

		$saleModulePermissions = $APPLICATION->GetGroupRight("sale");

		$userCompanyId = null;

		if($saleModulePermissions == "P")
		{
			$userCompanyList = Company\Manager::getUserCompanyList($USER->GetID());
			if (!empty($userCompanyList) && is_array($userCompanyList))
			{
				$userCompanyId = reset($userCompanyList);
				if (intval($userCompanyId) > 0 && empty($formData['ORDER']['COMPANY_ID']))
				{
					$formData['ORDER']['COMPANY_ID'] = $userCompanyId;
				}
			}
		}

		/** @var \Bitrix\Sale\Result $res */
		$res = self::fillSimpleFields($order, $formData, $creatorUserId);

		if(!$res->isSuccess())
			$opResult->addErrors($res->getErrors());

		$propCollection = $order->getPropertyCollection();
		$res = $propCollection->setValuesFromPost($formData, $files);

		if(!$res->isSuccess())
			$opResult->addErrors($res->getErrors());

		//creates new user if need
		$order->setFieldNoDemand(
			"USER_ID",
			self::getUserId($order, $formData, $createUserIfNeed, $opResult)
		);

		$fUserId = null;

		if ($order->getUserId() > 0)
		{
			$fUserId = Fuser::getIdByUserId($order->getUserId());
		}

		$needDataUpdate = array();
		$basketCodeMap = array();

		//init basket
		if(isset($formData["PRODUCT"]) && is_array($formData["PRODUCT"]) && !empty($formData["PRODUCT"]))
		{
			$isStartField = $order->isStartField();
			$basket = \Bitrix\Sale\Basket::create($formData["SITE_ID"]);

			$res = $order->setBasket($basket);

			if(!$res->isSuccess())
				$opResult->addErrors($res->getErrors());

			$basket->setFUserId($fUserId);
			\Bitrix\Sale\ProviderBase::setUsingTrustData(true);

			$sort = 100;
			$maxBasketCodeIdx = 0;

			foreach($formData["PRODUCT"] as $basketCode => $productData)
			{
				$formData["PRODUCT"][$basketCode]["SORT"] = $sort;
				$sort += 100;

				/* Fix collision if price of new product is larger than exists have.
				 * After sorting new product pick basket code from existing products.
				 * See below.
				 */
				if(self::isBasketItemNew($basketCode))
				{
					$basketInternalId = intval(substr($basketCode, 1));

					if($basketInternalId > $maxBasketCodeIdx)
						$maxBasketCodeIdx = $basketInternalId;

					if(self::$needUpdateNewProductPrice)
					{
						unset($formData["PRODUCT"][$basketCode]["PROVIDER_DATA"]);
						unset($formData["PRODUCT"][$basketCode]["SET_ITEMS_DATA"]);
					}
				}
			}

			sortByColumn($formData["PRODUCT"], array("BASE_PRICE" => SORT_DESC, "PRICE" => SORT_DESC), '', null, true);

			foreach($formData["PRODUCT"] as $basketCode => $productData)
			{
				if($productData["IS_SET_ITEM"] == "Y")
					continue;

				if(!isset($productData["PROPS"]) || !is_array($productData["PROPS"]))
					$productData["PROPS"] = array();

				$item = $basket->getExistsItem($productData["MODULE"], $productData["OFFER_ID"], $productData["PROPS"]);

				if($item == null && $basketCode != self::BASKET_CODE_NEW)
					$item = $basket->getItemByBasketCode($basketCode);

				if($item && $item->isBundleChild())
					$item = null;

				if($item)
				{
					//Let's extract cached provider product data from field
					if(!empty($productData["PROVIDER_DATA"]))
					{
						$providerData = unserialize($productData["PROVIDER_DATA"]);
						self::setProviderTrustData($item, $order, $providerData);
					}

					if(!empty($productData["SET_ITEMS_DATA"]))
						$productData["SET_ITEMS"] = unserialize($productData["SET_ITEMS_DATA"]);

					$res = $item->setField("QUANTITY", $item->getField("QUANTITY")+$productData["QUANTITY"]);

					if(!$res->isSuccess())
						$opResult->addErrors($res->getErrors());
				}
				else
				{
					if($basketCode != self::BASKET_CODE_NEW)
						$setBasketCode = $basketCode;
					elseif(intval($maxBasketCodeIdx) > 0)
						$setBasketCode = 'n'.strval($maxBasketCodeIdx+1); //Fix collision part 2.
					else
						$setBasketCode = null;

					$item = $basket->createItem($productData["MODULE"],	$productData["OFFER_ID"], $setBasketCode);

					if ($basketCode != $productData["BASKET_CODE"])
						$productData["BASKET_CODE"] = $item->getBasketCode();

					if($basketCode == self::BASKET_CODE_NEW)
					{
						$opResult->setData(array("NEW_ITEM_BASKET_CODE" => $productData["BASKET_CODE"]));
						$needDataUpdate[] = $item->getBasketCode();
					}

					if(!empty($productData['REPLACED']) && $productData['REPLACED'] == 'Y')
						$needDataUpdate[] = $item->getBasketCode();

					if($basketCode != $item->getBasketCode())
						$basketCodeMap[$basketCode] = $item->getBasketCode();

					if(isset($productData["PROPS"]) && !empty($productData["PROPS"]) && is_array($productData["PROPS"]))
					{
						/** @var \Bitrix\Sale\BasketPropertiesCollection $property */
						$property = $item->getPropertyCollection();
						$property->setProperty($productData["PROPS"]);
					}
				}
			}

			$productsData = $formData["PRODUCT"];

			if(!empty($basketCodeMap))
			{
				foreach($basketCodeMap as $old => $new)
				{
					$productsData[$new] = $productsData[$old];
					unset($productsData[$old]);
				}
			}

			$res = self::fillBasketItems($basket, $productsData, $order, array_unique($needDataUpdate));

			if(!$res->isSuccess())
			{
				$opResult->addErrors($res->getErrors());
//				return null;
			}

			if ($isStartField)
			{
				$hasMeaningfulFields = $order->hasMeaningfulField();

				/** @var Result $r */
				$r = $order->doFinalAction($hasMeaningfulFields);
				if (!$r->isSuccess())
				{
					$opResult->addErrors($r->getErrors());
				}
			}

			if(isset($formData["DISCOUNTS"]) && is_array($formData["DISCOUNTS"]))
				$order->getDiscount()->setApplyResult($formData["DISCOUNTS"]);
		}
		else
		{
			$opResult->addError(new EntityError(Loc::getMessage("SALE_ORDEREDIT_ERROR_NO_PRODUCTS")));
		}

		return $order;
	}

	protected static function isBasketItemNew($basketCode)
	{
		return (strpos($basketCode, 'n') === 0) && ($basketCode != self::BASKET_CODE_NEW);
	}

	public static function saveCoupons($userId, $formData)
	{
		if(intval($userId) <= 0)
			return false;

		// init discount coupons
		DiscountCouponsManager::init(DiscountCouponsManager::MODE_MANAGER, array("userId" => $userId));

		if(!DiscountCouponsManager::isSuccess())
			throw new UserMessageException(implode(" \n", DiscountCouponsManager::getErrors()));

		if(isset($formData["COUPONS"]) && strlen($formData["COUPONS"]) > 0)
		{
			$coupons = explode(",", $formData["COUPONS"]);

			if(is_array($coupons) && count($coupons) > 0)
			{
				foreach($coupons as $coupon)
					DiscountCouponsManager::add($coupon);
			}
		}

		return true;
	}

	public static function saveProfileData($profileId, Order $order, array $formData)
	{
		$result = new Result();
		$errors = array();
		$name = "";

		if($profileName = $order->getPropertyCollection()->getProfileName())
			$name = $profileName->getValue();

		$res = \CSaleOrderUserProps::DoSaveUserProfile(
			$order->getUserId(),
			$profileId,
			$name,
			$order->getPersonTypeId(),
			$propCollection = $formData["PROPERTIES"],
			$errors
		);

		if($res === false)
		{
			if(!empty($errors))
			{
				foreach($errors as $error)
					$result->addError(new EntityError($error."<br>\n"));
			}
			else
			{
				$result->addError(new EntityError(Loc::getMessage("SALE_ORDEREDIT_PROFILE_ERROR_SAVE")));
			}
		}

		return $result;
	}

	/**
	 * @param array $formData
	 * @param Order $order
	 * @param int $userId
	 * @param bool $createUserIfNeed
	 * @param array $files
	 * @param \Bitrix\Sale\Result $result
	 * @return \Bitrix\Sale\Order
	 * @throws SystemException
	 * @throws \Bitrix\Main\ObjectNotFoundException
	 */
	public static function editOrderByFormData(array $formData, Order $order, $userId, $createUserIfNeed = true, array $files = array(), \Bitrix\Sale\Result &$result)
	{
		/** @var \Bitrix\Sale\Result $res */
		$res = self::fillSimpleFields($order, $formData, $userId);

		if(!$res->isSuccess())
			$result->addErrors($res->getErrors());

		$propCollection = $order->getPropertyCollection();
		$res = $propCollection->setValuesFromPost($formData, $files);

		if(!$res->isSuccess())
			$result->addErrors($res->getErrors());

		$currentUserId = $order->getUserId();
		if ($currentUserId && ((int)$currentUserId !== (int)$formData['USER_ID']))
		{
			$paymentCollection = $order->getPaymentCollection();
			/** @var \Bitrix\Sale\Payment $payment */
			foreach ($paymentCollection as $payment)
			{
				if ($payment->isPaid())
				{
					$result->addError(new EntityError(
						Loc::getMessage("SALE_ORDEREDIT_ERROR_CHANGE_USER_WITH_PAID_PAYMENTS")
					, 'SALE_ORDEREDIT_ERROR_CHANGE_USER_WITH_PAID_PAYMENTS'));
					return null;
				}
			}
		}

		$order->setFieldNoDemand(
			"USER_ID",
			self::getUserId($order, $formData, $createUserIfNeed, $result)
		);

		if(isset($formData["DISCOUNTS"]) && is_array($formData["DISCOUNTS"]))
			$order->getDiscount()->setApplyResult($formData["DISCOUNTS"]);

		//init basket
		$basket = $order->getBasket();
		$itemsBasketCodes = array();
		$maxBasketCodeIdx = 0;
		$productAdded = false;
		$productDeleted = false;

		if(isset($formData["PRODUCT"]) && is_array($formData["PRODUCT"]) && !empty($formData["PRODUCT"]))
		{
			$sort = 100;

			foreach($formData["PRODUCT"] as $basketCode => $productData)
			{
				$formData["PRODUCT"][$basketCode]["SORT"] = $sort;
				$sort += 100;

				/* Fix collision if price of new product is larger than added earlier have.
				 * After sorting new product pick basket code from existing products.
				 * See below.
				 */
				if(self::isBasketItemNew($basketCode))
				{
					$basketInternalId = intval(substr($basketCode, 1));

					if($basketInternalId > $maxBasketCodeIdx)
						$maxBasketCodeIdx = $basketInternalId;

					$needDataUpdate[] = $basketCode;
					unset($formData["PRODUCT"][$basketCode]["PROVIDER_DATA"]);
					unset($formData["PRODUCT"][$basketCode]["SET_ITEMS_DATA"]);
				}
			}

			sortByColumn($formData["PRODUCT"], array("BASE_PRICE" => SORT_DESC, "PRICE" => SORT_DESC), '', null, true);

			//we choose sku wich already exist in basket, so we must kill one of them.
			if(!empty($formData["ALREADY_IN_BASKET_CODE"]))
			{
				$item = $basket->getItemByBasketCode($formData["ALREADY_IN_BASKET_CODE"]);

				if($item)
				{
					$res = $item->delete();

					if (!$res->isSuccess())
					{
						$errMess = "";

						foreach($res->getErrors() as $error)
							$errMess .= $error->getMessage()."\n";

						if(strlen($errMess) <= 0)
							$errMess = Loc::getMessage("SALE_ORDEREDIT_BASKET_ITEM_DEL_ERROR");

						$result->addError(new Error($errMess));
						return null;
					}
				}
			}

			foreach($formData["PRODUCT"] as $basketCode => $productData)
			{
				if (!isset($productData["PROPS"]))
					$productData["PROPS"] = array();

				$item = $basket->getExistsItem($productData["MODULE"], $productData["OFFER_ID"], $productData["PROPS"]);

				if ($item == null)
					DiscountCouponsManager::useSavedCouponsForApply(false);

				if($item == null && $basketCode != self::BASKET_CODE_NEW)
					$item = $basket->getItemByBasketCode($basketCode);

				if($item && $item->isBundleChild())
					continue;

				if(!$item)
					continue;

				$itemsBasketCodes[] = $item->getBasketCode();
			}
		}

		/** @var  \Bitrix\Sale\BasketItem  $item */
		$basketItems = $basket->getBasketItems();

		foreach($basketItems as $item)
		{
			if(!in_array($item->getBasketCode(), $itemsBasketCodes))
			{
				$res = $item->delete();

				if (!$res->isSuccess())
				{
					$errMess = "";

					foreach($res->getErrors() as $error)
						$errMess .= $error->getMessage()."\n";

					if(strlen($errMess) <= 0)
						$errMess = Loc::getMessage("SALE_ORDEREDIT_BASKET_ITEM_DEL_ERROR");

					$result->addError(new Error($errMess));
					return null;
				}
				else
				{
					$productDeleted = true;
				}
			}
		}

		\Bitrix\Sale\ProviderBase::setUsingTrustData(true);
		$isStartField = $order->isStartField();
		$needDataUpdate = array();
		$basketCodeMap = array();

		if(isset($formData["PRODUCT"]) && is_array($formData["PRODUCT"]) && !empty($formData["PRODUCT"]))
		{
			foreach($formData["PRODUCT"] as $basketCode => $productData)
			{
				$providerData = array();

				if($productData["IS_SET_ITEM"] == "Y")
					continue;

				if(!isset($productData["PROPS"]) || !is_array($productData["PROPS"]))
					$productData["PROPS"] = array();

				if(empty($productData['MANUALLY_EDITED']))
					$item = $basket->getExistsItem($productData["MODULE"], $productData["OFFER_ID"], $productData["PROPS"]);
				else
					$item = $basket->getItemByBasketCode($basketCode);

				//sku was changed
				if($item == null && $basketCode != self::BASKET_CODE_NEW)
				{
					if($item = $basket->getItemByBasketCode($basketCode))
					{
						$res = $item->delete();

						if(!$res->isSuccess())
						{
							$result->addErrors($res->getErrors());
							return null;
						}

						$item = null;
					}
				}

				if($item && $item->isBundleChild())
					$item = null;

				if(!$item)
				{
					if($basketCode != self::BASKET_CODE_NEW)
						$setBasketCode = $basketCode;
					elseif(intval($maxBasketCodeIdx) > 0)
						$setBasketCode = 'n'.strval($maxBasketCodeIdx+1); //Fix collision part 2.
					else
						$setBasketCode = null;

					$item = $basket->createItem(
						$productData["MODULE"],
						$productData["OFFER_ID"],
						$setBasketCode
					);

					if ($basketCode != $productData["BASKET_CODE"])
						$productData["BASKET_CODE"] = $item->getBasketCode();

					if($basketCode == self::BASKET_CODE_NEW)
					{
						$result->setData(array("NEW_ITEM_BASKET_CODE" => $productData["BASKET_CODE"]));
						$needDataUpdate[] = $item->getBasketCode();
					}

					if(!empty($productData['REPLACED']) && $productData['REPLACED'] == 'Y')
						$needDataUpdate[] = $item->getBasketCode();

					if(!$productAdded)
						$productAdded = true;
				}
				else
				{
					if ($basketCode != $productData["BASKET_CODE"])
						$productData["BASKET_CODE"] = $item->getBasketCode();

					if(isset($productData["OFFER_ID"]) || intval($productData["OFFER_ID"]) >= 0)
						$productData["PRODUCT_ID"] = $productData["OFFER_ID"];

					$itemFields = array_intersect_key($productData, array_flip($item::getAvailableFields()));

					if(isset($itemFields["MEASURE_CODE"]) && strlen($itemFields["MEASURE_CODE"]) > 0)
					{
						$measures = OrderBasket::getCatalogMeasures();

						if(isset($measures[$itemFields["MEASURE_CODE"]]) && strlen($measures[$itemFields["MEASURE_CODE"]]) > 0)
							$itemFields["MEASURE_NAME"] = $measures[$itemFields["MEASURE_CODE"]];
					}

					if(!empty($productData["PROVIDER_DATA"]) && !self::$needUpdateNewProductPrice)
					{
						$providerData = unserialize($productData["PROVIDER_DATA"]);
					}

					if(is_array($providerData) && !empty($providerData))
						self::setProviderTrustData($item, $order, $providerData);

					if(!empty($productData["SET_ITEMS_DATA"]))
						$productData["SET_ITEMS"] = unserialize($productData["SET_ITEMS_DATA"]);

					/** @var \Bitrix\Sale\Result $res */
					$res = self::setBasketItemFields($item, $itemFields);

					if (!$res->isSuccess())
					{
						$result->addErrors($res->getErrors());
						return null;
					}
				}

				/*
				 * Could be deleted and than added one more time product.
				 * Or just added product.
				 */
				if($basketCode != $item->getBasketCode())
					$basketCodeMap[$basketCode] = $item->getBasketCode();

				if(!empty($productData["PROPS"]) && is_array($productData["PROPS"]))
				{
					/** @var \Bitrix\Sale\BasketPropertiesCollection $property */
					$property = $item->getPropertyCollection();
					$property->setProperty($productData["PROPS"]);
				}
			}

			$productsData = $formData["PRODUCT"];

			if(!empty($basketCodeMap))
			{
				foreach($basketCodeMap as $old => $new)
				{
					$productsData[$new] = $productsData[$old];
					unset($productsData[$old]);
				}
			}

			$res = self::fillBasketItems($basket, $productsData, $order, array_unique($needDataUpdate));

			if(!$res->isSuccess())
			{
				$result->addErrors($res->getErrors());
				return null;
			}

			if ($isStartField)
			{
				$hasMeaningfulFields = $order->hasMeaningfulField();

				/** @var Result $r */
				$r = $order->doFinalAction($hasMeaningfulFields);
				if (!$r->isSuccess())
				{
					$result->addErrors($r->getErrors());
				}
			}

			if(isset($formData["DISCOUNTS"]) && is_array($formData["DISCOUNTS"]))
				$order->getDiscount()->setApplyResult($formData["DISCOUNTS"]);
		}
		else
		{
			$result->addError(new EntityError(Loc::getMessage("SALE_ORDEREDIT_ERROR_NO_PRODUCTS")));
		}

		if($productAdded || $productDeleted)
		{
			$res = $basket->refreshData(array('PRICE', 'COUPONS'));

			if (!$res->isSuccess())
				$result->addErrors($res->getErrors());
		}

		return $order;
	}

	/**
	 * @param Order $order
	 * @param array $formData
	 * @param int $userId
	 *
	 * @return \Bitrix\Sale\Result
	 */
	protected static function fillSimpleFields(Order $order, array $formData, $userId = 0)
	{
		$result = new \Bitrix\Sale\Result();
		if(isset($formData["ORDER"]["RESPONSIBLE_ID"]))
		{
			if (intval($formData["ORDER"]["RESPONSIBLE_ID"]) != intval($order->getField('RESPONSIBLE_ID')))
			{
				/** @var \Bitrix\Sale\Result $r */
				$r = $order->setField("RESPONSIBLE_ID", $formData["ORDER"]["RESPONSIBLE_ID"]);
				if (!$r->isSuccess())
				{
					$result->addErrors($r->getErrors());
				}
			}
		}

		if(!empty($formData["ORDER"]) && array_key_exists('COMPANY_ID', $formData["ORDER"]))
		{
			/** @var \Bitrix\Sale\Result $r */
			$r = $order->setField("COMPANY_ID", (isset($formData["ORDER"]['COMPANY_ID']) && $formData["ORDER"]['COMPANY_ID'] > 0) ? $formData["ORDER"]['COMPANY_ID'] : 0);
			if (!$r->isSuccess())
			{
				$result->addErrors($r->getErrors());
			}
		}

		if(isset($formData["PERSON_TYPE_ID"]) && intval($formData["PERSON_TYPE_ID"]) > 0)
		{
			/** @var \Bitrix\Sale\Result $r */
			$r = $order->setPersonTypeId(intval($formData['PERSON_TYPE_ID']));
		}
		else
		{
			/** @var \Bitrix\Sale\Result $r */
			$r = $order->setPersonTypeId(
				Blocks\OrderBuyer::getDefaultPersonType(
					$order->getSiteId()
				)
			);
		}

		if (!$r->isSuccess())
		{
			$result->addErrors($r->getErrors());
		}

		if(isset($formData["ORDER"]["COMMENTS"]))
		{
			/** @var \Bitrix\Sale\Result $r */
			$r = $order->setField("COMMENTS", $formData["ORDER"]["COMMENTS"]);
			if (!$r->isSuccess())
			{
				$result->addErrors($r->getErrors());
			}
		}

		if(isset($formData["USER_DESCRIPTION"]))
		{
			/** @var \Bitrix\Sale\Result $r */
			$r = $order->setField("USER_DESCRIPTION", $formData["USER_DESCRIPTION"]);
			if (!$r->isSuccess())
			{
				$result->addErrors($r->getErrors());
			}
		}

		if(isset($formData["RESPONSIBLE_ID"]))
		{
			/** @var \Bitrix\Sale\Result $r */
			$r = $order->setField("RESPONSIBLE_ID", $formData["RESPONSIBLE_ID"]);
			if (!$r->isSuccess())
			{
				$result->addErrors($r->getErrors());
			}
		}

		if(isset($formData["STATUS_ID"]) && strlen($formData["STATUS_ID"]) > 0)
		{
			$statusesList = \Bitrix\Sale\OrderStatus::getAllowedUserStatuses(
				$userId,
				\Bitrix\Sale\OrderStatus::getInitialStatus()
			);

			if(array_key_exists($formData["STATUS_ID"], $statusesList))
			{
				/** @var \Bitrix\Sale\Result $r */
				$r = $order->setField("STATUS_ID", $formData["STATUS_ID"]);
				if (!$r->isSuccess())
				{
					$result->addErrors($r->getErrors());
				}
			}
		}

		return $result;
	}

	public static function fillBasketItems(Basket &$basket, array $productsFormData, Order $order, array $needDataUpdate = array())
	{
		$basketItems = $basket->getBasketItems();
		$result = new Result();
		$catalogProductsIds = array();
		$trustData = array();

		// Preparing fields need by provider
		/** @var  \Bitrix\Sale\BasketItem  $item */
		foreach($basketItems as $item)
		{
			$basketCode = $item->getBasketCode();

			if(empty($productsFormData[$basketCode]))
				continue;

			$productData = $productsFormData[$basketCode];
			$isDataNeedUpdate = in_array($basketCode, $needDataUpdate);

			if(isset($productData["PRODUCT_PROVIDER_CLASS"]) && strlen($productData["PRODUCT_PROVIDER_CLASS"]) > 0)
				$item->setField("PRODUCT_PROVIDER_CLASS", trim($productData["PRODUCT_PROVIDER_CLASS"]));

			/*
			 * Let's extract cached provider product data from field
			 * in case activity is through ajax.
			 */
			if(self::$isTrustProductFormData && !$isDataNeedUpdate)
			{
				if(!empty($productData["PROVIDER_DATA"]))
					$trustData[$basketCode] = unserialize($productData["PROVIDER_DATA"]);

				// if quantity changed we must get fresh data from provider
				if(!empty($trustData[$basketCode]) && $trustData[$basketCode]["QUANTITY"] == $productData["QUANTITY"])
				{
					if(!empty($productData["SET_ITEMS_DATA"]))
						$productData["SET_ITEMS"] = unserialize($productData["SET_ITEMS_DATA"]);

					if(is_array($trustData[$basketCode]) && !empty($trustData[$basketCode]))
						self::setProviderTrustData($item, $order, $trustData[$basketCode]);
				}
				else
				{
					unset($trustData[$basketCode]);
				}
			}

			$item->setField("NAME", $productData["NAME"]);
			$res = $item->setField("QUANTITY", $productData["QUANTITY"]);

			if(!$res->isSuccess())
			{
				$result->addErrors($res->getErrors());
				//return $result;
			}

			if(isset($productData["MODULE"]) && $productData["MODULE"] == "catalog")
				$catalogProductsIds[] = $item->getField('PRODUCT_ID');
		}

		$catalogData = array();

		if(!empty($catalogProductsIds))
			$catalogData = 	OrderBasket::getProductsData($catalogProductsIds, $order->getSiteId(), array(), $order->getUserId());

		$providerData = array();

		if(!self::$isTrustProductFormData || !empty($needDataUpdate) || self::$needUpdateNewProductPrice)
		{
			$params = array("AVAILABLE_QUANTITY");

			if($order->getId() <= 0)
				$params[] = "PRICE";

			$providerData = Provider::getProductData($basket, $params);
		}

		$data = array();

		foreach($basketItems as $item)
		{
			$basketCode = $item->getBasketCode();
			$productData = $productsFormData[$basketCode];
			$isDataNeedUpdate = in_array($basketCode, $needDataUpdate);
			$data[$basketCode] = $item->getFieldValues();

			if(!empty($providerData[$basketCode]))
			{
				$data[$basketCode] = $providerData[$basketCode];
			}
			elseif(!empty($trustData[$basketCode]))
			{
				$data[$basketCode] = $trustData[$basketCode];
			}
			else
			{
				$data = Provider::getProductData($basket, array("PRICE", "AVAILABLE_QUANTITY"), $item);

				if(is_array($data[$basketCode]) && !empty($data[$basketCode]))
					self::setProviderTrustData($item, $order, $data[$basketCode]);
			}

			/* Get actual info from provider
			 *	cases:
			 *	 1) add new product to basket;
			 *	 2) saving operation;
			 * 	 3) changing quantity;
			 *   4) changing buyerId
			 */
			if($order->getId() <= 0 && (empty($data[$basketCode]) || !self::$isTrustProductFormData || $isDataNeedUpdate))
			{
				if(empty($providerData[$basketCode]) && strlen($productData["PRODUCT_PROVIDER_CLASS"]) > 0)
				{
					$name = "";

					if(!empty($productData["NAME"]))
						$name = $productData["NAME"];

					if(!empty($productData["PRODUCT_ID"]))
						$name .= " (".$productData['PRODUCT_ID'].")";

					$result->addError(
						new Error(
							Loc::getMessage(
								"SALE_ORDEREDIT_PRODUCT_IS_NOT_AVAILABLE",
								array(
									"#NAME_ID#" => $name
								)
							)
						)
					);

//					return $result;
				}
			}

			$product = array();

			if(isset($data[$basketCode]) && !empty($data[$basketCode]))
			{
				$product = $data[$basketCode];

				if(isset($productData['PRICE']) && isset($productData['CUSTOM_PRICE']) && $productData['CUSTOM_PRICE'] == 'Y')
					$product['PRICE'] = $productData['PRICE'];
				elseif(isset($product['BASE_PRICE']))
					$product['PRICE'] = $product['BASE_PRICE'] - $product['DISCOUNT_PRICE'];

				$discount = $order->getDiscount();

				if ($discount instanceof Discount)
					$discount->setBasketItemData($basketCode, $data[$basketCode]);
			}

			if($item->getField("MODULE") == "catalog")
			{
				if(!empty($catalogData[$item->getProductId()]))
				{
					$product = array_merge($product, $catalogData[$item->getProductId()]);
					unset($productData["CURRENCY"]);
				}
			}

			if(!self::$isTrustProductFormData || $isDataNeedUpdate)
			{
				$product = array_merge($productData, $product);
			}
			else
			{
				$needUpdateItemPrice = self::$needUpdateNewProductPrice && self::isBasketItemNew($basketCode);
				$isPriceCustom = isset($productData['CUSTOM_PRICE']) && $productData['CUSTOM_PRICE'] == 'Y';

				if(($order->getId() <= 0 && !$isPriceCustom) || $needUpdateItemPrice)
					unset($productData['PRICE'], $productData['PRICE_BASE'], $productData['BASE_PRICE']);

				$product = array_merge($product, $productData);
			}

			if(isset($product["OFFER_ID"]) || intval($product["OFFER_ID"]) >= 0)
				$product["PRODUCT_ID"] = $product["OFFER_ID"];

			$product = array_intersect_key($product, array_flip($item::getAvailableFields()));

			if(isset($product["MEASURE_CODE"]) && strlen($product["MEASURE_CODE"]) > 0)
			{
				$measures = OrderBasket::getCatalogMeasures();

				if(isset($measures[$product["MEASURE_CODE"]]) && strlen($measures[$product["MEASURE_CODE"]]) > 0)
					$product["MEASURE_NAME"] = $measures[$product["MEASURE_CODE"]];
			}

			if(!isset($product["CURRENCY"]) || strlen($product["CURRENCY"]) <= 0)
				$product["CURRENCY"] = $order->getCurrency();

			if($productData["IS_SET_PARENT"] == "Y")
				$product["TYPE"] = BasketItem::TYPE_SET;

			OrderEdit::setProductDetails(
				$productData["OFFER_ID"],
				$order->getUserId(),
				$order->getSiteId(),
				array_merge($product, $productData)
			);

			$res = self::setBasketItemFields($item, $product);

			if(!$res->isSuccess())
			{
				foreach($res->getErrors() as $newError)
				{
					foreach($result->getErrors() as $existError)
						if($newError->getMessage() == $existError->getMessage())
							continue 2;

					$result->addError($newError);
				}
			}
		}

		return $result;
	}

	/**
	 * @param BasketItem $item
	 * @param array $productData
	 * @return \Bitrix\Sale\Result
	 * @throws SystemException
	 * @deprecated use \Bitrix\Sale\Helpers\Admin\OrderEdit::fillBasketItems()
	 */
	public static function fillBasketItem(BasketItem &$item, array $productData, Order $order, Basket $basket, $needDataUpdate = false)
	{
		$result = new Result();
		$basketCode = $item->getBasketCode();

		if(isset($productData["PRODUCT_PROVIDER_CLASS"]) && strlen($productData["PRODUCT_PROVIDER_CLASS"]) > 0)
			$item->setField("PRODUCT_PROVIDER_CLASS", trim($productData["PRODUCT_PROVIDER_CLASS"]));

		$data = array();

		/*
		 * Let's extract cached provider product data from field
		 * in case activity is through ajax.
		 */
		if(self::$isTrustProductFormData && !$needDataUpdate)
		{
			if(!empty($productData["PROVIDER_DATA"]))
				$data[$basketCode] = unserialize($productData["PROVIDER_DATA"]);

			// if quantity changed we must get fresh data from provider
			if(!empty($data[$basketCode]) && $data[$basketCode] == $productData["QUANTITY"])
			{
				if(!empty($productData["SET_ITEMS_DATA"]))
					$productData["SET_ITEMS"] = unserialize($productData["SET_ITEMS_DATA"]);

				if(is_array($data[$basketCode]) && !empty($data[$basketCode]))
					self::setProviderTrustData($item, $order, $data[$basketCode]);
			}
			else
			{
				unset($data[$basketCode]);
			}
		}

		$item->setField("NAME", $productData["NAME"]);
		$res = $item->setField("QUANTITY", $productData["QUANTITY"]);

		if(!$res->isSuccess())
		{
			$result->addErrors($res->getErrors());
			return $result;
		}

		$product = array();

		/* Get actual info from provider
		 *	cases:
		 *	 1) add new product to basket;
		 *	 2) saving operation;
		 * 	 3) changing quantity;
		 */
		if(empty($data[$basketCode]) || !self::$isTrustProductFormData || $needDataUpdate)
		{
			$data = Provider::getProductData($basket, array("PRICE", "AVAILABLE_QUANTITY"), $item);

			if(empty($data[$basketCode]) && strlen($productData["PRODUCT_PROVIDER_CLASS"]) > 0)
			{
				$name = "";

				if(!empty($productData["NAME"]))
					$name = $productData["NAME"];

				if(!empty($productData["PRODUCT_ID"]))
					$name .= " (".$productData['PRODUCT_ID'].")";

				$result->addError(
					new Error(
						Loc::getMessage(
							"SALE_ORDEREDIT_PRODUCT_IS_NOT_AVAILABLE",
							array(
								"#NAME_ID#" => $name
							)
						)
					)
				);

				return $result;
			}

			if(is_array($data[$basketCode]) && !empty($data[$basketCode]))
				self::setProviderTrustData($item, $order, $data[$basketCode]);
		}

		if(isset($data[$basketCode]) && !empty($data[$basketCode]))
		{
			$product = $data[$basketCode];

			if(isset($productData['PRICE']) && isset($productData['CUSTOM_PRICE']) && $productData['CUSTOM_PRICE'] == 'Y')
				$product['PRICE'] = $productData['PRICE'];
			elseif(isset($product['BASE_PRICE']))
				$product['PRICE'] = $product['BASE_PRICE'] - $product['DISCOUNT_PRICE'];

			$discount = $order->getDiscount();
			if ($discount instanceof Discount)
				$discount->setBasketItemData($basketCode, $data[$basketCode]);
		}

		if(!self::$isTrustProductFormData)
		{
			if(isset($productData["MODULE"]) && $productData["MODULE"] == "catalog")
			{
				$data = OrderBasket::getProductDetails(
					$item->getProductId(),
					$productData["QUANTITY"],
					$order->getUserId(),
					$order->getSiteId()
				);

				$product = array_merge($product, $data);
			}

			unset($productData["CURRENCY"]);
		}

		$product = array_merge($product, $productData);

		if(isset($product["OFFER_ID"]) || intval($product["OFFER_ID"]) >= 0)
				$product["PRODUCT_ID"] = $product["OFFER_ID"];

		$product = array_intersect_key($product, array_flip($item::getAvailableFields()));

		if(isset($product["MEASURE_CODE"]) && strlen($product["MEASURE_CODE"]) > 0)
		{
			$measures = OrderBasket::getCatalogMeasures();

			if(isset($measures[$product["MEASURE_CODE"]]) && strlen($measures[$product["MEASURE_CODE"]]) > 0)
				$product["MEASURE_NAME"] = $measures[$product["MEASURE_CODE"]];
		}

		if(!isset($product["CURRENCY"]) || strlen($product["CURRENCY"]) <= 0)
			$product["CURRENCY"] = $order->getCurrency();

		if($productData["IS_SET_PARENT"] == "Y")
			$product["TYPE"] = BasketItem::TYPE_SET;

		OrderEdit::setProductDetails(
			$productData["OFFER_ID"],
			$order->getUserId(),
			$order->getSiteId(),
			array_merge($product, $productData)
		);

		$result = self::setBasketItemFields($item, $product);
		return $result;
	}

	public static function setProviderTrustData(BasketItem $item, Order $order, array $data)
	{
		if(empty($data))
			return false;

		Provider::setTrustData($order->getSiteId(), $item->getField('MODULE'), $item->getProductId(), $data);

		if ($item->isBundleParent())
		{
			if ($bundle = $item->getBundleCollection())
			{
				/** @var \Bitrix\Sale\BasketItem $bundleItem */
				foreach ($bundle as $bundleItem)
				{
					$bundleItemData = $bundleItem->getFields()->getValues();
					Provider::setTrustData($order->getSiteId(), 'sale', $bundleItem->getProductId(), $bundleItemData);
				}
			}
		}

		return true;
	}

	protected static function setBasketItemFields(\Bitrix\Sale\BasketItem &$item, array $fields = array())
	{
		$result = $item->setFields($fields);

		if(!$result->isSuccess())
		{
			foreach($result->getErrors() as $error)
			{
				if($error->getCode() == "CATALOG_QUANTITY_NOT_ENOGH")
				{
					if((string)Option::get('catalog', 'allow_negative_amount') != 'Y')
					{
						$data = $result->getData();
						$res = $item->setField("QUANTITY", $data["AVAILABLE_QUANTITY"]);

						if(!$res->isSuccess())
							$result->addErrors($res->getErrors());
					}
				}
			}
		}

		return $result;
	}

	public static function getSiteName(&$siteId)
	{
		$siteName = "";

		if(strlen($siteId) <= 0)
		{
			$res = \CSite::GetList($by="id", $order="asc", array("ACTIVE" => "Y", "DEF" => "Y"));

			if($site = $res->Fetch())
			{
				$siteId = $site["ID"];
				$siteName = $site["NAME"]." (".$siteId.")";
			}
		}
		else
		{
			$res = \CSite::GetByID($siteId);

			if($site = $res->Fetch())
				$siteName = $site["NAME"]." (".$siteId.")";
		}

		return $siteName;
	}

	public static function restoreFieldsNames(array $data, $path = "")
	{
		$result = array();

		foreach($data as $fieldName => $fieldValue)
		{
			$fullName = ($path == "" ? $fieldName : $path."[".$fieldName."]");

			if(is_array($fieldValue))
				$result = array_merge($result, self::restoreFieldsNames($fieldValue, $fullName));
			else
				$result[$fullName] = $fieldValue;
		}

		return $result;
	}

	/**
	 * @param $newUserId
	 * @param int $orderId
	 * @param int|null $oldUserId
	 */
	public static function initCouponsData($newUserId, $orderId = 0, $oldUserId = 0)
	{
		$newUserId = (int)$newUserId;
		$orderId = (int)$orderId;

		$params = array('userId' => $newUserId);

		if ($oldUserId !== null)
		{
			$oldUserId = (int)$oldUserId;
			if ($oldUserId != $newUserId)
				$params["oldUserId"] = $oldUserId;
		}

		if ($orderId > 0)
		{
			$params['orderId'] = $orderId;

			DiscountCouponsManager::init(
				DiscountCouponsManager::MODE_ORDER,
				$params
			);
		}
		else
		{
			DiscountCouponsManager::init(
				DiscountCouponsManager::MODE_MANAGER,
				$params
			);
		}
	}

	public static function getCouponsData()
	{
		return DiscountCouponsManager::get(true, array(), true, false);
	}

	public static function getDiscountsApplyResult(\Bitrix\Sale\Order $order, $needRecalculate = false)
	{
		static $calcResults = null;

		if ($order instanceof \Bitrix\Sale\Archive\Order)
		{
			/** @var \Bitrix\Sale\Archive\Order $order*/
			return $order->getDiscountData();
		}

		if($calcResults === null || $needRecalculate)
		{
			/** @var \Bitrix\Sale\Result $r */
			$r = $order->getDiscount()->calculate();
			if ($r->isSuccess())
			{
				$discountData = $r->getData();
				$order->applyDiscount($discountData);
				$calcResults = $order->getDiscount()->getApplyResult(true);
			}
		}

		return $calcResults === null ? array() : $calcResults;
	}

	public static function getOrderedDiscounts(\Bitrix\Sale\Order $order, $needRecalculate = true)
	{
		$discounts = self::getDiscountsApplyResult($order, $needRecalculate);
		$discounts["ORDER"] = array();

		if(isset($discounts["DISCOUNT_LIST"]) && is_array($discounts["DISCOUNT_LIST"]))
			$discounts["ORDER"]["DISCOUNT_LIST"] = array_keys($discounts["DISCOUNT_LIST"]);

		return $discounts;
	}

	public static function getCouponList(\Bitrix\Sale\Order $order = null, $needRecalculate = true)
	{
		$result = array();
		$discounts = array();

		if ($order instanceof \Bitrix\Sale\Archive\Order)
		{
			$discounts = $order->getDiscountData();
			return $discounts['COUPON_LIST'];
		}

		$couponsList = self::getCouponsData();

		if($order)
			$discounts = self::getDiscountsApplyResult($order, $needRecalculate);

		if (!empty($couponsList))
		{
			foreach ($couponsList as &$oneCoupon)
			{
				if ($oneCoupon['STATUS'] == DiscountCouponsManager::STATUS_NOT_FOUND || $oneCoupon['STATUS'] == DiscountCouponsManager::STATUS_FREEZE)
					$oneCoupon['JS_STATUS'] = 'BAD';
				elseif ($oneCoupon['STATUS'] == DiscountCouponsManager::STATUS_NOT_APPLYED || $oneCoupon['STATUS'] == DiscountCouponsManager::STATUS_ENTERED)
					$oneCoupon['JS_STATUS'] = 'ENTERED';
				else
					$oneCoupon['JS_STATUS'] = 'APPLYED';

				$oneCoupon['JS_CHECK_CODE'] = '';

				if (isset($oneCoupon['CHECK_CODE_TEXT']))
				{
					$oneCoupon['JS_CHECK_CODE'] = (
					is_array($oneCoupon['CHECK_CODE_TEXT'])
						? implode('<br>', $oneCoupon['CHECK_CODE_TEXT'])
						: $oneCoupon['CHECK_CODE_TEXT']
					);
				}

				if(!empty($discounts) && isset($discounts["COUPON_LIST"]) && is_array($discounts["COUPON_LIST"]))
				{
					foreach($discounts["COUPON_LIST"] as $coupon => $couponParams)
					{
						$couponsList[$coupon]["APPLY"] = $couponParams["APPLY"];
						$couponsList[$coupon]["DISCOUNT_SIZE"] = "";

						if(isset($couponParams["ORDER_DISCOUNT_ID"]) && strlen($couponParams["ORDER_DISCOUNT_ID"]) > 0)
						{
							$couponsList[$coupon]["ORDER_DISCOUNT_ID"] = $couponParams["ORDER_DISCOUNT_ID"];

							if(isset($discounts["DISCOUNT_LIST"][$couponParams["ORDER_DISCOUNT_ID"]]))
							{
								$couponDiscountParams = $discounts["DISCOUNT_LIST"][$couponParams["ORDER_DISCOUNT_ID"]];

								if(isset($couponDiscountParams["ACTIONS_DESCR"]) && is_array($couponDiscountParams["ACTIONS_DESCR"]))
									foreach($couponDiscountParams["ACTIONS_DESCR"] as $key => $val)
										$couponsList[$coupon]["DISCOUNT_SIZE"] .= $val;
							}
						}
					}
				}
			}

			$result = array_values($couponsList);
		}

		return $result;
	}

	public static function getTotalPrices(Order $order, OrderBasket $orderBasket, $needRecalculate = true)
	{
		$result = array(
			'PRICE_TOTAL' => $order->getPrice(),
			'TAX_VALUE' => $order->getTaxValue(),
			'PRICE_DELIVERY_DISCOUNTED' => $order->getDeliveryPrice(),
			'SUM_PAID' => $order->getSumPaid(),
			'ORDER_DISCOUNT_VALUE' => $order->getField('DISCOUNT_VALUE')
		);

		$result["SUM_UNPAID"] = $result["PRICE_TOTAL"] - $result["SUM_PAID"];

		if(!$result["PRICE_DELIVERY_DISCOUNTED"])
			$result["PRICE_DELIVERY_DISCOUNTED"] = 0;

		if(!$result["TAX_VALUE"])
			$result["TAX_VALUE"] = 0;

		$orderDiscount = $order->getDiscount();

		if($orderDiscount)
			$discountsList = self::getDiscountsApplyResult($order, $needRecalculate);
		else
			$discountsList = array();

		if(isset($discountsList["PRICES"]["DELIVERY"]["DISCOUNT"]))
			$result['DELIVERY_DISCOUNT'] = $discountsList["PRICES"]["DELIVERY"]["DISCOUNT"];
		else
			$result['DELIVERY_DISCOUNT'] = 0;

		$result['PRICE_DELIVERY'] = $result['PRICE_DELIVERY_DISCOUNTED'] + $result['DELIVERY_DISCOUNT'];
		$basketData = $orderBasket->getPrices($discountsList);
		$result["PRICE_BASKET_DISCOUNTED"] = $basketData["BASKET_PRICE"];
		$result["PRICE_BASKET"] = $basketData["BASKET_PRICE_BASE"];

		return $result;
	}

	/**
	 * @param $productId
	 * @param $userId
	 * @param $siteId
	 * @param array $params
	 * @throws ArgumentNullException
	 */
	public static function setProductDetails($productId, $userId, $siteId, array $params)
	{
		if(strlen($productId) <= 0)
			return;

		if(strlen($userId) <= 0)
			$userId = "0";

		if(strlen($siteId) <= 0)
			throw new ArgumentNullException("siteId");

		self::$productsDetails[$productId."_".$userId."_".$siteId] = $params;
	}

	public static function getProductDetails($productId, $userId, $siteId)
	{
		if(strlen($productId) <= 0)
		{
			throw new ArgumentNullException("productId");
		}

		if(strlen($userId) <= 0)
			$userId = "0";

		if(strlen($siteId) <= 0)
			throw new ArgumentNullException("siteId");

		if(isset(self::$productsDetails[$productId."_".$userId."_".$siteId]))
			$result = self::$productsDetails[$productId."_".$userId."_".$siteId];
		else
			$result = false;

		return $result;
	}

	/**
	 * @return array
	 * @throws \Bitrix\Main\ArgumentException
	 */
	public static function getCompanyList()
	{
		$dbRes = Company\Manager::getList(
			array(
				'select' => array('ID', 'NAME'),
				'filter' => array('ACTIVE' => 'Y')
			)
		);
		$result = array();
		while ($company = $dbRes->fetch())
			$result[$company["ID"]] = $company["NAME"]." [".$company["ID"]."]";

		return $result;
	}

	public static function getLockingMessage($orderId)
	{
		$intLockUserID = 0;
		$strLockTime = '';
		$r = \Bitrix\Sale\Order::getLockedStatus($orderId);

		if ($r->isSuccess())
		{
			$lockResult = $r->getData();

			if (array_key_exists('LOCKED_BY', $lockResult) && intval($lockResult['LOCKED_BY']) > 0)
				$intLockUserID = intval($lockResult['LOCKED_BY']);

			if (array_key_exists('DATE_LOCK', $lockResult) && $lockResult['DATE_LOCK'] instanceof \Bitrix\Main\Type\DateTime)
				$strLockTime = $lockResult['DATE_LOCK']->toString();
		}

		$strLockUserInfo = $intLockUserID;

		$userIterator = \Bitrix\Main\UserTable::getList(array(
				'select' => array('ID', 'LOGIN', 'NAME', 'LAST_NAME', 'SECOND_NAME', 'EMAIL'),
				'filter' => array('=ID' => $intLockUserID)
		));

		if ($arOneUser = $userIterator->fetch())
		{
			$strNameFormat = \CSite::GetNameFormat(true);
			$strLockUser = \CUser::FormatName($strNameFormat, $arOneUser);
			$strLockUserInfo = '<a href="/bitrix/admin/user_edit.php?lang='.LANGUAGE_ID.'&ID='.$intLockUserID.'">'.$strLockUser.'</a>';
		}

		return Loc::getMessage(
			'SALE_ORDEREDIT_LOCKED',
			array(
				'#ID#' => $strLockUserInfo,
				'#DATE#' => $strLockTime,
			)
		);
	}
}