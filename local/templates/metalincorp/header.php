<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if($GET["debug"] == "y"){
    error_reporting(E_ERROR | E_PARSE);
}
IncludeTemplateLangFile(__FILE__);
global $APPLICATION, $TEMPLATE_OPTIONS, $arSite;
$arSite = CSite::GetByID(SITE_ID)->Fetch();
$htmlClass = ($_REQUEST && isset($_REQUEST['print']) ? 'print' : false);
?>
<!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>" xmlns="http://www.w3.org/1999/xhtml" <?=($htmlClass ? 'class="'.$htmlClass.'"' : '')?>>
<head>
    <?CUtil::InitJSCore();?>

    <title><?$APPLICATION->ShowTitle()?></title>
    <?$APPLICATION->ShowMeta("viewport");?>
    <?$APPLICATION->ShowMeta("HandheldFriendly");?>
    <?$APPLICATION->ShowMeta("apple-mobile-web-app-capable", "yes");?>
    <?$APPLICATION->ShowMeta("apple-mobile-web-app-status-bar-style");?>
    <?$APPLICATION->ShowMeta("SKYPE_TOOLBAR");?>

    <!--    ===================META===================  -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--    ===================META===================  -->

    <!--    ===================SCRIPT===================  -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="https://use.fontawesome.com/917921e280.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toggles/2.0.4/toggles.js"></script>
    <?$APPLICATION->AddHeadScript('/local/templates/metalincorp/js/jquery.flexslider.min.js');?>
    <?$APPLICATION->AddHeadScript('/local/templates/metalincorp/js/owl.carousel.js');?>
    <?$APPLICATION->AddHeadScript('/local/templates/metalincorp/js/script.js');?>
    <!--    ===================SCRIPT===================  -->

    <!--    ===================LINK===================  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?$APPLICATION->SetAdditionalCSS("/local/templates/metalincorp/css/flexslider.css");?>
    <?$APPLICATION->SetAdditionalCSS("/local/templates/metalincorp/css/styles.css");?>
    <?$APPLICATION->SetAdditionalCSS("/local/templates/metalincorp/css/template-styles.css");?>
    <?$APPLICATION->SetAdditionalCSS("/local/templates/metalincorp/css/template_styles.css");?>
    <?$APPLICATION->SetAdditionalCSS("/local/templates/metalincorp/css/owl.carousel.css");?>
    <?$APPLICATION->SetAdditionalCSS("/local/templates/metalincorp/css/owl.theme.default.css");?>
    <link href='<?=CMain::IsHTTPS() ? 'https' : 'http'?>://fonts.googleapis.com/css?family=Ubuntu:400,500,700,400italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <!--    ===================LINK===================  -->

    <?$APPLICATION->ShowHead();?>
    <?$APPLICATION->AddHeadString('<script>BX.message('.CUtil::PhpToJSObject( $MESS, false ).')</script>', true);?>
    <?if(CModule::IncludeModule("aspro.mshop")) {CMShop::Start(SITE_ID);}?>
</head>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<?if(!CModule::IncludeModule("aspro.mshop")){?><center><?$APPLICATION->IncludeFile(SITE_DIR."include/error_include_module.php");?></center></body></html><?die();?><?}?>
<?//CMShop::SetJSOptions();?>

<body id="body">
<div id="introduction" class="container-fluid" style="padding: 0">
    <div class="main">
    <div class="row no-gutters">
        <div class="left-block col-xl-3 col-md-3 d-xl-block d-lg-block ">
            <div class="hidden-menu">
                <div class="close-menu">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
                <div class="hidden-menu-section mt-5">
                    <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list","metalincorp_menu",
                        Array(
                            "VIEW_MODE" => "TEXT",
                            "SHOW_PARENT_NAME" => "Y",
                            "IBLOCK_TYPE" => "aspro_mshop_catalog",
                            "IBLOCK_ID" => "19",
                            "SECTION_ID" => $_REQUEST["SECTION_ID"],
                            "SECTION_CODE" => "",
                            "SECTION_URL" => "",
                            "COUNT_ELEMENTS" => "Y",
                            "TOP_DEPTH" => "1",
                            "SECTION_FIELDS" => "",
                            "SECTION_USER_FIELDS" => "",
                            "ADD_SECTIONS_CHAIN" => "Y",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_NOTES" => "",
                            "CACHE_GROUPS" => "N"
                        )
                    );?>
                </div>
            </div>
            <div class="visible-menu">
                <div class="select-city pt-3 pb-3 pl-5 lc-geo" style="cursor: pointer;">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>

                    <?
                    $getCityData = getUserCity();
                    $GLOBALS['getCityData'] = $getCityData;
                    echo $getCityData['CITY_NAME'];
                    //                                   $cityObj = new CCity();
                    //                                   $arThisCity = $cityObj ->GetFullInfo();
                    //                                   echo $arThisCity['CITY_NAME']['VALUE'];
                    ?>
<!--                    <i class="fa fa-angle-down" aria-hidden="true"></i>-->
                </div>
                <?if($getCityData['CITY_NAME_QUESTION']):?>
                    <div class="city_question">
                        <p>Это ваш город "<?=$getCityData['CITY_NAME_QUESTION']?>"?</p>
                        <div class="city_question__block_btn">
                            <a href="?CITY_ID=<?=$getCityData['CITY_ID_QUESTION']?>">Да</a>
                            <a class="lc-geo" style="color: #ffffff!important; cursor: pointer;font-size: 14px;">Выбрать другой</a>
                        </div>
                    </div>
                <?endif?>
                <div class="logo pt-4 pb-4 pl-5">
                    <a href="/"><img src="/images/logo-full.png" alt=""></a>
                </div>
                <div class="container pt-5" id="pushContainer">
                    <div class="row justify-content-center no-gutters">
                        <div class="header-catalog col-7">
                            <a href="#" onclick="return false;">Каталог продукции</a>
                        </div>
                    </div>
                </div>
                <?$page = $APPLICATION->GetCurDir();?>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="sub-menu pt-3 col-7">
                            <ul>
                                <li class="<?=$page == '/' ? 'active' : ''?>"><a href="/">О компании</a></li>
