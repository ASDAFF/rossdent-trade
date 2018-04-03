<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"SERVICES" => array(
			"PARENT"  => "BASE",
			"NAME"    => GetMessage("SP_SERV_BOX"),
			"TYPE"    => "LIST",
			"ADDITIONAL_VALUES" => "N",
			"MULTIPLE" => "Y",
			"SIZE" => 10,
			"VALUES"  => array(
				"vkontakte" => GetMessage("SP_SERV_BOX_VK"),
				"facebook" => GetMessage("SP_SERV_BOX_FACE"),
				"twitter" => GetMessage("SP_SERV_BOX_TW"),
				"odnoklassniki" => GetMessage("SP_SERV_BOX_OD"),
				"moimir" => GetMessage("SP_SERV_BOX_MM"),
				"gplus" => GetMessage("SP_SERV_BOX_GO"),
				"lj" => GetMessage("SP_SERV_BOX_LJ"),
				"friendfeed" => GetMessage("SP_SERV_BOX_FR"),
				"moikrug" => GetMessage("SP_SERV_BOX_MK"),
				"surfingbird" => GetMessage("SP_SERV_BOX_SG")
				),
			"COLS" => 10, 
			"REFRESH" => "N",
		),
		"SHOW" => array(
			"PARENT"  => "BASE",
			"NAME"    => GetMessage("SP_SHOW_BOX"),
			"TYPE"    => "LIST",
			"ADDITIONAL_VALUES" => "N",
			"MULTIPLE" => "N",
			"SIZE" => 5,
			"VALUES"  => array(
				"small" => GetMessage("SP_SHOW_BOX_COUNTERS"),
				"button" => GetMessage("SP_SHOW_BOX_BUTTON"),
				"link" => GetMessage("SP_SHOW_BOX_LINK"),
				"icon" => GetMessage("SP_SHOW_BOX_ICON"),
				"none" => GetMessage("SP_SHOW_BOX_NONE")
				),
			"COLS" => 5, 
			"DEFAULT" => 'button',
			"REFRESH" => "N",
			),
		"HOW_INC" =>array(
			"PARENT"  => "BASE",
			"NAME"    => GetMessage("SP_HOW_INC"),
			"TYPE"    => "LIST",
			"SIZE" => 2,
			"COLS" => 2,
			"VALUES"  => array(
				"local" => GetMessage("SP_SHOW_BOX_INC_LOCAL"),
				"remotaly" => GetMessage("SP_SHOW_BOX_INC_REMOTALY"),
				),
			"DEFAULT" => "local",
			),
		// "CACHE_TIME" => array(),
	)
);?>
