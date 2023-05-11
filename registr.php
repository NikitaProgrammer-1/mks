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
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <form action="./vendor/reg.php" method="post">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="password" name="cpassword" placeholder=" Подтверждение Пароля" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Телефон" required>
        <input type="text" name="fio" placeholder="ФИО" required>
        <input type="submit" value="Зарагистрироваться">
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
    <a href="./login.php">Авторизоваться</a>
</body>
</html>