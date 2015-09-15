<?
define ('ads', 'ads.txt');

$cities = array('-- Выберите город --', 'Донецк', 'Луганск', 'Харьков', 'Днепропетровск', 'Киев');
$categories = array('-- Выберите Категорию --', 'Работа', 'Услуги', 'Хобби', 'Недвижимость', 'Транспорт');

function showAd(){
    echo '<h1>Объявления</h1>';
    if(file_exists(ads) && filesize(ads) != 0){
        $array_ads = file(ads);
        foreach ($array_ads as $array){
            $ad = unserialize($array);
            foreach ($ad as $key=> $aa){
               $ad = explode(' / ', $aa);
            echo '<a href="HW7_2.php?id='.$key.'">'.$ad[7] .'</a>' . ' | '. $ad[2] . ' |  <a href="HW7_2.php?delete='.$key.'">Удалить</a><br>';
            }
        }
    } else {
        echo 'Объявлений нет';
    }
}

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
    header("Location: HW7_2.php");
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

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $type = cleaning($_POST['type']);
    $name = cleaning($_POST['name']);
    $email = cleaning($_POST['email']);
    if(isset($_POST['otvet'])){
        $otvet = $_POST['otvet'];
    } else {
        $otvet = '';
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
} elseif(isset($_GET['id'])){
    $arr = file_get_contents(ads);
    $arr = explode("\n", $arr);
    foreach ($arr as $aa){
        $aa = unserialize($aa);
        if(isset($aa[$_GET['id']])){
            $bb = explode(' / ', $aa[$_GET['id']]);
            $name = cleaning($bb[1]);
            $email = cleaning($bb[2]);
            $phone = $bb[4];
            $ad_title = cleaning($bb[7]);
            $ad_description = cleaning($bb[8]);
            $price = $bb[9];
            $type = cleaning($bb[0]);
            $category = cleaning($bb[6]);
            if(isset($bb[3])){
                $otvet = cleaning($bb[3]);
            } else {
                $otvet = '';
            }
            $city = cleaning($bb[5]);
        }
    } ?>
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
            <a href="HW7_2.php">Главная страница</a>
    </form>
<? exit; } ?>
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



