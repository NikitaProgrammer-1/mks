<?php
// стартуем сессию, для того, чтобы из кук брать данные пользователя 
session_start();

// если кука с idgroup, не равно 1, значит это читатель и ему нельзя на эту страницу, отпавляем на главную страницу
if($_COOKIE['idgroup'] != 1) {
    header("Location: ../../home_page.php");
}

// если не существует куки id, значит пользователь не прошел авторизацию и мы его направляем на прохождение ее
if(empty($_COOKIE['id'])) {
    header("Location: ../../../index.php");
}

// подключаем БД
require_once("../../../db/db.php");

// из глобальной переменной POST записываем в переменные данные,
// которые приходят из формы создания книги
$title = $_POST['title'];
$author = $_POST['author'];
$year = $_POST['year'];
$descrip = $_POST['descrip'];
$free = 0;

// записываем в переменную путь до фотографии книги
$path = 'upload/books/' . time() . $_FILES['pathimg']['name'];

// переносим нашу фотографию книги в нужную папку
move_uploaded_file($_FILES['pathimg']['tmp_name'], '../../../' . $path);

// выбираем книгу по ее title, которое мы передали в форме
$select_book = mysqli_query($link, "SELECT * FROM `book` WHERE `title` = '$title'");

// превращаем ответ БД в ассоциативный массив
$select_book = mysqli_fetch_assoc($select_book);

// если мы выбрали файл, то делаем выборку с обновлением пути в таблице, 
// если мы файл не выбрали, то создаем выборку без обновления пути в таблице
if(empty($select_book)) {
    mysqli_query($link, "INSERT INTO `book`(`title`, `author`, `year`, `descrip`, `pathimg`, `free`) VALUES ('$title','$author','$year','$descrip','$path','$free')");
    header("Location: ../../../index.php");
} else {
    $_SESSION['ErrMes'] = 'Такая книга существует!';
    header("Location: ../add.php");
}

?>