<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage sale
 * @copyright 2001-2012 Bitrix
 */
namespace Bitrix\Sale;

use Bitrix\Main;
use Bitrix\Sale\Internals;
use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class BuyerStatistic
{
	/**
	 * Executes the query and returns selection by parameters of the query. This function is an alias to the Query object functions
	 *
	 * @return Main\DB\Result
	 * @throws \Bitrix\Main\ArgumentException
	 */
	public static function getList($filter)
	{
		return Internals\BuyerStatisticTable::getList($filter);
	}

	/**
	 * Fill statistic for user for certain site and currency.
	 * The function'll update values if user entry exists or it'll create new if user entry doesn't exist
	 *
	 * @param $userId
	 * @param $currency
	 * @param $lid
	 *
	 * @return Main\Result
	 */
	public static function calculate($userId, $currency, $lid)
	{
		$result = static::collectUserData($userId, $currency, $lid);

		if (!$result->isSuccess() || $result->hasWarnings())
		{
			return $result;
		}

		$statisticData = static::getList(
			array(
				'select' => array('ID'),
				'filter' => array('=USER_ID' => $userId, '=CURRENCY' => $currency, '=LID' => $lid),
				'limit' => 1
			)
		);

		$buyerStatistic = $statisticData->fetch();
		$id = $buyerStatistic['ID'];

		if (empty($id))
			return Internals\BuyerStatisticTable::add($result->getData());
		else
			return Internals\BuyerStatisticTable::update($id, $result->getData());
	}

	/**
	 * Collect statistic (last order date, count of full paid orders, count of partially paid orders and sum of paid payments) for user, certain site and currency.
	 *
	 * @param $userId
	 * @param $currency
	 * @param $lid
	 *
	 * @return Result
	 */
	protected static function collectUserData($userId, $currency, $lid)
	{
		$result = new Result();
		$userId = (int)$userId;
		if ($userId <= 0)
		{
			$result->addError(new Main\Error('Wrong user id'));
			return $result;
		}

		$orderData = Order::getList(array(
			'select' => array('USER_ID', 'DATE_INSERT'),
			'filter' => array('=USER_ID' => $userId, '=CURRENCY' => $currency, '=LID' => $lid),
			'order' => array('DATE_INSERT' => 'DESC'),
			'limit' => 1
		));

		if ($resultOrder = $orderData->fetch())
		{
			$statistic = array(
				'USER_ID' => $userId,
				'CURRENCY' => $currency,
				'LID' => $lid,
				'LAST_ORDER_DATE' => $resultOrder['DATE_INSERT']
			);

			$orderDataCount = Order::getList(array(
				'select' => array('COUNT_ORDER'),
				'filter' => array(
					'=USER_ID' => $userId,
					'=CURRENCY' => $currency,
					'=LID' => $lid,
					'PAYED' => 'Y'
				),
				'runtime' => array(
					new ExpressionField('COUNT_ORDER', 'COUNT(1)')
				),
			));
			$countData = $orderDataCount->fetch();
			$statistic['COUNT_FULL_PAID_ORDER'] = ($countData['COUNT_ORDER'] === "0") ? NULL : $countData['COUNT_ORDER'];

			$paymentDataCount = Payment::getList(array(
				'select' => array('SUM_PAID', 'ORDER.USER_ID', 'COUNT_ORDER'),
				'filter' => array(
					'=ORDER.USER_ID' => $userId,
					'=ORDER.LID' => $lid,
					'=ORDER.CURRENCY' => $currency,
					'PAID' => 'Y'
				),
				'group' => array('ORDER.USER_ID'),
				'runtime' => array(
					new ExpressionField('SUM_PAID', 'SUM(SUM)'),
					new ExpressionField('COUNT_ORDER', 'COUNT(DISTINCT ORDER_ID)'),
				),
			));

			$countData = $paymentDataCount->fetch();
			$statistic['SUM_PAID'] = !empty($countData['SUM_PAID']) ? $countData['SUM_PAID'] : "0.0000";
			$statistic['COUNT_PART_PAID_ORDER'] = $countData['COUNT_ORDER'];

			$result->setData($statistic);
		}
		else
		{
			$result->addWarning(new Main\Error('User doesn\'t have orders' ));
		}

		return $result;
	}
}