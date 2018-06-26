<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

IncludeTemplateLangFile(__FILE__);
global $APPLICATION, $arSite;

$arSite = CSite::GetByID(SITE_ID)->Fetch();
$getCityData = getUserCity();
$GLOBALS['getCityData'] = $getCityData;
echo $getCityData['CITY_NAME'];

$cityObj = new CCity();
$arThisCity = $cityObj ->GetFullInfo();
echo $arThisCity['CITY_NAME']['VALUE'];
?>