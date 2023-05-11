<?php
// стартуем сессию, чтобы возвращать ошибки из формы
session_start();

// подключаем БД
require_once("../db/db.php");

// из глобальной переменной POST записываем в переменные данные,
// которые приходят из формы регистрации
$idgroup = 2;
$login = $_POST['login'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$fio = $_POST['fio'];

// сравнием пароли из формы, если они не совпадают 
// оптравляем сообщение об ошибке Пароли не совпадают
if($password == $cpassword) {

    // хэшируем пароль 
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    // создаем выборку по логину, который пришел к нам из формы
    $select_user = mysqli_query($link, "SELECT * FROM `user` WHERE `login` = '$login'");
    
    // превращаем ответ БД в ассоциативный массив 
    $select_user = mysqli_fetch_assoc($select_user);

    // если асссоциативный массив (ответ из БД) не пустой, то отправляем ошибку Такого пользователь уже существует
    // если он пустой, то создаем запрос на вставку в БД с данными формы регистрации
    if(!empty($select_user)) {
        $_SESSION['ErrMes'] = "Такого пользователь уже существует!";
        header("Location: ../registr.php");
    } else {
        mysqli_query($link, "INSERT INTO `user`
                            (`idgroup`, `login`, `password`, `email`, `phone`, `fio`) 
                            VALUES 
                            ('$idgroup','$login','$pass_hash','$email','$phone','$fio')");
        header("Location: ../index.php");
    }
} else {
    $_SESSION['ErrMes'] = "Пароли не совпадают!";
    header("Location: ../registr.php");
}

?>