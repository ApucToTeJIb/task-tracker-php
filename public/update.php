<?php

session_start(); //Привязка к сессии
require_once 'db.php'; //Настройка к бд

if($_SERVER['REQUEST_METHOD'] === 'POST') { //Подтверждение POST мотодом ли прилетелиданные
    $id = (int)$_POST['id']; //Кладет значение $id для execute превращая тип данных в int
    $title = $_POST['title']; //Кладет значение title из POST для execute 
    $status = $_POST['status']; //Так же
    $user_id = $_SESSION['user_id']; //Так же но из SESSION для подтверждения пользователя

    $sql = "UPDATE tasks SET title = ?, status = ? WHERE id = ? AND user_id = ?"; //Текст для обращения к бд с просьбой обновления статуса и проверки id и user_id
    $stmt = $pdo->prepare($sql); //Подготовка
    $stmt->execute([$title, $status, $id, $user_id]); //Выполнение
}

header('Location: index.php'); //Возврат к index.php
exit; //Остановка выполнения кода