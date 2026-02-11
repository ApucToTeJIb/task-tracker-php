<?php
session_start(); //Подключаемся к текущей сессии
session_destroy(); //Удаляем файл сессии на сервере

header('Location: login.php'); //Отправляем юзера обратно на страницу входа
exit;