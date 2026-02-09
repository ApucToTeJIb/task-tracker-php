<?php

require_once 'db.php';

$stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
$tasks = $stmt->fetchALL();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой список задач</title>
    <style>
        body {font-family: sans-serif; background: #f4f4f4; padding: 20px;}
        .task_card {background: white; padding: 15px; margin-bottom: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
        .status {color: #888; font-size: 0,9em;}
    </style>
</head>
<body>
    <h1>Список дел от куратора</h1>

    <?php foreach ($tasks as $task): ?>
        <div class="task-card">
            <h3><?= htmlspecialchars($task['title']) ?></h3>
            <p class="status">Статус: <?= htmlspecialchars($task['status']) ?></p>
        </div>
    <?php endforeach; ?>

</body>
</html>