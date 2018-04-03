<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage sale
 * @copyright 2001-2016 Bitrix
 */
namespace Bitrix\Sale\Internals;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;

class BuyerStatisticTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_sale_buyer_stat';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			new Main\Entity\IntegerField(
				'ID',
				array(
					'autocomplete' => true,
					'primary' => true,
				)
			),

			new Main\Entity\StringField(
				'LID',
				array(
					'required' => true,
				)
			),

			new Main\Entity\StringField(
				'CURRENCY',
				array(
					'required' => true,
					'size' => 3
				)
			),

			new Main\Entity\StringField(
				'USER_ID',
				array(
					'required' => true,
				)
			),

			new Main\Entity\ReferenceField(
				'USER',
				'\Bitrix\Main\User',
				array('=this.USER_ID' => 'ref.ID'),
				array('join_type' => 'INNER')
			),

			new Main\Entity\DatetimeField('LAST_ORDER_DATE'),

			new Main\Entity\FloatField(
				'SUM_PAID',
				array(
					'default_value' => '0.0000'
				)
			),

			new Main\Entity\IntegerField('COUNT_FULL_PAID_ORDER'),
			
			new Main\Entity\IntegerField('COUNT_PART_PAID_ORDER'),

			new Main\Entity\ReferenceField(
				'GROUP',
				'\Bitrix\Main\UserGroup',
				array('=this.USER_ID' => 'ref.USER_ID'),
				array('join_type' => 'INNER')
			),
		);
	}
}