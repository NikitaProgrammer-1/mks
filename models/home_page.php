<?php
// стартуем сессию, для того, чтобы из кук брать данные пользователя 
session_start();

// если не существует куки id, значит пользователь не прошел авторизацию и мы его направляем на прохождение ее
if(empty($_COOKIE['id'])) {
    header("Location: ../index.php");
}

// подключаем БД
require_once("../db/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Главная</title>
</head>
<body>
    <a href="../logout.php">Выйти</a>
    <div class="header">
        <h2>Книги</h2>
        <a href="./del_booking/del.php">Все забронированные книги</a>
        <br>
        <a href="./report/report.php?id=<?= $_COOKIE['id']; ?>">Сформировать отчет</a>
        <br>
        <?php
        // из кук берем значение idgroup, чтобы обычный читатель не имел доступа к функциям библиотекаря
        if($_COOKIE['idgroup'] == 1) { ?>
            <a href="./add_book/add.php">Добавить книгу</a>
            <br>
            <a href="./new_book/new.php">Недавние поступления</a>
            <br>
            <a href="./allinfo/info.php">Информация о библиотеке</a>
        <?php } ?>
    </div>
    <div class="option">
        <div class="option-wrapper">
            <div class="ow-one">
                <h4>Сортировка</h4>
                <form action="./home_page.php" method="post" style="margin-bottom: 30px;">
                    <select name="sort">
                        <option value="DESC">Новые</option>
                        <option value="ASC">Старые</option>
                        <option value="FREE">Свободные</option>
                    </select>
                    <input type="submit" value="Отсортировать">
                </form>
            </div>
            <div class="ow-two">
                <h4>Найти книгу</h4>
                <form action="./request/request.php" method="post">
                    <input type="text" name="search" placeholder="Введите название книги">
                    <input type="submit" value="Найти">
                </form>
                <?php
                // если переменная ErrMes пустая, то он выводит пустоту, если же не пустая,
                // то выводит содержимое переменной ErrMes,
                // если не сделать данную проверку, будут ошибки, тк такой перменной не будет существовать
                // пока не будут переданы в нее данные 
                if (($_SESSION['ErrMes'] ?? '') === ''); else {
                    print_r($_SESSION['ErrMes']);
                    session_destroy();
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    
    // если из формы сортировки что-то проишло то записываем значение в переменную
    if(!empty($_POST)) {
        $select_sort = $_POST['sort'];
    }

    // если из формы сортировки ничего не проишло то делаем стандартную выборку в обратном порядке 
    // если из формы сортировки проишло значение ASC, то мы сортируем по порядку 
    // если из формы сортировки проишло значение DESC, то мы сортируем в обратном порядке 
    // если из формы сортировки проишло значение FREE, то мы сортируем в обратном порядке и свободные книги
    if(empty($_POST)) {
        $select_all = mysqli_query($link, "SELECT * FROM `book` WHERE `free` = '0' ORDER BY `id` DESC");

        // превращаем ответ БД в ассоциативный массив, обычный массив или в оба
        $select_all = mysqli_fetch_all($select_all);
    } elseif($select_sort == "ASC") {
        $select_all = mysqli_query($link, "SELECT * FROM `book` WHERE `free` = '0' ORDER BY `id` ASC");

        // превращаем ответ БД в ассоциативный массив, обычный массив или в оба
        $select_all = mysqli_fetch_all($select_all);
    } elseif ($select_sort == "DESC") {
        $select_all = mysqli_query($link, "SELECT * FROM `book` WHERE `free` = '0' ORDER BY `id` DESC");
        
        // превращаем ответ БД в ассоциативный массив, обычный массив или в оба
        $select_all = mysqli_fetch_all($select_all);
    } elseif ($select_sort == "FREE") {
        $select_all = mysqli_query($link, "SELECT * FROM `book` WHERE `free` = '0' ORDER BY `id` DESC");

        // превращаем ответ БД в ассоциативный массив, обычный массив или в оба
        $select_all = mysqli_fetch_all($select_all);
    }

    // переберем массив с ответами при помощи цикла и выведем значения 
    foreach($select_all as $sa) { ?>
        <div class="book" style="margin-top: 30px;">
            <div class="book-wrapper">
                <div class="bw-image">
                    <img src="<?= '../' . $sa[5]; ?>">
                </div>
                <div class="bw-info">
                    <h4><?= $sa[1]; ?></h4>
                    <h5>Автор: <?= $sa[2]; ?></h5>
                    <p><?= $sa[4]; ?></p>
                    <?php 

                    ?>
                    <a href="./moreinfo/more.php?id=<?= $sa[0]; ?>">Подробнее</a>
                </div>
            </div>
        </div>
    <?php } ?>
    
</body>
</html>