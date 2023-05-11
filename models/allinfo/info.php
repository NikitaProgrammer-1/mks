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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вся Информация о библиотеке</title>
</head>
<body>
    <h2>Информация о библиотеке</h2>
    <a href="../home_page.php">Назад</a>
    <div class="new-info">
        <div class="new-info-wrapper">
            <h4>Книги</h4>
            <?php
            // делаем запрос в БД для того чтобы посчитать сколько книг у нас в системе
            $select_count = mysqli_query($link, "SELECT COUNT(*) FROM `book` ORDER BY `id` DESC");

            // превращаем ответ из БД в ассоциативный массив
            $select_count = mysqli_fetch_assoc($select_count);
            
            ?>
            <p>Количество книг в библиотеке: <strong><?= $select_count['COUNT(*)']; ?></strong></p>
            <a href="../home_page.php">Посмотреть все</a>
            <br>
            <a href="../new_book/new.php">Посмотреть новые книги</a>
        </div>
    </div>
    <div class="free-book">
        <div class="free-book-wrapper">
            <h4>Количество забронированных книги</h4>
            <?php
            // делаем запрос в БД для того чтобы посчитать сколько забронированных книг у нас в системе 
            $select_booking = mysqli_query($link, "SELECT COUNT(*) FROM `book` WHERE `free` = '1'");

            // превращаем ответ из БД в ассоциативный массив
            $select_booking = mysqli_fetch_assoc($select_booking);

            // делаем запрос в БД для того чтобы посчитать сколько свободных книг у нас в системе
            $select_free = mysqli_query($link, "SELECT COUNT(*) FROM `book` WHERE `free` = '0'");

            // превращаем ответ из БД в ассоциативный массив
            $select_free = mysqli_fetch_assoc($select_free);
            ?>
            <p>Количество незабронированных книг: <strong><?= $select_free['COUNT(*)']; ?></strong></p>
            <p>Количество забронированных книг: <strong><?= $select_booking['COUNT(*)']; ?></strong></p>
        </div>
    </div>
</body>
</html>