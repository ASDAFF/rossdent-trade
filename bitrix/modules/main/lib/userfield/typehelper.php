<?php
namespace Bitrix\Main\UserField;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\HtmlFilter;

class TypeHelper
{
	protected $userTypeId;

	public function __construct($userTypeId)
	{
		$this->userTypeId = $userTypeId;
	}

	public function getCssClassName()
	{
		return 'fields '.$this->userTypeId;
	}

	public function wrapSingleField($html)
	{
		return '<span class="'.HtmlFilter::encode(static::getCssClassName()).'">'.$html.'</span>';
	}

	public function wrapDisplayResult($html)
	{
		return static::wrapSingleField($html);
	}

	public function getMultipleValuesSeparator()
	{
		return '<span class="fields separator"></span>';
	}

	public function getCloneButton($fieldName)
	{
		return '<input type="button" value="'.HtmlFilter::encode(Loc::getMessage('USER_TYPE_PROP_ADD')).'" onclick="BX.Main.UF.Factory.get(\''.$this->userTypeId.'\').addRow(\''.\CUtil::jsEscape($fieldName).'\', this);" />';
	}
}