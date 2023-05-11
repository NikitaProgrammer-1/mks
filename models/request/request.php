<?php
// стартуем сессию, для того, чтобы из кук брать данные пользователя 
session_start();

// если не существует куки id, значит пользователь не прошел авторизацию и мы его направляем на прохождение ее
if(empty($_COOKIE['id'])) {
    header("Location: ../../index.php");
}

// подключаем БД
require_once("../../db/db.php");

// записываем из глобального массива POST данные из формы в переменную
$search = $_POST['search'];

// делаем выборку по тому слову, которое пришло из формы 
$select_search = mysqli_query($link, "SELECT * FROM `book` WHERE `title` = '$search'");

// превращаем ответ БД в ассоциативный массив
$select_search = mysqli_fetch_assoc($select_search);

// если ответ из БД пришел пустым, то отправляем сообщение об ошибке Книга не найдена
// или если он существует, но она забронированна, то отправляем сообщение об ошибке Книга забронирована
if(empty($select_search)) {
    $_SESSION['ErrMes'] = 'Книга не найдена';
    header("Location: ../home_page.php");
} elseif ($select_search['free'] == 1) {
    $_SESSION['ErrMes'] = 'Книга забронирована';
    header("Location: ../home_page.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск по запросу - <?= $search; ?></title>
</head>
<body>
    <h2>Результат запроса - <?= $search; ?></h2>
    <a href="../home_page.php">Назад</a>
    <p>Книга: <a href="../moreinfo/more.php?id=<?= $select_search['id']; ?>"><?= $select_search['title']; ?></a></p>
</body>
</html>