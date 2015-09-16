<?php

error_reporting(E_ALL|E_ERROR|E_WARNING|E_PARSE|E_NOTICE); // error handling
ini_set('display_errors', 1);

require('../smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->compile_check = true;
//$smarty->debugging = true;

$smarty->template_dir = '../smarty/templates';
$smarty->compile_dir = '../smarty/templates_c';
$smarty->cache_dir = '../smarty/cache';
$smarty->config_dir = '../smarty/configs';

define ('ads', 'ads_HW8.txt');

$cities = array('-- Выберите город --', 'Донецк', 'Луганск', 'Харьков', 'Днепропетровск', 'Киев');
$categories = array('-- Выберите Категорию --', 'Работа', 'Услуги', 'Хобби', 'Недвижимость', 'Транспорт');
$radio_array = array('Частное лицо', 'Компания');

/*Отправка массивов для корректной работы полей Город, Категория, Переключатель*/
$smarty->assign('cities', $cities);
$smarty->assign('categories', $categories);
$smarty->assign('radio_array', $radio_array);

function cleaning($variable){
    $var = htmlentities(trim($variable));
    return $var;
}

function unSer($file_name, $key){
    $remaining_ads = '';
    $current_ads = file_get_contents($file_name);
    $current_ads = explode("\n", $current_ads);
    foreach ($current_ads as $current_ad){
        $current_ad = unserialize($current_ad);
        if(isset($current_ad[$key])){
            unset($current_ad[$key]);
         } elseif(!empty($current_ad)){
             $current_ad = serialize($current_ad);
             $remaining_ads .= $current_ad."\n";
         } 
    }
    file_put_contents(ads, $remaining_ads);
    header("Location: HW8.php");
}

function showAd(){
    echo '<h1>Объявления</h1>';
    if(file_exists(ads) && filesize(ads) != 0){
        $array_ads = file(ads);
        foreach ($array_ads as $array){
            $ad = unserialize($array);
            foreach ($ad as $key=> $ad_val){
               $ad = explode(' / ', $ad_val);
            echo '<a href="HW8.php?id='.$key.'">'.$ad[7] .'</a>' . ' | '. $ad[2] . ' |  <a href="HW8.php?delete='.$key.'">Удалить</a><br>';
            }
        }
    } else {
        echo 'Объявлений нет';
    }
}

/*регистрирую функцию showAd, для рабты в Smarty*/
$smarty->register_function('showAd', 'showAd'); 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $type = $_POST['type'];
    $name = cleaning($_POST['name']);
    $email = cleaning($_POST['email']);
    if(isset($_POST['otvet']) && $_POST['otvet'] != ''){
        $otvet = $_POST['otvet'];
    } else {
        $otvet = 'off';
    }
    $phone = $_POST['phone'];
    $city = cleaning($_POST['city']);
    $category = cleaning($_POST['category']);
    $ad_title = cleaning($_POST['ad_title']);
    $ad_description = cleaning($_POST['ad_description']);
    $price = $_POST['price'];
    $str[uniqid()] = $type . ' / ' . $name . ' / ' . $email . ' / ' . $otvet . ' / ' . $phone . ' / ' . $city . ' / ' . $category . ' / ' . $ad_title . ' / ' . $ad_description . ' / ' . $price;
    $str = serialize($str);
    file_put_contents(ads, $str . "\n", FILE_APPEND);
} elseif(isset($_GET['delete'])){
    unSer(ads, $_GET['delete']);
}
elseif(isset($_GET['id'])){
    $arr = file_get_contents(ads);
    $arr = explode("\n", $arr);
    foreach ($arr as $aa){
        $aa = unserialize($aa);
        if(isset($aa[$_GET['id']])){
            $bb = explode(' / ', $aa[$_GET['id']]);
            $name = cleaning($bb[1]);
            $smarty->assign('name', $name);
            $email = cleaning($bb[2]);
            $smarty->assign('email', $email);
            $phone = $bb[4];
            $smarty->assign('phone', $phone);
            $ad_title = cleaning($bb[7]);
            $smarty->assign('ad_title', $ad_title);
            $ad_description = cleaning($bb[8]);
            $smarty->assign('ad_description', $ad_description);
            $price = $bb[9];
            $smarty->assign('price', $price);
            $type = cleaning($bb[0]);
            $smarty->assign('type', $type);
            $category = cleaning($bb[6]);
            $smarty->assign('category', $category);
                $otvet = cleaning($bb[3]);
                $smarty->assign('otvet', $otvet);
            $city = cleaning($bb[5]);
            $smarty->assign('city', $city);
        }
    }
}
$smarty->display('HW8.tpl');