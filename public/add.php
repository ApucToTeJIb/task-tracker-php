<?php

session_start(); //Привязка к сессии
require_once 'db.php'; //Настройка на бд

if (isset($_POST['title']) && !empty($_POST['title'])) { //Проверка не пустое ли поле
    $title = $_POST['title']; //Присваивание данных в переменную

        if (empty(trim($title))) {
        $_SESSION['error'] = "Название задачи не может быть пустым";
        header('Location: index.php');
        exit;
    } //Проверка на заполнение пустоты через пробелы

    $description = $_POST['description'] ?? '';
    $executor_id = $_POST['executor_id'] ?? null;

    $sql = "INSERT INTO tasks (title, description, author_id, executor_id, status) VALUES (?, ?, ?, ?, 'Новая')"; //Подготовка команды для обращения к бд
    $stmt = $pdo->prepare($sql); //Подготовка
    $stmt->execute([$title, $description, $_SESSION['user_id'], $executor_id]); //Выполнение отправки данных в бд
}
header('Location: index.php'); //Возврат обратно в index.php
exit;