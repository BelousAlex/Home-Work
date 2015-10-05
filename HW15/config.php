<?php
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE); // error handling
ini_set('display_errors', 1);
ob_start();

$smarty_root = "../../smarty/";
$project_root = "../..";

require $smarty_root.'libs/Smarty.class.php';
require_once $project_root."/dbsimple/config.php";
require_once $project_root."/dbsimple/DbSimple/Generic.php";

$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir=$smarty_root.'/templates/';
$smarty->compile_dir=$smarty_root.'/templates_c/';

$db = DbSimple_Generic::connect('mysqli://root:123@127.0.0.1/ads'); //DNS
$db->setErrorHandler('databaseErrorHandler');
$db->query("SET NAMES UTF8");

function databaseErrorHandler($message, $info){
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>"; 
    print_r($info);
    echo "</pre>";
    exit();
}