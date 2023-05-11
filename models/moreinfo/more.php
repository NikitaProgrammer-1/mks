<?php
// стартуем сессию, для того, чтобы из кук брать данные пользователя 
session_start();

// если кука с idgroup, не равно 1, значит это читатель и ему нельзя на эту страницу, отпавляем на главную страницу
if(empty($_COOKIE['id'])) {
    header("Location: ../../index.php");
}

// записываем в переменную id книги, которую передали через ссылку
$id = $_GET['id'];

// подключаем БД
require_once("../../db/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Подробнее</title>
</head>
<body>
    <?php
    // выбираем книгу по id
    $select_one = mysqli_query($link, "SELECT * FROM `book` WHERE `id` = '$id'");

    // превращаем ответ БД в ассоциативный массив
    $select_one = mysqli_fetch_assoc($select_one);
    ?>
    <h2>Подробнее о книге <em><?= $select_one['title']; ?></em></h2>
    <a href="../home_page.php">Назад</a>
    <div class="one-book">
        <div class="onebook-wrapper">
            <img src="<?= '../../' . $select_one['pathimg']; ?>">
            <h2>Автор книги: <?= $select_one['author']; ?></h2>
            <p>Год издания книги: <?= $select_one['year']; ?></p>
            <p><?= $select_one['descrip']; ?></p>
        </div>
    </div>
    <a href="book.php?id=<?= $id ?>">Забронировать</a>
    <br>
    <?php
    // если кука idgroup, содержит в себе 1, то это библиотекарь и он имеет доступ к этим ссылкам
    if($_COOKIE['idgroup'] == 1) { ?>
        <a href="delete.php?id=<?= $id ?>">Удалить Книгу</a>
        <br>
        <a href="update.php?id=<?= $id ?>">Изменить Книгу</a>
    <?php } ?>
</body>
</html>