<?php

session_start(); //Привязка к сессии
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); //Перекидывание на login.php если не залогинен
    exit;
}

require_once 'db.php'; //Импорт файла настроенный на бд

if ($_SESSION['role'] === 'admin') { //Если залогинился админ
    $sql = "SELECT * FROM tasks ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} elseif ($_SESSION['role'] === 'manager') { //Если залогинился менеджер
    $sql = "SELECT * FROM tasks WHERE author_id = ? ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
} else { //Если залогинился гость
    $sql = "SELECT * FROM tasks WHERE executor_id = ? ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
}
$tasks = $stmt->fetchAll(); //Превращение данных в понятный массив

$tasksByStatus = [
    'Новая' => [],
    'В процессе' => [],
    'Выполнено' => []
]; //Кладем в $tasksByStatus 3 пустых колонки
foreach ($tasks as $task) {
    $tasksByStatus[$task['status']][] = $task;
} //Сортируем задачи по статусам из task в taskByStatus в соответствующие колонки
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
        <input type="text" name="description" placeholder="Описание" required>
        <button type="submit">Добавить задачу</button>
    </form>

    <div style="display: flex; gap: 20px;">
        <?php foreach ($tasksByStatus as $status => $statusTasks): ?>
            <div style="flex: 1; background: #e9ecef; padding: 15px; border-radius: 8px;">
                <h2><?= $status ?></h2>
                <?php foreach ($statusTasks as $task): ?>
                    <div class="task-card">
                        <h3><?= htmlspecialchars($task['title']) ?></h3>
                        <p><?= htmlspecialchars($task['description'] ?? '') ?></p>
                        <p class="status">Автор: <?= $task['author_id'] ?></p>
                        <p class="status">Исполнитель: <?= $task['executor_id'] ?></p>

                        <?php if ($_SESSION['role'] === 'admin' || ($_SESSION['role'] === 'manager' && $task['author_id'] == $_SESSION['user_id'])): ?>
                            <a href="delete.php?id=<?= $task['id'] ?>">Удалить</a>
                            <a href="edit.php?id=<?= $task['id'] ?>">Изменить</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>