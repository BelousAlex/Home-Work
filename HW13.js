console.log('Задание 1');
var name = 'Alex', age = 23;
console.log('Меня зовут '+name+'\n Мне '+age+' лет' );
delete(name);
delete(age);

console.log('Задание 2');
const my_city = 'Donetsk';
if(my_city){
  console.log(my_city);
} else {
  const my_city = 'Donetsk';
  console.log('Константа была задана');
  console.log(my_city);
}

my_city = 'Kharkov'; //константа не переопределяется!!!
console.log(my_city);

console.log('Задание 3');
var book = new Array();
book['title'] = 'Великий Гетсби';
book['author'] = 'Френсис Скотт Фицджеральд';
book['pages'] = 180;
console.log('Недавно я прочитал книгу ' + book['title'] + '\', написанную автором ' + book['author'] + ', я осилил все ' +  book['pages'] + ' страниц, мне она очень понравилась.');
delete(book);

console.log('Задание 4');
var book1 = {'title':'Великий Гэтсби', 'author':'Френсис Скотт Фицджеральд', 'pages':180};
var book2 ={'title':'Братья Карамазовы', 'author':'Федор Достоевский', 'pages':204};
var book = new Array();
book[0] = book1;
book[1] = book2;
console.log('Недавно я прочитал книги ' + book[0]['title'] +  ' и ' + book[1]['title'] +  ', написанные соответственно авторами ' + book[0]['author'] + ' и ' + book[1]['author'] + ", я осилил в сумме " + (book[0]['pages']+book[1]['pages']) +  ' страницы, не ожидал от себя подобного');
//var book = {book1, book2};
//console.log('Недавно я прочитал книги ' + book['book1']['title'] +  ' и ' + book['book2']['title'] +  ', написанные соответственно авторами ' + book['book1']['author'] + ' и ' + book['book2']['author'] + ", я осилил в сумме " + (book['book1']['pages']+book['book2']['pages']) +  ' страницы, не ожидал от себя подобного');