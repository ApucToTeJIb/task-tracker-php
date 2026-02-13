<?php

session_start(); //Привязка к сессии
require_once 'db.php'; //Настройка к бд

if(isset($_GET['id'])) { //Проверка параметра id
    $id = (int)$_GET['id']; //Ложит значение в $id для ? в $sql принудительно превращая данные в int (защита на всякий случай)
    $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?"; //Текст для обращения к бд с просьбой удаления строки с нужным значением
    $stmt = $pdo->prepare($sql); //Подготовка
    $stmt->execute([$id, $_SESSION['user_id']]); //Выполнение
}

header('Location: index.php'); //Возвращение на index.php
exit;