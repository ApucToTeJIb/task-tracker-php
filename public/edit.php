<?php

session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$task = null;

if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $_SESSION['user_id']]);
    $task = $stmt->fetch();

    if(!$task){
        die("Ошибка: Задача не найдена или у вас нет прав доступа.");
    } 
} else {
    die("ID задачи не найдено");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Чтобы на старом Internet Explorer сайт работал нормально -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование</title>
</head>
<body>
    <h3>Редактирование</h3>

    <form action="update.php" method="POST">
        <!-- Создание блока для редактирования и подтверждения изменений через update.php -->
        <input type="hidden" name="id" value="<?= $task['id'] ?>">
        <!-- Скрытая id для бд для update.php -->
        <label>Название:</label>
        <input type="text" name = "title" value="<?= htmlspecialchars($task['title']) ?>">
        <!-- Поле для того чтобы изменить название задачи -->
        <label>Статус:</label>
        <select name="status">
        <?php
        $statuses = ['В процессе', 'Выполнено'];
            foreach ($statuses as $s) {
            $sel = ($task['status'] == $s) ? 'selected' : '';
            echo "<option value='$s' $sel>$s</option>";
        }
        ?>
        </select>
        <!-- Меню с выбором статуса для задачи -->
        <button type="submit">Сохранить</button>
    </form>
    <button type="button" onclick="window.location.href='index.php'">Отмена</button>
</body>
</html>