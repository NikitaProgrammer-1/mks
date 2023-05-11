<?php
// стартуем сессию, для того, чтобы из кук брать данные пользователя 
session_start();

// если не существует куки id, значит пользователь не прошел авторизацию и мы его направляем на прохождение ее
if(empty($_COOKIE['id'])) {
    header("Location: ../../index.php");
}

// подключаем БД
require_once("../../db/db.php");

// записываем в переменную id пользователя, который передался в ссылке 
$iduser = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отчет</title>
</head>
<body>
    <h2>Формирование отчета</h2>
    <a href="../home_page.php">Назад</a>
    <div class="user-info">
        <div class="user-info-wrapper">
            <?php
            // делаем выборку из БД по id пользователя 
            $select_user = mysqli_query($link, "SELECT * FROM `user` WHERE `id` = '$iduser'");

            // превращаем ответ БД в ассоциативный массив
            $select_user = mysqli_fetch_assoc($select_user);
            ?>
            <h4>Ваши данные</h4>
            <p>Логин: <?= $select_user['login'] ?></p>
            <p>Email: <?= $select_user['email'] ?></p>
            <p>Телефон: <?= $select_user['phone'] ?></p>
            <p>ФИО: <?= $select_user['fio'] ?></p>
        </div>
    </div>
    <div class="books-read">
        <div class="books-read-wrapper">
            <h4>Прочитанные книги</h4>
            <?php
            // делаем выборку на забронированные книги, принадлежащие этому пользователю 
            $select_booksread = mysqli_query($link, "SELECT * FROM `booking` WHERE `iduser` = '$iduser'");

            // превращаем ответ БД в ассоциативный массив, обычный массив или в оба
            $select_booksread = mysqli_fetch_all($select_booksread);

            // переберем массив с ответами при помощи цикла и выведем значения
            foreach($select_booksread as $sbr) { 
            $sbrid = $sbr[1];
            $select_books = mysqli_query($link, "SELECT * FROM `book` WHERE `id` = '$sbrid'");
            $select_books = mysqli_fetch_assoc($select_books)    
            ?>
                <a href="../moreinfo/more.php?id=<?= $sbr[1] ?>"><?= $select_books['title'] ?></a>
            <?php } ?>
        </div>
    </div>
</body>
</html>