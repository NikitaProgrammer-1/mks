<?php
// стартуем сессию, чтобы возвращать ошибки из формы
session_start();

// подключаем БД
require_once("../db/db.php");

// из глобальной переменной POST записываем в переменные данные,
// которые приходят из формы авторизации
$login = $_POST['login'];
$password = $_POST['password'];

// производим выборку по логину, который пришел к нам из формы
$select_user = mysqli_query($link, "SELECT * FROM `user` WHERE `login` = '$login'");

// превращаем ответ БД в ассоциативный массив 
$select_user = mysqli_fetch_assoc($select_user);

// из выборки в переменные записываем id и idgroup пользователя
$idus = $select_user['id'];
$idgr = $select_user['idgroup'];

// если асссоциативный массив (ответ из БД) пустой, то отправляем ошибку Такого пользователя не существует,
// если не пустой, хэш пароль из бд с паролем введеным в форму,
// если пароли не совпадают отправляем ошибку Пароль неверный,
// если все правильно ввел пользователь, создаем куки и записываем в них id и idgroup пользователя
if(!empty($select_user)) {
    if(password_verify($password, $select_user['password'])) {
        setcookie("id", $idus, time()+23760, "/");
        setcookie("idgroup", $idgr, time()+23760, "/");
        header("Location: ../index.php");
    } else {
        $_SESSION['ErrMes'] = 'Пароль неверный!';
        header("Location: ../index.php");
    }
} else {
    $_SESSION['ErrMes'] = "Такого пользователя не существует!";
    header("Location: ../index.php");
}
?>