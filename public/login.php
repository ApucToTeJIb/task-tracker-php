<?php

session_start(); //Для сохранения сессии
require_once 'db.php'; //Подключение к бд

if ($_SERVER['REQUEST_METHOD']=== 'POST') { //Используем из массива _SERVER метод REQUEST_METHOD и проверяем POST ли это
    $login = $_POST['login']; //Присваиваем то что пользователь ввел в поле login из POST в переменную $login
    $password = $_POST['password']; //То же самое и с полем password в $password

    $sql = "SELECT * FROM users WHERE login = ?"; //Подготовка команды
    $stmt = $pdo->prepare($sql); //Связывание команды к бд
    $stmt->execute([$login]); //Отправка с заменой ? на содержимое из переменной $login
    $user = $stmt->fetch(); //Присваивание данных в массив $user

    if ($user && password_verify($password, $user['password'])) { //Проверка на существование юзера и проверка совпадения введенного пароля с паролем соответствующего юзера из бд
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login'] = $user['login'];
        //Сохранение важных данных для текущей сессии

        header('Location: index.php'); //Возврат в index.php
        exit; //Завершение кода
    } else {
        $error = "Неверный логин или пароль!"; //Присваивание ошибки к переменной $error для дальнейшего вывода
    }

}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Чтобы на старом Internet Explorer сайт работал нормально -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в систему</title>
</head>
<body>
    <h2>Авторизация</h2>

    <?php if(isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="login" placeholder="Логин" required><br><br>
        <input type="password" name="password" placeholder="Пароль" required><br><br>
        <button type="submit">Войти</button>
    </form>

</body>
</html>