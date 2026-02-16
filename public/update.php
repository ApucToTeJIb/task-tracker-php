<?php

session_start(); //Привязка к сессии
require_once 'db.php'; //Настройка к бд

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Подтверждение POST мотодом ли прилетелиданные
    $id = (int)$_POST['id']; //Кладет значение $id для execute превращая тип данных в int
    $title = $_POST['title']; //Кладет значение title из POST для execute 
    $description = $_POST['description'];
    $status = $_POST['status']; //Так же
    $user_id = $_SESSION['user_id']; //Так же но из SESSION для подтверждения пользователя

    if (empty(trim($title))) {
        die("Название задачи не может быть пустым");
    }

    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $task = $stmt->fetch();

    if (!$task) {
        die("Задача не найдена");
    }

    if ($_SESSION['role'] === 'guest') {
        die("Гости не могут редактировать задачи!");
    }

    if ($_SESSION['role'] === 'manager' && $task['author_id'] != $user_id) {
        die("Вы можете редактировать только свои задачи!");
    }

    $sql = "UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ?"; //Текст для обращения к бд с просьбой обновления статуса и проверки id
    $stmt = $pdo->prepare($sql); //Подготовка
    $stmt->execute([$title, $description, $status, $id]); //Выполнение
}

header('Location: index.php'); //Возврат к index.php
exit; //Остановка выполнения кода