<?php

session_start(); //Привязка к сессии
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); //Перекидывание на login.php если не залогинен
    exit;
}

require_once 'db.php'; //Импорт файла настроенный на бд

$sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll(); //Превращение данных в понятный массив

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Чтобы на старом Internet Explorer сайт работал нормально -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Подстраивает размер если сайт открылся на телефоне -->
    <title>Мой список задач</title>
    <style>
        body {font-family: sans-serif; background: #f4f4f4; padding: 20px;}
        .task-card {background: white; padding: 15px; margin-bottom: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
        .status {color: #888; font-size: 0.9em;}
    </style>
</head>
<body>
    <h3>Вы вошли как <?= $_SESSION['login'] ?></h3>
    <h1>Список дел от куратора</h1>

    <form action="add.php" method="POST" style="margin-bottom: 20px">
        <!-- Для кнопки будет действовать add.php, а метод post чтобы в URL не всплывали вводжимые данные -->
        <input type="text" name="title" placeholder="Что нужно сделать?" required>
        <button type="submit">Добавить задачу</button>
    </form>

    <?php foreach ($tasks as $task): ?>
        <div class="task-card">
            <h3><?= htmlspecialchars($task['title']) ?></h3>
            <p class="status">Статус: <?= htmlspecialchars($task['status']) ?></p>
            <!-- Отобажает для html наименование и статус -->
            <a href="delete.php?id=<?= $task['id'] ?>" style="color: red;">Удалить</a>
            <a href="edit.php?id=<?= $task['id'] ?>" style="color: blue;">Изменить</a>
            <!-- Кнопки для удаления и изменения -->
        </div>
    <?php endforeach; ?>

</body>
</html>