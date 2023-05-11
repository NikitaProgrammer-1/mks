<?php 
// стартуем сессию, чтобы возвращать ошибки из формы
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>
<body>
    <h2>Авторизация</h2>
    <form action="./vendor/log.php" method="post">
        <input type="text" name="login" placeholder="Логин">
        <input type="password" name="password" placeholder="Пароль">
        <input type="submit" value="Войти">
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
    <a href="./registr.php">Регистрация</a>
</body>
</html>