<!--                                <li class="--><?//=$page == '/news/' ? 'active' : ''?><!--"><a href="/news/">Новости</a></li>-->
                                <li class="<?=$page == '/delivery/' ? 'active' : ''?>"><a href="/delivery/">Оплата и доставка</a></li>
                                <li class="<?=$page == '/contacts/' ? 'active' : ''?>"><a href="/contacts/">Контакты</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="container pt-5" id="bottom-stick">
                    <div class="row justify-content-center">
                        <div class="contact-info col-xl-7 col-lg-12 col-md-12">
                            <ul>
                                <li><span>Для звонков из регионов</span><a href="#">8 800 301 26 34</a></li>
                                <li><span>Для связи в г.<?=$getCityData['CITY_NAME']?></span><a href="tel:<?=$getCityData['CITY_DATA']['PROPERTY_CN_PHONE_VALUE']?>"><?=$getCityData['CITY_DATA']['PROPERTY_CN_PHONE_VALUE']?></a></li>
                            </ul>
                            <span class="mail"><?=$getCityData['CITY_DATA']['PROPERTY_CN_EMAIL_VALUE']?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-block col-xl-9 col-lg-9 col-md-12" id="pushEffect">
            <div class="mobile-menu">
                <div class="row no-gutters  align-items-center pt-2 pl-3">
                    <div class="col-2">
                        <i class="fa fa-bars menu-bottom" aria-hidden="true"></i>
                    </div>
                    <div class="col-8 text-center">
                        <a href="/"><img src="/images/logo-full.png" alt=""></a>
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>
            <div class="mobile-menu-left-slide hide">
                <div class="select-city pt-3 pb-3 px-0 text-center lc-geo" style="cursor: pointer;">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>

                    <?
                    $getCityData = getUserCity();
                    $GLOBALS['getCityData'] = $getCityData;
                    echo $getCityData['CITY_NAME'];
                    //                                   $cityObj = new CCity();
                    //                                   $arThisCity = $cityObj ->GetFullInfo();
                    //                                   echo $arThisCity['CITY_NAME']['VALUE'];
                    ?>
                    <!--                    <i class="fa fa-angle-down" aria-hidden="true"></i>-->
                </div>
                <?if($getCityData['CITY_NAME_QUESTION']):?>
                    <div class="city_question p-3">
                        <p>Это ваш город "<?=$getCityData['CITY_NAME_QUESTION']?>"?</p>
                        <div class="city_question__block_btn">
                            <a href="?CITY_ID=<?=$getCityData['CITY_ID_QUESTION']?>">Да</a>
                            <a class="lc-geo" style="color: #ffffff!important; cursor: pointer;font-size: 14px;">Выбрать другой</a>
                        </div>
                    </div>
                <?endif?>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="sub-menu pt-3">
                            <ul>
                                <li class=""><a href="/">О компании</a></li>
                                <li class=""><a href="/catalog/">Каталог</a></li>
                                <li class=""><a href="/news/">Новости</a></li>
                                <li class=""><a href="/delivery/">Оплата и доставка</a></li>
                                <li class=""><a href="/contacts/">Контакты</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container pt-5" id="bottom-stick">
                    <div class="row justify-content-center">
                        <div class="contact-info">
                            <ul>
                                <li><span>Для звонков из регионов</span><a href="#">8 800 301 26 43</a></li>
                                <li><span>Для связи в Нижний Новгород</span><a href="tel:8-800-301-26-43">8-800-301-26-43</a></li>
                            </ul>
                            <span class="mail">info@stroymat-incorp.ru</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-wrap">
                <div class="top-bar">
                    <div class="row no-gutters">
                        <div class="search-block pl-5 pt-3 pb-3 col-xl-9 col-lg-9 col-md-8">
                            <?$APPLICATION->IncludeComponent("bitrix:search.form","new-top-search",Array(
                                    "USE_SUGGEST" => "N",
                                    "PAGE" => "#SITE_DIR#search/index.php"
                                )
                            );?>
                        </div>
                        <div class="basket pt-2 pb-1 col-xl-3 col-lg-3 col-md-4 col-sm-12">
                            <div class="header-cart" id="basket_line">
    <!--                            --><?//Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("header-cart");?>
    <!--                                --><?//$APPLICATION->IncludeFile(SITE_DIR."include/basket_top.php", Array(), Array("MODE" => "html", "NAME" => GetMessage("BASKET_TOP")));?>
    <!--                            --><?//Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("header-cart", "");?>
                                <?$mini_cart = getMiniCart();?>
                                <a href="/basket/">
                                    <span class="cart-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="basket_count"><?=$mini_cart['count']?></span></span> <span class="basket_title">Ваша корзина</span> <span class="basket_price"><?=$mini_cart['price']?> руб.</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="pl-5 pt-2 pb-2 col-12">
                            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb","",Array(
                                    "START_FROM" => "0",
                                    "PATH" => "",
                                    "SITE_ID" => "s1"
                                )
                            );?>
                        </div>
                    </div>
                </div>
<!--            <div class="breadcrumbs-metalincorp" id="navigation">-->
<!--                --><?//$APPLICATION->IncludeComponent("bitrix:breadcrumb","mshop",Array(
//                        "START_FROM" => "1",
//                        "PATH" => "/catalog/",
//                        "SITE_ID" => "s2"
//                    )
//                );?>
<!--            </div>-->

