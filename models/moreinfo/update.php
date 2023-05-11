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

// выбираем книгу по id
$select_one = mysqli_query($link, "SELECT * FROM `book` WHERE `id` = '$id'");

// превращаем ответ БД в ассоциативный массив
$select_one = mysqli_fetch_assoc($select_one);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tiny.cloud/1/fipw5p8ktoulbzn13x05gn3k023y7zotl1ttiifwjubct86w/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <title>Добавить книгу</title>
</head>
<body>
    <h2>Добавить книгу</h2>
    <a href="../home_page.php">Назад</a>
    <form action="./vendor/update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="text" name="title" placeholder="Название" value="<?= $select_one['title'] ?>">
        <br>
        <br>
        <input type="text" name="author" placeholder="Автор" value="<?= $select_one['author'] ?>">
        <br>
        <br>
        <input type="text" name="year" placeholder="Год издания" value="<?= $select_one['year'] ?>">
        <br>
        <br>
        <textarea name="descrip" cols="30" rows="10" placeholder="Краткое описание" id="editor"><?= $select_one['descrip'] ?></textarea>
        <br>
        <br>
        <input type="file" name="pathimg">
        <br>
        <br>
        <input type="submit" value="Изменить">
    </form>
    
<script>
    tinymce.init({
        selector: 'textarea#editor',  //Change this value according to your HTML
        auto_focus: 'element1',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    }); 
</script>
</body>
</html>