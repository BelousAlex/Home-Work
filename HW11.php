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

class DB{
    public $host;
    public $user;
    public $bd_name;
    public $pass;
    
    function __construct($host, $user, $bd_name, $pass) {
        $this->host = $host;
        $this->user = $user;
        $this->bd_name = $bd_name;
        $this->pass = $pass;
    }
            
    function BDConnect(){
        $db = DbSimple_Generic::connect("mysqli://{$this->user}:{$this->pass}@{$this->host}/{$this->bd_name}");
        $db->query("SET NAMES utf8");
        $db->setErrorHandler('databaseErrorHandler');
        $db->setLogger('myLogger');
        return $db;
    }
}

class ShowOption{
    function option($db, $name, $type){    
        $res = $db->selectCol("SELECT id_{$name} AS ARRAY_KEY, {$name}_name FROM ".$type);
        return $res;
    } 
}

class workWithAd{
    public $output;
    public $row;
    public $selected_ads;
    
    /*Вывод списка объявлений из БД*/
    function showAd($db){
        $this->output .= '<h1>Объявления</h1>';
        $show_all_ads = $db->select("SELECT ad_id, email, ad_title FROM ad");
        if(!empty($show_all_ads)){
            foreach($show_all_ads as $show_ad){
                $this->output .= '<a href="HW11.php?id='.$show_ad['ad_id'].'">'.$show_ad['ad_title'] .'</a>' . ' | '. $show_ad['email'] . ' | <a href="HW11.php?delete='.$show_ad['ad_id'].'">Удалить</a><br>';
            }
        } else {
            $this->output .= "Объявлений нет";
        }
        return $this->output;
    }
    /*Чистка принимаемых от пользователя данных*/
    function clear($var){
        $var = htmlentities(trim($var));
        return $var;
    }
    /*Удаление объявления*/
    function delete($db){
        $db->query("DELETE FROM ad WHERE ad_id=?d",$_GET['delete']);
    }
    /*Добавление объявления*/
    function addedAd($db, $POST){
        $POST['user_name'] = $this->clear($POST['user_name']);
        $POST['phone'] = $this->clear($POST['phone']);
        $POST['ad_title'] = $this->clear($POST['ad_title']);
        $POST['ad_description'] = $this->clear($POST['ad_description']);
        $this->row = $POST;
        $db->query('INSERT INTO ad(?#) VALUES(?a)', array_keys($this->row), array_values($this->row));
    }
    /*Полная информаця о выбранном объявлении*/
    function fullAd($db){
        $this->selected_ads = $db->selectRow("SELECT * FROM ad "
        . "LEFT JOIN cities on ad.id_city=cities.id_city "
        . "LEFT JOIN categories on ad.id_category=categories.id_category "
        . "LEFT JOIN types on ad.id_type=types.id_type "
        . "WHERE ad_id = ?d", $_GET['id']);
        return $this->selected_ads;
    }
    /*Редактирование данных в выбранном объявлениии*/
    function changeAd($db){
        return $db->query("UPDATE ad SET user_name = ?,"
        . " id_type = ?d,"
        . " email = ?,"
        . " otvet = ?,"
        . " phone = ?,"
        . " id_city= ?d,"
        . " id_category= ?d,"
        . " ad_title= ?,"
        . " ad_description= ?,"
        . " price= ?d"
        . " WHERE ad_id = ?d", $this->clear($_POST['user_name']), $_POST['id_type'], $this->clear($_POST['email']), $_POST['otvet'], $this->clear($_POST['phone']), $_POST['id_city'], $_POST['id_category'], $this->clear($_POST['ad_title']), $this->clear($_POST['ad_description']), $_POST['price'], $_GET['id']);
    }
}

/*подключение к БД*/
$db = new DB('localhost', 'root', 'ads', '123');
$connect = $db->BDConnect();
/*вывод списков: Города, Категории, Типы*/
$show = new ShowOption();
$city_array = $show->option($connect, 'city', 'cities');
$category_array = $show->option($connect, 'category', 'categories');
$type_array = $show->option($connect, 'type', 'types');
$smarty->assign('city_array', $city_array);
$smarty->assign('category_array', $category_array);
$smarty->assign('type_array', $type_array);
/*Вывод всех объявлений*/
$ads = new workWithAd();
$showAds = $ads->showAd($connect);
$smarty->assign('showAds', $showAds);

if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_GET['id'])){
    $added = new workWithAd();
    $added->addedAd($connect, $_POST);
    header("Location: hw11.php");
} elseif(isset($_GET['delete'])){
    $delete = new workWithAd;
    $delete->delete($connect);
    header("Location: HW11.php");
} elseif(isset($_GET['id'])){
    $full = new workWithAd();
    $smarty->assign('selected_ads', $full->fullAd($connect));
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change'])){
        $changeAd = new workWithAd();
        $changeAd->changeAd($connect);
        header("Location: HW11.php?id={$_GET['id']}");
    }
}

$smarty->display('HW11.tpl');