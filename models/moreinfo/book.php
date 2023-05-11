<?php
// стартуем сессию, для того, чтобы из кук брать данные пользователя 
session_start();

// если кука с idgroup, не равно 1, значит это читатель и ему нельзя на эту страницу, отпавляем на главную страницу
if($_COOKIE['idgroup'] != 1) {
    header("Location: ../home_page.php");
}

// если не существует куки id, значит пользователь не прошел авторизацию и мы его направляем на прохождение ее
if(empty($_COOKIE['id'])) {
    header("Location: ../../index.php");
}

// подключаем БД
require_once("../../db/db.php");

// записываем в переменную id книги, которую передали через ссылку
$id = $_GET['id'];

// записываем в переменную id пользователя, который хранится в его куке
$iduser = $_COOKIE['id'];

// обновляем таблицу по id книги и ставим ей бронь
mysqli_query($link, "UPDATE `book` SET `free`='1' WHERE `id` = '$id'");

// вставляем в таблицу с бронированием id книги и id пользователя для дальнейшего учета
mysqli_query($link, "INSERT INTO `booking`(`idbook`, `iduser`) VALUES ('$id','$iduser')");

header("Location: ../home_page.php");

?>