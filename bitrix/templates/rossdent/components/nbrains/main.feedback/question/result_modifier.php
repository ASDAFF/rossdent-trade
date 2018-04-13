<?php

foreach($arResult['USER_FIELD'] as &$field){
    if($field['CODE'] == "REGION"){
        $arResult['REGION_AR'] = explode(';',$field['DEFAULT_VALUE']);
    }
}
