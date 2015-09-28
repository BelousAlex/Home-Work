<?php
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE); // error handling
ini_set('display_errors', 1);
ob_start();

require '../smarty/libs/Smarty.class.php';
require_once "../dbsimple/config.php";
require_once "../dbsimple/DbSimple/Generic.php";
require_once "../functions.php";

$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir='../smarty/templates/';
$smarty->compile_dir='../smarty/templates_c/';

$db = DbSimple_Generic::connect('mysqli://root:123@127.0.0.1/ads'); //DNS
$db->setErrorHandler('databaseErrorHandler');
$db->query("SET NAMES UTF8");

$show = new AdsStore();
$city_array = $show->option('city', 'cities');
$category_array = $show->option('category', 'categories');
$type_array = $show->option('type', 'types');
$smarty->assign('city_array', $city_array);
$smarty->assign('category_array', $category_array);
$smarty->assign('type_array', $type_array);

class Ads{
    protected $ad_id;
    protected $id_type;
    protected $user_name;
    protected $email;
    protected $otvet = 'off';
    protected $phone;
    protected $id_city;
    protected $id_category;
    protected $ad_title;
    protected $ad_description;
    protected $price;
    protected $selected_ads;
    protected $fullType;
    
    public function __construct($ad) {
        if(!empty($ad)){
            if(isset($ad['ad_id'])){
                $this->ad_id=$ad['ad_id'];
            }
            $this->id_type=$ad['id_type'];
            $this->user_name=$ad['user_name'];
            $this->email=$ad['email'];
            if(isset($ad['otvet'])){
                $this->otvet=$ad['otvet'];
            }
            $this->phone=$ad['phone'];
            $this->id_city=$ad['id_city'];
            $this->id_category=$ad['id_category'];
            $this->ad_title=$ad['ad_title'];
            $this->ad_description=$ad['ad_description'];
            $this->price=$ad['price'];
        }
    }
    
    public function save(){
        global $db;
        $vars = get_object_vars($this);
        array_pop($vars);
        array_pop($vars);
        $db->query("REPLACE INTO ad(?#) VALUES(?a)", array_keys($vars), array_values($vars));
    }
    
    function delete(){
        global $db;
        $db->query("DELETE FROM ad WHERE ad_id=?d",$_GET['delete']);
        header("Location: HW12.php");
    }
    
    function fullAd(){
        global $db;
        $this->selected_ads = $db->selectRow("SELECT * FROM ad "
        . "LEFT JOIN cities on ad.id_city=cities.id_city "
        . "LEFT JOIN categories on ad.id_category=categories.id_category "
        . "LEFT JOIN types on ad.id_type=types.id_type "
        . "WHERE ad_id = ?d", $_GET['id']);
        return $this->selected_ads;
    }

    public function getId(){
        return $this->ad_id;
    }
    
    public function getType(){
        return $this->id_type;
    }
    
    public function getFullType(){
        global $db;
        $this->fullType = $db->selectCell("SELECT type_name FROM types WHERE id_type = $this->id_type");
        return $this->fullType;
    }    
    
    public function getUserName(){
        return $this->user_name;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function getOtvet(){
        return $this->otvet;
    }
    
    public function getPhone(){
        return $this->phone;
    }
    
    public function getCity(){
        return $this->id_city;
    }
    
    public function getCategory(){
        return $this->id_category;
    }
    
    public function getAdTitle(){
        return $this->ad_title;
    }
    
    public function getAdDesc(){
        return $this->ad_description;
    }
    
    public function getPrice(){
        return $this->price;
    }
}

class PrivatePersonAds extends Ads{
    function __construct($ad) {
        parent::__construct($ad);
        $this->id_type = 1;
    }
}

class CompanyAds extends Ads{
    function __construct($ad) {
        parent::__construct($ad);
        $this->id_type = 2;
    }
}

class AdsStore{
    private static $instance=NULL;
    private $ads=array();
    
    public static function instance(){
        if(self::$instance == NULL){
            self::$instance = new AdsStore();
        }
        return self::$instance;
    }
    
    public function addAds(Ads $ad){
        if(!($this instanceof AdsStore)){
            die('Нельзя распознать этот метод в конструкторе класса');
        }
        $this->ads[$ad->getId()] = $ad;
    }
    
    public function getAllAdsFromDb(){
        global $db;
        $all = $db->select("SELECT * FROM ad");
        foreach($all as $value){
            $ad = new Ads($value);
            self::addAds($ad); //помещаем объекты в хранилище
        }
    }
    
    public function writeOut(){
        global $smarty;
        $row='';
        foreach($this->ads as $value){
            $smarty->assign('ad', $value);
            $row .= $smarty->fetch('table_row.tpl.html');
        }
        $smarty->assign('ads_rows', $row);
    }
    
    public function option($name, $type){
        global $db;
        $res = $db->selectCol("SELECT id_{$name} AS ARRAY_KEY, {$name}_name FROM ".$type);
        return $res;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_GET['id'])){
    if($_POST['id_type'] == 1){
        $ad = new PrivatePersonAds($_POST);
        $ad->save();
    } else {
        $ad = new CompanyAds($_POST);
        $ad->save();
    }
} elseif(isset($_GET['delete'])){
    $ad = new Ads($_POST);
    $ad->delete();
} elseif($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change'])){
    $_POST['ad_id'] = $_GET['id'];
    $change = new Ads($_POST);
    $change->save();
    header("Location: HW12.php?id={$_GET['id']}");
} elseif(isset($_GET['id'])){
    $full = new Ads($_POST);
    $smarty->assign('selected_ads', $full->fullAd());
}

$main = AdsStore::instance();
$main->getAllAdsFromDb();
$main->writeOut();

$smarty->display('HW12.tpl');
