<?
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

define('host', 'localhost');
define('user', 'root');
define('password', '123');
define('db', 'ads');

$conn = mysqli_connect(host, user, password, db) or die("Ошибка соединения");
mysqli_set_charset($conn, "utf8");

function option($db, $name){
    global $conn;
    $sql = "SELECT * FROM {$db}";
    $result = mysqli_query($conn, $sql);
    $string_name = '';
    while($show = mysqli_fetch_assoc($result)){
        $string_name .= ','.$show[$name.'_name'];
    }
    $array = explode(',', $string_name);
    $array = array_filter(
        $array, function($no_space){ return !empty($no_space);}
    );
    return $array;
}

function clear($var){
	$var = trim($var);
	$var = htmlentities($var);
	return $var;
}

function showAd(){
    global $conn;
    echo '<h1>Объявления</h1>';
    $sql = "select ad_id, email, ad_title from ad";
    $result = mysqli_query($conn, $sql);
    while($show = mysqli_fetch_assoc($result)){
        echo '<a href="HW9.php?id='.$show['ad_id'].'">'.$show['ad_title'] .'</a>' . ' | '. $show['email'] . ' |  <a href="HW9.php?delete='.$show['ad_id'].'">Удалить</a><br>';
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
    $type = $_POST['type'];
    $name = clear($_POST['name']);
    $email = clear($_POST['email']);
    if(isset($_POST['otvet'])){
        $otvet = $_POST['otvet'];
    } else {
         $otvet = 'off';
    }
    $phone = (int)$_POST['phone'];
    $id_city = $_POST['city'];
    $id_category = $_POST['category'];
    $ad_title = clear($_POST['ad_title']);
    $ad_description = clear($_POST['ad_description']);
    $price = $_POST['price'];

    $sql = "INSERT INTO ad"
            . " (type, user_name, email, otvet, phone, ad_title, ad_description, id_city, id_category, price)"
            . " VALUES('$type', '$name', '$email', '$otvet', '$phone', '$ad_title', '$ad_description', $id_city, $id_category, $price)";
    mysqli_query($conn, $sql) or die ('Ошибка в запросе' . mysql_error($conn));
    header("Location: hw9.php");
} elseif(isset($_GET['delete'])){
    $sql = "DELETE FROM ad WHERE ad_id={$_GET['delete']}";
    mysqli_query($conn, $sql) or die ('Удаление не удалось' . mysql_error($conn));
    header("Location: HW9.php");
} elseif(isset($_GET['id'])){
    $sql = "select ad_id, type, user_name, email, otvet, phone, ad_title, ad_description, price, cities.city_name, cities.id_city, categories.category_name, categories.id_category, types.id_type from ad
                left join cities on ad.id_city=cities.id_city
                left join categories on ad.id_category=categories.id_category
                left join types on ad.id_type=types.id_type
                where ad_id = {$_GET['id']}";
    $result = mysqli_query($conn, $sql) or die ('Не могу показать' . mysql_error($conn));
    while($show_ads = mysqli_fetch_assoc($result)){
        $type = $show_ads['type'];
        $smarty->assign('type', $type);
        $user_name = clear($show_ads['user_name']);
        $smarty->assign('user_name', $user_name);
        $email = clear($show_ads['email']);
        $smarty->assign('email', $email);
        $otvet = $show_ads['otvet'];
        $smarty->assign('otvet', $otvet);
        $phone = clear($show_ads['phone']);
        $smarty->assign('phone', $phone);
        $id_city = $show_ads['id_city'];
        $smarty->assign('id_city', $id_city);
        $id_category = $show_ads['id_category'];
        $smarty->assign('id_category', $id_category);
        $ad_title = clear($show_ads['ad_title']);
        $smarty->assign('ad_title', $ad_title);
        $ad_description = clear($show_ads['ad_description']);
        $smarty->assign('ad_description', $ad_description);
        $price = $show_ads['price'];
        $smarty->assign('price', $price);
    }
}
$smarty->display('HW9.tpl');