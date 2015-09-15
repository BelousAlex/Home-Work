<?
$cities = array('-- Выберите город --', 'Донецк', 'Луганск', 'Харьков', 'Днепропетровск', 'Киев');
$categories = array('-- Выберите Категорию --', 'Работа', 'Услуги', 'Хобби', 'Недвижимость', 'Транспорт'); 

function showAd(){
    global $_COOKIE;
    echo '<h1>Объявления</h1>';
    if(!empty($_COOKIE['abs'])){
    $gh = explode(',', $_COOKIE['abs']);
    foreach ($gh as $abs){
        $f = trim($abs);
        $f = unserialize(base64_decode($f));
        foreach($f as $key=>$val){
            echo '<a href="HW7_1.php?id='.$key.'">'.$val['ad_title'] .'</a>' . ' | '. $val['email'] . ' |  <a href="HW7_1.php?delete='.$key.'">Удалить</a><br>';
        }
    }
    } else {
        echo 'Объявлений нет';
    }
}

function selected($array, $field_name){
$select = $field_name;
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

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(empty($_COOKIE['abs'])){
            $set[uniqid()] = $_POST;
            $set = base64_encode(serialize($set));
            setcookie('abs', $set, time()+3600*24*7);
            header("Location: HW7_1.php");
        } else {
            $set[uniqid()] = $_POST;
            $set = base64_encode(serialize($set));
            setcookie('abs', $_COOKIE['abs'] .= ','. $set, time()+3600*24*7);
            header("Location: HW7_1.php");
        }
 } elseif(isset($_GET['delete'])){
     $arr = '';
     $razbienie = explode(',', $_COOKIE['abs']);
     foreach($razbienie as $otdel_ser){
         $array_cookie = unserialize(base64_decode($otdel_ser));
         if(isset($array_cookie[$_GET['delete']])){
            unset($array_cookie[$_GET['delete']]);
         } else {
            $arr .= ','.$otdel_ser;
         }
     }
     $clear = substr($arr, 1);
     setcookie('abs', $clear, time()+3600*24*7);
     header("Location: HW7_1.php");
} elseif(isset($_GET['id'])){
    $unpacking_cookies = explode(',', $_COOKIE['abs']);
    foreach($unpacking_cookies as $unpacking_cookie){
        $unpacking_array_cookie = unserialize(base64_decode($unpacking_cookie));
        if(isset($unpacking_array_cookie[$_GET['id']])){
            $name = cleaning($unpacking_array_cookie[$_GET['id']]['name']);
            $email = cleaning($unpacking_array_cookie[$_GET['id']]['email']);
            $phone = $unpacking_array_cookie[$_GET['id']]['phone'];
            $ad_title = cleaning($unpacking_array_cookie[$_GET['id']]['ad_title']);
            $ad_description = cleaning($unpacking_array_cookie[$_GET['id']]['ad_description']);
            $price = $unpacking_array_cookie[$_GET['id']]['price'];
            $type = cleaning($unpacking_array_cookie[$_GET['id']]['type']);
            if(isset($unpacking_array_cookie[$_GET['id']]['otvet'])){
                $otvet = cleaning($unpacking_array_cookie[$_GET['id']]['otvet']);
            } else {
                $otvet = '';
            }
            $city = cleaning($unpacking_array_cookie[$_GET['id']]['city']);
            $category = cleaning($unpacking_array_cookie[$_GET['id']]['category']);
        }
    }?>
        <form method="POST">
            <? if($type == 'private_person'){?>
                <p><input type="radio" name="type" value="private_person" checked> Частное лицо
                <input type="radio" name="type" value="company"> Компания</p>
            <?  } else { ?>
                <p><input type="radio" name="type" value="private_person"> Частное лицо
                <input type="radio" name="type" value="company" checked> Компания</p>
            <? } ?>
            <p>Ваше имя <input type="text" name="name" value="<?= $name; ?>"/></p>
            <p>Электронная почта <input type="email" name="email" value="<?= $email; ?>"/></p>
            <? if(empty($otvet)){?>
                <p><input type="checkbox" name="otvet" /> Я не хочу получать ответы по объявлению по e-mail </p>
            <? } else { ?>
                <p><input type="checkbox" name="otvet" checked/> Я не хочу получать ответы по объявлению по e-mail </p>
            <? }?>
            <p>Номер телефона <input type="tel" name="phone" value="<?= $phone; ?>"/></p>
            <p><select name="city">
                <? selected($cities, $city); ?>     
            </select></p>
            <p><select name="category">
                <? selected($categories, $category); ?>
            </select></p>
            <p>Название объявления <input type="text" name="ad_title" value="<?= $ad_title; ?>"/></p>
            <p>Описание объявления <textarea name="ad_description"><?= $ad_description; ?></textarea></p>
            <p>Цена <input type="number" name="price" min="0" max="100000" value="<?= $price; ?>" /> руб</p>
            <p><input type="submit" name="submit"/></p>
            <a href="HW7_1.php">Главная страница</a>
    </form>
<? exit; } 
 ?>
    <form method="POST">
        <p><input type="radio" name="type" value="private_person" checked> Частное лицо
        <input type="radio" name="type" value="company"> Компания</p>
        <p>Ваше имя <input type="text" name="name"/></p>
        <p>Электронная почта <input type="email" name="email" /></p>
        <p><input type="checkbox" name="otvet" /> Я не хочу получать ответы по объявлению по e-mail </p>
        <p>Номер телефона <input type="tel" name="phone" /></p>
         <p><select name="city"><?
            foreach ($cities as $city){ ?>
            <option value="<?= $city; ?>"><?= $city; ?></option>
            <?}
         ?></select></p>
         <p><select name="category"><?
            foreach ($categories as $category){ ?>
            <option value="<?= $category; ?>"><?= $category; ?></option>
            <?}
         ?></select></p>
         <p>Название объявления <input type="text" name="ad_title"/></p>
         <p>Описание объявления <textarea name="ad_description"></textarea></p>
         <p>Цена <input type="number" name="price" min="0" max="100000" value="0" /> руб</p>
        <input type="submit" name="submit">
    </form>
<? showAd();

 