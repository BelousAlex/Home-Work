<?
    error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE); // error handling
    ini_set('display_errors', 1);
    
    echo '<h2>Задание 1</h2>';
    $name = 'Alex';
    $age = 23;
    echo 'Меня зовут ' . $name . '<br> Мне ' . $age . ' года';
    unset($name);
    unset($age);
    echo '<hr>';
    
    echo '<h2>Задание 2</h2>';
    define('city', 'Donetsk');
    if(city){
        echo 'Мой город ' . city;
    } else {
        echo 'Константа city не задана';
        define('city', 'Donetsk');
    }
    echo '<hr>';
    
    echo '<h2>Задание 3</h2>';
    $book = array();
    $book['tittle'] = 'Великий Гэтсби';
    $book['author'] = 'Френсис Скотт Фицджеральд';
    $book['pages'] = 180;
    echo 'Недавно я прочитал книгу \'' . $book['tittle'] . '\' , написанную автором ' . $book['author'] . ', я осилил все ' .  $book['pages'] . ' страниц, мне она очень понравилась.';
    unset($book);
    echo '<hr>';
    
    echo '<h2>Задание 4</h2>';
    $book1 = array('title'=>'Великий Гэтсби', 'author'=>'Френсис Скотт Фицджеральд', 'pages'=>180);
    $book2 = array('title'=>'Братья Карамазовы', 'author'=>'Федор Достоевский', 'pages'=>204);
    $book = array($book1, $book2);
    //var_dump($book);
    echo 'Недавно я прочитал книги ' . $book[0]['title'] .  ' и ' . $book[1]['title'] .  ', написанные соответственно авторами ' . $book[0]['author'] . ' и ' . $book[1]['author'] . ", я осилил в сумме " . ($book[0]['pages']+$book[1]['pages']) .  ' страницы, не ожидал от себя подобного';
    echo '<hr>';
?>