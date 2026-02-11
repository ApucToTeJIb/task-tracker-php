<?php

require_once 'db.php'; //Настройка к бд

if(isset($_GET['id'])) { //Проверка параметра id
    $id = (int)$_GET['id']; //Кладет значение в $id для ? в $sql превращая тип данных в int
    $sql = "UPDATE tasks SET status = 'Выполнено' WHERE id = ?"; //Текст для обращения к бд с просьбой обновления статуса
    $stmt = $pdo->prepare($sql); //Подготовка
    $stmt->execute([$id]); //Выполнение
}

header('Location: index.php'); //Возврат к index.php
exit; //Остановка выполнения кода