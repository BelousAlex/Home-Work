<?
$ini_string = '
[игрушка мягкая мишка белый]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[одежда детская куртка синяя синтепон]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(1, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[игрушка детская велосипед]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont '.  mt_rand(0, 2).'; ';
    
$bd = parse_ini_string($ini_string, true);

// Получение ключей массива
function Keys($array){
   return $keys = array_keys($array); 
}
//Вывод на нижней части табл экран и подсчет суммы с учетом процентов
function conclusion($arrays){
    global $bd;
    $output = '';
    $i = 0;
    $sum_per = 0;
    foreach($arrays as $array){
         $output .=  '<td>' . Keys($bd)[$i] . '</td>';
         $output .= '<td align="center">'.$array['цена'].'</td>';
         $output .= '<td align="center">'.$array['количество заказано'].'</td>';
         $output .= '<td align="center">'.$array['осталось на складе'].'</td>';
         $func = 'Diskont';
         $output .= '<td align="center">'.$func($array).'</td>';
         $output .= '<td align="center">' . $per = Percent($array['количество заказано'], $array['цена'], Diskont($array), $array['осталось на складе']) . '</td>';

         $output .='</tr>';
         $i++;
         $sum_per += $per;
     }
     return array($output, $sum_per);
     //return $sum_per += $per;
}
// Подсчет суммы (без учета скидок), подсчет заказанного кол-во товаров, вывод массива Уведомлений 
function Mass($arrays){
    $array_notice = array();
    $i = 0;
    $summa = 0;
    $sum = 0;
    $zak_sum = 0;
    foreach($arrays as $array){
        if($array['количество заказано']> $array['осталось на складе']){
            $sum = $array['осталось на складе'];
            if($array['осталось на складе']==0){
                $array_notice[$i] = Keys($arrays)[$i] . ' <b>нет на складе</b>';
            } else {
                $array_notice[$i] = Keys($arrays)[$i] . ' осталось всего '  . $array['осталось на складе'];
            }
        } else {
            $sum = $array['количество заказано'];
            $array_notice[$i] = '';
        }
        $summa += $sum;
        $zak_sum += $sum*$array['цена'];
        $i++;
    }
    return array($summa, $zak_sum, $array_notice);
}
//Очишает пустые поля в массиве, переопределяет заново ключи
function Filter_array($array){
    $filter = array_filter($array, function($el){ return !empty($el);} );
    return $filtered_array = array_values($filter);
}
//Подсчет итогой суммы с учетом процентов
function Percent($quantity, $price, $diskont, $remain){
    if($quantity>=$remain){
        $sum = $remain * $price;
    } else{
        $sum = $quantity * $price;
    }
    $percent = ($sum/100)*$diskont;
    $itog = $sum-$percent;
    return $itog;
}
//Редактирование поля Скидок
function Diskont($array){
    if(str_replace('diskont', "", $array['diskont']) == 0){
        return 'Скидки нет';
    } else {
        return (str_replace('diskont', "", $array['diskont']))*10 . '%';
    }
    //return (str_replace('diskont', "", $b['diskont']))*10 . '%';
}
//Секция Уведомления
function Notification(){
    global $bd;
    $output = '';
     $notice = (Filter_array(Mass($bd)[2])); 
        if(empty($notice)){
           $output .= '<ul><li>Все выбранные Вами товары есть в наличии</li></ul>';
        } else {
            $output .= '<p>К сожалению, некоторых товаров, заказанных вами, недостаточно на складе или нет вовсе: </p>';
            $output .= '<ul>';
            for ($i = 0;$i <= count($notice)-1; $i++){
                $output .= '<li>' . $notice[$i] . '</li>';
            } 
            $output .= '</ul>';
        }
        return $output;
}
//Секция Специальные предложения
function Special_offers(){
    global $bd;
    $output = '';
    if($bd['игрушка детская велосипед']['количество заказано'] >= 3 && $bd['игрушка детская велосипед']['осталось на складе']>=3){
        $output .= 'Вы заказали <b>\'Игрушка детская велосипед\'</b>, в кол-ве 3 шт или более, на данный товар <b>Вам была выдана скидка в размере 30%</b><br>';
        $output .= '<h2>Поздравляем!!!</h2>';
    } else {
        $output .= 'Специальных предложений на данный момет нет.';
    }
    return $output;
}
// Проверка на наличие скидки в 30 %
if($bd['игрушка детская велосипед']['количество заказано'] >= 3 && $bd['игрушка детская велосипед']['осталось на складе']>=3){
    $bd['игрушка детская велосипед']['diskont'] = '3';
} 
?>

<html>
    <head>
        <title>HomeWork4</title>
    </head>
    <body>
        <table border='1px' width="100%" height="23%">
            <tr>
                <th>Перечень товаров</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th>Остаток</th>
                <th>Скидка</th>
                <th>Стоимость заказа</th>
            </tr>
            <tr>
            <?
                echo conclusion($bd)[0];
            ?>
            <tr>
               <td colspan="5">Итого</td>
               <td align="center"><?= conclusion($bd)[1]; ?></td>
           </tr>
        </table>

        <h1>Итого:</h1>
        <ul>
        <li>Всего наименований: <? echo count(Keys($bd));?></li>
        <li>Общее кол-во заказанных товаров: <?= Mass($bd)[0];?></li>
        <li>Общяя сумма заказанных товаров: <?= Mass($bd)[1] . ' руб'; ?></li>
        <li>Общяя сумма заказанных товаров с учетом скидок: <?= conclusion($bd)[1] . ' руб';  ?></li>
        <li>С учетом всех скидок, Вы экономите: <?= Mass($bd)[1]-conclusion($bd)[1] . ' руб'; ?></li>
        </ul>

        <h1>Уведомления:</h1>
        <?
            echo Notification();
        ?>

         <h1>Специальное предложение: </h1>
        <?
           echo Special_offers();
        ?>
    </body>
</html>
