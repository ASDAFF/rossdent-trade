<?php
if (\Bitrix\Main\ModuleManager::isModuleInstalled('catalog'))
{
	$updater->CopyFiles("install/components", "components");
}