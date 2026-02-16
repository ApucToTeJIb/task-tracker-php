<?php

session_start(); //Привязка к сессии
require_once 'db.php'; //Настройка к бд

if (isset($_GET['id'])) { //Проверка параметра id
    $id = (int)$_GET['id']; //Ложит значение в $id для ? в $sql принудительно превращая данные в int (защита на всякий случай)
    $sql = "SELECT * FROM tasks WHERE id = ?"; //Текст для обращения к бд с просьбой удаления строки с нужным значением
    $stmt = $pdo->prepare($sql); //Подготовка
    $stmt->execute([$id]); //Выполнение
    $task = $stmt->fetch();

    if (!$task) {
        die("Задача не найдена");
    }

    if ($_SESSION['role'] === 'admin') {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    elseif ($_SESSION['role'] === 'manager' && $task['author_id'] == $_SESSION['user_id']) {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    else {
        die("У вас нет прав на удаление этой задачи!");
    }
}

header('Location: index.php'); //Возвращение на index.php
exit;