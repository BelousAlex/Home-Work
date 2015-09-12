<?php
function AllNews($news){
    echo '<h1>Новости</h1>';
    echo '<ul>';
    foreach ($news as $new){
        echo '<li>' . $new . '</li><br>';
    }
    echo '</ul>';
}

function News ($news){
    $id = (int)$_POST['id'];
    echo '<h2>' . $news[$id] . '</h2>';
}
 
$news ='Четыре новосибирские компании вошли в сотню лучших работодателей
Выставка университетов США: открой новые горизонты
Оценку «неудовлетворительно» по качеству получает каждая 5-я квартира в новостройке
Студент-изобретатель раскрыл запутанное преступление
Хоккей: «Сибирь» выстояла против «Ак Барса» в пятом матче плей-офф
Здоровое питание: вегетарианская кулинария
День святого Патрика: угощения, пивной теннис и уличные гуляния с огнем
«Красный факел» пустит публику на ночные экскурсии за кулисы и по закоулкам столетнего здания
Звезды телешоу «Голос» Наргиз Закирова и Гела Гуралиа споют в «Маяковском»';
$news =  explode("\n", $news);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['id'] <= 8){
        News ($news);
    } else{
        AllNews($news);
    }
} else {
    AllNews($news);
}
?>
<html>
    <head>
        <title>HomeWork5POST</title>
    </head>
    <body>
        <form method="POST">
            <p>Введите число от 0 до 8 для промотра конкретной новости</p>
            <p><input type="number" id="check" name="id" value="0" min="0" max="8"/></p>
            <input type="submit" name="submit" value="Show"/>
        </form>
    </body>
</html>
<? 
if(!empty($_POST['id'])){
    echo '<a href="hw5.2.php">Вернуться</a> к списку новостей?';
}