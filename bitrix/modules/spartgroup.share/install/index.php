<?
global $MESS;
$PathInstall = str_replace("\\", "/", __FILE__);
$PathInstall = substr($PathInstall, 0, strlen($PathInstall)-strlen("/index.php"));
IncludeModuleLangFile($PathInstall."/install.php");
include($PathInstall."/version.php");

if (class_exists("spartgroup_share")) return;

class spartgroup_share extends CModule
{
	var $MODULE_ID = "spartgroup.share";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $PARTNER_NAME;
	var $PARTNER_URI;
	public $MODULE_GROUP_RIGHTS = 'N';

	function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}

		$this->PARTNER_NAME = GetMessage("sp_share_partner_name");
		$this->PARTNER_URI = "http://www.sp-artgroup.ru";

		$this->MODULE_NAME = GetMessage("sp_share_module_name");
		$this->MODULE_DESCRIPTION = GetMessage("sp_share_module_description");

	}

	function DoInstall()
	{
		if ($GLOBALS["APPLICATION"]->GetGroupRight("main") >= "W")
		{
			$GLOBALS["APPLICATION"]->IncludeAdminFile(GetMessage("sp_share_install_title"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/spartgroup.share/install/step1.php");
		}
	}

	function DoUninstall()
	{
		if ($GLOBALS["APPLICATION"]->GetGroupRight("main") >= "W")
		{
			$GLOBALS["APPLICATION"]->IncludeAdminFile(GetMessage("sp_share_uninstall_title"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/spartgroup.share/install/unstep1.php");
		}
	}
}
?>