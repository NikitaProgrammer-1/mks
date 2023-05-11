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
    <link rel="stylesheet" href="../../style/style.css">
    <title>Недавние поступления</title>
</head>
<body>
    <h2>Недавние поступления</h2>
    <a href="../home_page.php">Назад</a>
    <?php
    // делаем просто выборку по id в обратном порядке 
    $select_all = mysqli_query($link, "SELECT * FROM `book` ORDER BY `id` DESC LIMIT 10");

    // превращаем ответ БД в ассоциативный массив, обычный массив или в оба
    $select_all = mysqli_fetch_all($select_all);

    // переберем массив с ответами при помощи цикла и выведем значения
    foreach($select_all as $sa) { ?>
        <div class="book" style="margin-top: 30px;">
            <div class="book-wrapper">
                <div class="bw-image">
                    <img src="<?= '../../' . $sa[5]; ?>">
                </div>
                <div class="bw-info">
                    <h4><?= $sa[1]; ?></h4>
                    <h5>Автор: <?= $sa[2]; ?></h5>
                    <p><?= $sa[4]; ?></p>
                    <a href="../moreinfo/more.php?id=<?= $sa[0]; ?>">Подробнее</a>
                </div>
            </div>
        </div>
    <?php } ?>
</body>
</html>