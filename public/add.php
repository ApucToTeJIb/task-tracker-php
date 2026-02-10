<?php

require_once 'db.php'; //Настройка на бд

if (isset($_POST['title']) && !empty($_POST['title'])) { //Проверка не пустое ли поле
    $title = $_POST['title']; //Присваивание данных в переменную
    $sql = "INSERT INTO tasks (title) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title]); //Отправление данных в бд
}
header('Location: index.php'); //Возврат обратно в index.php
exit;