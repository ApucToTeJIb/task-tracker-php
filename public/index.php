<?php

require_once 'db.php'; //Импорт файла настроенный на бд

$stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC"); //Запрос и сортировка по убыванию
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
        .task_card {background: white; padding: 15px; margin-bottom: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
        .status {color: #888; font-size: 0.9em;}
    </style>
</head>
<body>
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
        </div>
    <?php endforeach; ?>

</body>
</html>