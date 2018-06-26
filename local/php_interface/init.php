<?php
//require_once(dirname(dirname(dirname(__DIR__)))).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
require_once __DIR__.'/include/functions.php';
require_once __DIR__.'/include/events.php';
require_once __DIR__.'/include/agents.php';
//checkTheCity();

function getUserCity($dopSelect=array()){
    global $APPLICATION;
    $returnData = array();
    $returnData['CITY_NAME'] = "Не известно";
    $returnData['CHANGE_CITY_LIST'] = getSiteCity();
//    echo $_SESSION['CITY_NAME'];die();
    if($_REQUEST['CITY_ID']){
        if($_REQUEST['CITY_ID'] != "default") {
            $getCity = CCity::GetList(array(), array("CITY_ID" => $_REQUEST['CITY_ID']));
            if ($city = $getCity->Fetch()) {
                $_SESSION['CITY_NAME'] = $city['CITY_NAME'];
                $APPLICATION->set_cookie("CITY_NAME_CITY", $city['CITY_NAME'], time() + 60 * 60 * 24 * 30 * 12 * 2, false, false, false, true);
                $session_city = $city['CITY_NAME'];
            }
        }else {
            $APPLICATION->set_cookie("CITY_NAME_CITY", "Другой город", time() + 60 * 60 * 24 * 30 * 12 * 2, false, false, false, true);
            $session_city = "Другой город";
        }
    }else {
        $session_city = $APPLICATION->get_cookie("CITY_NAME_CITY");
    }
    
    if(empty($session_city)){
        $cityObj = new CCity();
        $arThisCity = $cityObj ->GetFullInfo();
        $getCity = CCity::GetList(array(), array("CITY_NAME" => $arThisCity['CITY_NAME']['VALUE']));
        if($city = $getCity->Fetch()){
            $returnData['CITY_NAME_QUESTION'] = $city['CITY_NAME'];
            $returnData['CITY_ID_QUESTION'] = $city['CITY_ID'];
            $returnData['CITY_NAME'] = $city['CITY_NAME'];
        }
    }else{
        $returnData['CITY_NAME'] = $session_city;
    }

    if($returnData['CITY_NAME']) {
        $selectList = array("ID", "NAME", "PROPERTY_CN_PHONE", "PROPERTY_CN_EMAIL", "PROPERTY_CN_ADDRESS", "PROPERTY_CN_MAP",
            "PROPERTY_CN_DOMEN", "PROPERTY_CN_PROPERTY", "PROPERTY_CN_IN_CITY", "PROPERTY_LATITUDE", "PROPERTY_LONGITUDE");
        $selectList = array_merge($dopSelect, $selectList);
        $getCity = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 16,
            "NAME" => trim($returnData['CITY_NAME'])), false, false, $selectList);
        if($city = $getCity->Fetch()){
//            echo $_SERVER['HTTP_HOST']."<br>";
//            echo $city['PROPERTY_CN_DOMEN_VALUE']."<br>";
            $returnData['CITY_DATA'] = $city;
            if($_SERVER['HTTP_HOST'] != $city['PROPERTY_CN_DOMEN_VALUE']){
                $uriParams = explode("?", $_SERVER['REQUEST_URI']);
                LocalRedirect("http://".$city['PROPERTY_CN_DOMEN_VALUE'].$uriParams[0]);
                die();
            }
        }else{
            $getCity = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 16,
                "NAME" => "DEFAULT"), false, false, $selectList);
            if($city = $getCity->Fetch()){
                $returnData['CITY_DATA'] = $city;
                if($_SERVER['HTTP_HOST'] != $city['PROPERTY_CN_DOMEN_VALUE']){
                    $uriParams = explode("?", $_SERVER['REQUEST_URI']);
                    LocalRedirect("http://".$city['PROPERTY_CN_DOMEN_VALUE'].$uriParams[0]);
                    die();
                }
            }
        }
    }

    return $returnData;
}

function getSiteCity(){
    $city_list = array();
    $selectList = array("NAME", "PROPERTY_CN_DOMEN");
    $getCity = CIBlockElement::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => 16), false, false, $selectList);
    while ($city = $getCity->Fetch()){
        $city_item = array();
        $uriParams = explode("?", $_SERVER['REQUEST_URI']);
        if($city['NAME'] != "DEFAULT") {
            $getCityByName = CCity::GetList(array(), array("CITY_NAME" => $city['NAME']));
            if ($cityByName = $getCityByName->Fetch()) {
                $city_item = array("url" => "http://" . $city['PROPERTY_CN_DOMEN_VALUE'] . $uriParams[0] . "?CITY_ID=" . $cityByName['CITY_ID'], "TITLE" => $city['NAME']);
                $city_list[] = $city_item;
            }
        }else{
            $city_list[] = array("url" => "http://" . $city['PROPERTY_CN_DOMEN_VALUE'] . $uriParams[0] . "?CITY_ID=default", "TITLE" => "Другой город");
        }
    }
    return $city_list;
}
