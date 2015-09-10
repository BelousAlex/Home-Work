<?
   echo 'Задание 1.1-1.2';
   $date = array(
        rand(1, time()),
        rand(1, time()),
        rand(1, time()),
        rand(1, time()),
        rand(1, time())
   );
   var_dump($date);
   echo '<hr>';
   
   echo 'Задание 1.3<br>';
   /*$data = array(
        date('d', $date[0]),
        date('d', $date[1]),
        date('d', $date[2]),
        date('d', $date[3]),
        date('d', $date[4])
   );
    $month = array(
        date('m', $date[0]),
        date('m', $date[1]),
        date('m', $date[2]),
        date('m', $date[3]),
        date('m', $date[4])
    );
   $minData = min($data);
   $maxMonth = max($month);
   echo 'Наименьший день: ' . $minData . ', а Наибольший месяц: ' . $maxMonth;*/
   
   $day = [];
   $month = [];
   $i = 0;
   foreach ($date as $dat){
	   $day[$i] = date('d', $dat);
	   $month[$i] = date('m', $dat);
	   $i++;
   }
   echo 'Наименьший день: ' . $minDay = min($day) . '. Наибольший месяц: ' . $maxDay = max($month);
   echo '<hr>';
   
   echo 'Задание 1.4<br>';
   array_multisort($date);
   var_dump($date);
   echo '<hr>';
   
   echo 'Задание 1.5-1.6<br>';
   $selected = array_pop($date);
   echo date_default_timezone_get() . '<br>';
   echo date('d.m.Y H-i-s', $selected);
   echo '<hr>';
   
   echo 'Задание 1.7<br>';
   date_default_timezone_set('America/New_York');
   echo date_default_timezone_get();
   echo '<br>' . date('d.m.Y H-i-s', $selected);
   echo '<hr>';