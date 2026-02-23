<?php

session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$task = null;

if (isset($_GET['id'])) { //Получение id задачи которое собирается редактировать пользователь
    $id = (int)$_GET['id']; //Кладем id в переменную $id для дальнейшей проверки айди в бд и превращение в цифровой тип данных
    $sql = "SELECT * FROM tasks WHERE id = ?"; //Команда для отправки на бд
    $stmt = $pdo->prepare($sql); //Подготовка команды с защитой prepare execute
    $stmt->execute([$id]); //Отправка $id для получения соответствующего id с бд через SELECT
    $task = $stmt->fetch(); //Получение через fetch и присваивание строк к $task

    if (!$task){
        die("Ошибка: Задача не найдена");
    }
    
    if ($_SESSION['role'] === 'guest') {
        die("Гости не могут редактировать задачи!");
    } //На случай если гость попытаеся изменить задачу

    if ($_SESSION['role'] === 'manager' && $task['author_id'] != $_SESSION['user_id']) {
        die("Вы можете редактировать только свои задачи!");
    } //Если менеджер попытается изменить чужую задачу
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h3>Редактирование задачи</h3>

    <form action="update.php" method="POST">
        <!-- Создание блока для редактирования и подтверждения изменений через update.php -->
        <input type="hidden" name="id" value="<?= $task['id'] ?>">
        <!-- Скрытая id для бд для update.php -->
        <label>Название:</label><br>
        <input type="text" name = "title" value="<?= htmlspecialchars($task['title']) ?>"><br>
        <!-- Поле для того чтобы изменить название задачи -->
        <label>Описание:</label><br>
        <textarea name="description" rows="4" cols="50"><?= htmlspecialchars($taskp['description'] ?? '') ?></textarea><br><br>
        <label>Статус:</label><br>
        <select name="status">
        <?php
        $statuses = ['Новая', 'В процессе', 'Выполнено'];
            foreach ($statuses as $s) {
            $sel = ($task['status'] == $s) ? 'selected' : '';
            echo "<option value='$s' $sel>$s</option>";
        }
        ?>
        </select><br><br>
        <?php
        $sql = "SELECT id, login, role FROM users WHERE role = 'guest' ORDER BY login";
        $stmt = $pdo->query($sql);
        $users = $stmt->fetchAll();
        ?>
        <label>Исполнитель:</label><br>
        <select name = "executor_id">
            <option value="">-- Не назначен --</option>
            <?php foreach($users as $u): ?>
                <option value="<?= $u['id'] ?>" <?= $task['executor_id'] == $u['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($u['login']) ?> (<?= $u['role'] ?>)
                </option>
            <?php endforeach; ?>
        </select><br><br>
        <!-- Меню с выбором статуса для задачи -->
        <button type="submit">Сохранить</button>
    </form><br>
    <button type="button" onclick="window.location.href='index.php'">Отмена</button>
</body>
</html>