<?php
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE); // error handling
ini_set('display_errors', 1);

require_once "../dbsimple/config.php";
require_once "../dbsimple/DbSimple/Generic.php";
require_once ('../FirePHPCore/lib/FirePHPCore/FirePHP.class.php');

$firePHP = FirePHP::getInstance(true);
$firePHP ->setEnabled(true);

require('../smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->compile_check = true;
//$smarty->debugging = true;

$smarty->template_dir = '../smarty/templates';
$smarty->compile_dir = '../smarty/templates_c';
$smarty->cache_dir = '../smarty/cache';
$smarty->config_dir = '../smarty/configs';

// Подключаемся к БД.
$db = DbSimple_Generic::connect('mysqli://root:123@127.0.0.1/ads'); //DNS

$db->setErrorHandler('databaseErrorHandler');
$db->setLogger('myLogger');

function databaseErrorHandler($message, $info){
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>"; 
    print_r($info);
    echo "</pre>";
    exit();
}

function myLogger($db, $sql, $caller)
{
    global $firePHP;
    if(isset($caller['file'])){
        $firePHP->group("at ".@$caller['file'].' line '.@$caller['line']);
    }
    $firePHP->log($sql);
    if(isset($caller['file'])){
        $firePHP->groupEnd();
    }
}

function option($table, $name){
    global $db;
    $res = $db->selectCol("SELECT id_{$name} AS ARRAY_KEY, {$name}_name FROM ".$table);
    return $res;
}

function clear($var){
    $var = htmlentities(trim($var));
    return $var;
}

function showAd(){
    global $db;
    echo '<h1>Объявления</h1>';
    $show_all_ads = $db->select("SELECT ad_id, email, ad_title FROM ad");
    if(!empty($show_all_ads)){
        foreach($show_all_ads as $show_ad){
            echo '<a href="HW10.php?id='.$show_ad['ad_id'].'">'.$show_ad['ad_title'] .'</a>' . ' | '. $show_ad['email'] . ' |  <a href="HW10.php?delete='.$show_ad['ad_id'].'">Удалить</a><br>';
        }
    } else {
        echo "Объявлений нет";
    }
}

$city_array = option('cities', 'city');
$category_array = option('categories', 'category');
$type_array = option('types', 'type');
$smarty->assign('city_array', $city_array);
$smarty->assign('category_array', $category_array);
$smarty->assign('type_array', $type_array);
$smarty->register_function('showAd', 'showAd');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $_POST['user_name'] = clear($_POST['user_name']);
    $_POST['phone'] = clear($_POST['phone']);
    $_POST['ad_title'] = clear($_POST['ad_title']);
    $_POST['ad_description'] = clear($_POST['ad_description']);
    $row = $_POST;
    $db->query('INSERT INTO ad(?#) VALUES(?a)', array_keys($row), array_values($row));
    header("Location: hw10.php");
} elseif(isset($_GET['delete'])){
    $db->query("DELETE FROM ad WHERE ad_id=?d",$_GET['delete']);
    header("Location: HW10.php");
} elseif(isset($_GET['id'])){
    $selected_ads = $db->selectRow("SELECT * FROM ad "
        . "LEFT JOIN cities on ad.id_city=cities.id_city "
        . "LEFT JOIN categories on ad.id_category=categories.id_category "
        . "LEFT JOIN types on ad.id_type=types.id_type "
        . "WHERE ad_id = ?d", $_GET['id']);
    $smarty->assign('selected_ads', $selected_ads);
}
$smarty->display('HW10.tpl');