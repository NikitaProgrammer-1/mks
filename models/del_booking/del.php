<?php
// стартуем сессию, для того, чтобы из кук брать данные пользователя 
session_start();

// если не существует куки id, значит пользователь не прошел авторизацию и мы его направляем на прохождение ее
if(empty($_COOKIE['id'])) {
    header("Location: ../../index.php");
}

// подключаем БД
require_once("../../db/db.php");

// записываем в переменную id пользователя, который хранится в его куке
$iduser = $_COOKIE['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Забронированные книги</title>
</head>
<body>
    <h2>Мои книги</h2>
    <a href="../home_page.php">Назад</a>
    <br>
    <?php
    // делаем выборку на забронированные книги данным пользователем 
    $select_book = mysqli_query($link, "SELECT * FROM `booking` WHERE `iduser` = '$iduser'");

    // превращаем ответ БД в ассоциативный массив, обычный массив или в оба
    $select_book = mysqli_fetch_all($select_book);
    
    // переберем массив с ответами при помощи цикла и выведем значения 
    foreach($select_book as $sb) {

        // записываем id книги в таблице, в переменную
        $sb_id = $sb[1];

        // делаем выборку конкретной книги по ее id
        $select_one = mysqli_query($link, "SELECT * FROM `book` WHERE `id` = '$sb_id' AND `free` = '1'");

        // превращаем ответ БД в ассоциативный массив
        $select_one = mysqli_fetch_assoc($select_one);

        // если массив с ответом из БД пришел пустым, то выдаем сообщение у вас нет забронированных книг
        // или выводим список книг, которые забронировал пользователь
        if(empty($select_one)) {
            echo "у вас нет забронированных книг";
        } else { ?>
            <div class="book" style="margin-top: 30px;">
                <div class="book-wrapper">
                    <div class="bw-image">
                        <img src="<?= '../../' . $select_one['pathimg']; ?>">
                    </div>
                    <div class="bw-info">
                        <h4><?= $select_one['title']; ?></h4>
                        <h5>Автор: <?= $select_one['author']; ?></h5>
                        <p><?= $select_one['descrip']; ?></p>
                        <?php 

                        ?>
                        <a href="./del_booking.php?id=<?= $select_one['id']; ?>">Убрать бронь</a>
                    </div>
                </div>
            </div>
        <?php }
        
    } ?>
</body>
</html>