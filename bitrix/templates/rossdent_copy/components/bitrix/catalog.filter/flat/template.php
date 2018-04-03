<div class="bx-flat-filter cource-filter">
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
    <div class="bx-filter-section container-fluid">
        <div class="row">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?if(array_key_exists("HIDDEN", $arItem)):?>
                <?=$arItem["INPUT"]?>
            <?elseif ($arItem["TYPE"] == "RANGE"):?>
                <div class="col-sm-6 col-md-4 bx-filter-parameters-box ">
                    <div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
                    <div class="bx-filter-block">
                        <div class="row bx-filter-parameters-box-container">
                            <div class="col-xs-6 bx-filter-parameters-box-container-block  bx-left">
                                <div class="bx-filter-input-container">
                                    <input
                                        type="text"
                                        value="<?=$arItem["INPUT_VALUES"][0]?>"
                                        name="<?=$arItem["INPUT_NAMES"][0]?>"
                                        placeholder="<?=GetMessage("CT_BCF_FROM")?>"
                                    />
                                </div>
                            </div>
                            <div class="col-xs-6 bx-filter-parameters-box-container-block  bx-right">
                                <div class="bx-filter-input-container">
                                    <input
                                        type="text"
                                        value="<?=$arItem["INPUT_VALUES"][1]?>"
                                        name="<?=$arItem["INPUT_NAMES"][1]?>"
                                        placeholder="<?=GetMessage("CT_BCF_TO")?>"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?elseif ($arItem["TYPE"] == "DATE_RANGE"):?>
                <div class="col-sm-6 col-md-4 bx-filter-parameters-box ">
                    <div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
                    <div class="bx-filter-block">
                        <div class="row bx-filter-parameters-box-container">
                            <div class="col-xs-6 bx-filter-parameters-box-container-block  bx-left"><div class="bx-filter-input-container bx-filter-calendar-container">
                                    <?$APPLICATION->IncludeComponent(
                                        'bitrix:main.calendar',
                                        '',
                                        array(
                                            'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
                                            'SHOW_INPUT' => 'Y',
                                            'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'"',
                                            'INPUT_NAME' => $arItem["INPUT_NAMES"][0],
                                            'INPUT_VALUE' => $arItem["INPUT_VALUES"][0],
                                            'SHOW_TIME' => 'N',
                                            'HIDE_TIMEBAR' => 'Y',
                                        ),
                                        null,
                                        array('HIDE_ICONS' => 'Y')
                                    );?>
                            </div></div>
                            <div class="col-xs-6 bx-filter-parameters-box-container-block  bx-right"><div class="bx-filter-input-container bx-filter-calendar-container">
                                    <?$APPLICATION->IncludeComponent(
                                        'bitrix:main.calendar',
                                        '',
                                        array(
                                            'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
                                            'SHOW_INPUT' => 'Y',
                                            'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'"',
                                            'INPUT_NAME' => $arItem["INPUT_NAMES"][1],
                                            'INPUT_VALUE' => $arItem["INPUT_VALUES"][1],
                                            'SHOW_TIME' => 'N',
                                            'HIDE_TIMEBAR' => 'Y',
                                        ),
                                        null,
                                        array('HIDE_ICONS' => 'Y')
                                    );?>
                            </div></div>
                        </div>
                    </div>
                </div>
            <?elseif ($arItem["TYPE"] == "SELECT"):
                ?>
 <div class="col-sm-12 col-md-12 bx-filter-parameters-box ">
                    <div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
                    <a href="#" class="switch-btn open"><i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <div class="bx-filter-block">
                        <div class="row bx-filter-parameters-box-container">
                            <div class="col-xs-12 bx-filter-parameters-box-container-block">
                                <?
                                $arListValue = (is_array($arItem["~INPUT_VALUE"]) ? $arItem["~INPUT_VALUE"] : array($arItem["~INPUT_VALUE"]));
                                foreach ($arItem["LIST"] as $key => $value):?>
                                <div class="radio">
                                    <label class="bx-filter-param-label">
                                        <input
                                            type="radio"
                                            value="<?=htmlspecialcharsBx($key)?>"
                                            name="<?echo $arItem["INPUT_NAME"]?>"
                                            onchange="$('#test').click()"
                                            <?if (in_array($key, $arListValue)) echo 'checked="checked"'?>
                                        >
                                        <label for="cyan" class="cyan"></label>
                                        <span class="bx-filter-param-text"><?=htmlspecialcharsEx($value)?></span>
                                    </label>
                                </div>
                                <?endforeach?>
                            </div>
                        </div>
                    </div>
                </div>
            <?elseif ($arItem["TYPE"] == "CHECKBOX"):
                ?>
                <div class="col-sm-6 col-md-4 bx-filter-parameters-box ">
                    <div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
                    <div class="bx-filter-block">
                        <div class="row bx-filter-parameters-box-container">
                            <div class="col-xs-12 bx-filter-parameters-box-container-block">
                            <?
                            $arListValue = (is_array($arItem["~INPUT_VALUE"]) ? $arItem["~INPUT_VALUE"] : array($arItem["~INPUT_VALUE"]));
                            foreach ($arItem["LIST"] as $key => $value):?>
                            <div class="checkbox">
                                <label class="bx-filter-param-label">
                                    <input
                                        type="checkbox"
                                        value="<?=htmlspecialcharsBx($key)?>"
                                        name="<?echo $arItem["INPUT_NAME"]?>[]"
                                        <?if (in_array($key, $arListValue)) echo 'checked="checked"'?>
                                    >
                                    <span class="bx-filter-param-text"><?=htmlspecialcharsEx($value)?></span>
                                </label>
                            </div>
                            <?endforeach?>
                            </div>
                        </div>
                    </div>
                </div>
            <?elseif ($arItem["TYPE"] == "RADIO"):
                ?>
                <div class="col-sm-12 col-md-12 bx-filter-parameters-box ">
                    <div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
                    <div class="bx-filter-block">
                        <div class="row bx-filter-parameters-box-container">
                            <div class="col-xs-12 bx-filter-parameters-box-container-block">
                                <?
                                $arListValue = (is_array($arItem["~INPUT_VALUE"]) ? $arItem["~INPUT_VALUE"] : array($arItem["~INPUT_VALUE"]));
                                foreach ($arItem["LIST"] as $key => $value):?>
                                <div class="radio">
                                    <label class="bx-filter-param-label">
                                        <input
                                            type="radio"
                                            value="<?=htmlspecialcharsBx($key)?>"
                                            name="<?echo $arItem["INPUT_NAME"]?>"
                                            <?if (in_array($key, $arListValue)) echo 'checked="checked"'?>
                                        >

                                        <span class="bx-filter-param-text"><?=htmlspecialcharsEx($value)?></span>
                                    </label>
                                </div>
                                <?endforeach?>
                            </div>
                        </div>
                    </div>
                </div>
            <?else:?>
                <div class="col-sm-6 col-md-4 bx-filter-parameters-box ">
                    <div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
                    <div class="bx-filter-block">
                        <div class="row bx-filter-parameters-box-container">
                            <div class="col-xs-12 bx-filter-parameters-box-container-block">
                                <div class="bx-filter-input-container">
                                    <?=$arItem["INPUT"]?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?endif?>
        <?endforeach;?>
        </div>
       <div class="row" >
            <div class="col-xs-12 bx-filter-button-box">
                <div class="bx-filter-block">
                    <div class="bx-filter-parameters-box-container">
                        <input type="submit" id="test" name="set_filter" value="<?=GetMessage("CT_BCF_SET_FILTER")?>" class="btn-green" />
                        <input type="hidden" name="set_filter" value="Y" />
                         <!-- <input type="submit" name="del_filter" value="<?=GetMessage("CT_BCF_DEL_FILTER")?>" class="btn-green-border" />  -->
                    </div>
                </div>
            </div>
        </div> 
        
        <div class="clb"></div>
    </div>
</form>
    <br><a href="http://trade.rossdent.ru/upload/iblock/4c4/Uchebnoe_raspisanie_Practic_Center_RossDent.pdf" class="download-schedule btn-green-border"  download title="Скачать расписание курсов на 2017-2018 год" style="    width: 225px;">Скачать все расписание</a>

</div>