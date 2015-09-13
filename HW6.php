<?php
session_start();
$cities = array('Донецк', 'Луганск', 'Харьков', 'Днепропетровск', 'Киев');
$categories = array('Работа', 'Услуги', 'Хобби', 'Недвижимость', 'Транспорт');

function showAd(){
    global $_SESSION;
    echo '<h1>Объявления</h1>';
    if(!empty($_SESSION)){
        foreach ($_SESSION as $key => $ad){
            foreach ($ad as $a){
                echo '<a href="HW6.php?id=' . $key. '">' . $a['ad_title'].'</a> | '.$a['price'].' руб | '.$a['name'] . ' | <a href="HW6.php?delete=' . $key. '">Удалить</a><br>';
            }
        }
    } else {
        echo 'Объявлений нет';
    }
}

function selected($array, $name){
global $_SESSION;
$select = $_SESSION[$_GET['id']]['ad'][$name];
$output = '';
    foreach ($array as $val){
        $output .= '<option value="' . $val . '"';
        if($val==$select)
            $output .= ' selected="selected"';
        $output .= '>';
        $output .= $val; 
        $output .= '</option>';
    }
    echo $output;
}

function cleaning($variable){
    $var = htmlentities(trim($variable));
    return $var;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
    $_SESSION[uniqid()]['ad'] = $_POST;
} elseif (isset($_GET['delete'])){
    unset($_SESSION[$_GET['delete']]);
    header("Location: HW6.php");
} elseif(isset($_GET['id'])){
    $name = cleaning($_SESSION[$_GET['id']]['ad']['name']);
    $email = cleaning($_SESSION[$_GET['id']]['ad']['email']);
    $phone = (int)$_SESSION[$_GET['id']]['ad']['phone'];
    $ad_title = cleaning($_SESSION[$_GET['id']]['ad']['ad_title']);
    $ad_description = cleaning($_SESSION[$_GET['id']]['ad']['ad_description']);
    $price = (int)$_SESSION[$_GET['id']]['ad']['price']; ?>
    <form method="POST">
        <? if($_SESSION[$_GET['id']]['ad']['type'] == 'private_person'){?>
            <p><input type="radio" name="type" value="private_person" checked> Частное лицо
            <input type="radio" name="type" value="company"> Компания</p>
        <?  } else { ?>
            <p><input type="radio" name="type" value="private_person"> Частное лицо
            <input type="radio" name="type" value="company" checked> Компания</p>
        <? } ?>
            <p>Ваше имя <input type="text" name="name" value="<?= $name; ?>"/></p>
            <p>Электронная почта <input type="email" name="email" value="<?= $email; ?>"/></p>
        <? if(!isset($_SESSION[$_GET['id']]['ad']['otvet'])){?>
                <p><input type="checkbox" name="otvet" /> Я не хочу получать ответы по объявлению по e-mail </p>
        <? } else { ?>
                <p><input type="checkbox" name="otvet" checked/> Я не хочу получать ответы по объявлению по e-mail </p>
        <? }?>
        <p>Номер телефона <input type="tel" name="phone" value="<?= $phone; ?>"/></p>
        <p><select name="city">
            <? selected($cities, 'city'); ?>     
        </select></p>
        <p><select name="category">
            <? selected($categories, 'category'); ?>
        </select></p>
        <p>Название объявления <input type="text" name="ad_title" value="<?= $ad_title; ?>"/></p>
        <p>Описание объявления <textarea name="ad_description"><?= $ad_description; ?></textarea></p>
        <p>Цена <input type="number" name="price" min="0" max="100000" value="<?= $price; ?>" /> руб</p>
        <p><input type="submit" name="submit"/></p>
        <a href="HW6.php">Главная страница</a>
    </form>
<? exit; }   ?>
<html>
    <head>
        <title>HomeWork6</title>
    </head>
    <body>
        <form method="POST">
            <p><input type="radio" name="type" value="private_person" checked> Частное лицо
            <input type="radio" name="type" value="company"> Компания</p>
            <p>Ваше имя <input type="text" name="name"/></p>
            <p>Электронная почта <input type="email" name="email" /></p>
            <p><input type="checkbox" name="otvet" /> Я не хочу получать ответы по объявлению по e-mail </p>
            <p>Номер телефона <input type="tel" name="phone" /></p>
             <p><select name="city">
                     <option>-- Выберите город --</option><?
                foreach ($cities as $city){ ?>
                <option value="<?= $city; ?>"><?= $city; ?></option>
                <?}
             ?></select></p>
             <p><select name="category">
                <option>-- Выберите Категорию --</option><?
                foreach ($categories as $category){ ?>
                <option value="<?= $category; ?>"><?= $category; ?></option>
                <?}
             ?></select></p>
             <p>Название объявления <input type="text" name="ad_title"/></p>
             <p>Описание объявления <textarea name="ad_description"></textarea></p>
             <p>Цена <input type="number" name="price" min="0" max="100000" value="0" /> руб</p>
            <input type="submit" name="submit">
        </form>
    </body>
</html>
<? showAd();

