<?php

session_start(); //Привязка к сессии
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); //Перекидывание на login.php если не залогинен
    exit;
}

require_once 'db.php'; //Импорт файла настроенный на бд

if ($_SESSION['role'] === 'admin') { //Если залогинился админ
    $sql = "SELECT tasks.*,
            author.login as author_login,
            executor.login as executor_login
            FROM tasks
            LEFT JOIN users as author ON tasks.author_id = author.id
            LEFT JOIN users as executor ON tasks.executor_id = executor.id
            ORDER BY tasks.id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} elseif ($_SESSION['role'] === 'manager') { //Если залогинился менеджер
    $sql = "SELECT tasks.*,
            author.login as author_login,
            executor.login as executor_login
            FROM tasks
            LEFT JOIN users as author ON tasks.author_id = author.id
            LEFT JOIN users as executor ON tasks.executor_id = executor.id
            WHERE tasks.author_id = ?
            ORDER BY tasks.id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
} else { //Если залогинился гость
    $sql = "SELECT tasks.*,
            author.login as author_login,
            executor.login as executor_login
            FROM tasks
            LEFT JOIN users as author ON tasks.author_id = author.id
            LEFT JOIN users as executor ON tasks.executor_id = executor.id
            WHERE tasks.executor_id = ?
            ORDER BY tasks.id DESC";
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h3>Вы вошли как <?= $_SESSION['login'] ?> (<?= $_SESSION['role'] ?>)
        <a href="logout.php" style="color:red; margin-left: 20px; text-decoration: none;">Выйти</a>
    </h3>
    <h1>Список дел</h1>

    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
        <form action="add.php" method="POST" style="margin-bottom: 20px">
            <!-- Для кнопки будет действовать add.php, а метод post чтобы в URL не всплывали вводжимые данные -->
            <input type="text" name="title" placeholder="Что нужно сделать?" required><br><br>
            <textarea type="text" name="description" placeholder="Описание задачи" required></textarea><br><br>

            <?php
            $sql = "SELECT id, login, role FROM users WHERE role = 'guest' ORDER BY login";
            $stmt = $pdo->query($sql);
            $users = $stmt->fetchAll();
            ?>
            <label>Исполнитель:</label>
            <select name="executor_id">
                <option value="">-- Не назначен --</option>
                <?php foreach($users as $u): ?>
                    <option value="<?= $u['id'] ?>">
                        <?= htmlspecialchars($u['login']) ?> (<?= $u['role'] ?>)
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <button type="submit">Добавить задачу</button>
        </form>
    <?php else: ?>
        <p style="color: #666;">Вы можете только просматривать назначенные вам задачи.</p>
    <?php endif; ?>
    <div style="display: flex; gap: 20px;">
        <?php foreach ($tasksByStatus as $status => $statusTasks): ?>
            <div style="flex: 1; background: #e9ecef; padding: 15px; border-radius: 8px;">
                <h2><?= $status ?></h2>
                <?php foreach ($statusTasks as $task): ?>
                    <div class="task-card">
                        <h3><?= htmlspecialchars($task['title']) ?></h3>
                        <p><?= htmlspecialchars($task['description'] ?? '') ?></p>
                        <p class="status">Автор: <?= htmlspecialchars($task['author_login'] ?? 'Неизвестен') ?></p>
                        <p class="status">Исполнитель: <?= htmlspecialchars($task['executor_login'] ?? 'Не назначен') ?></p>
                        <p class="status">Создано: <?= date('d.m.Y H:i', strtotime($task['created_at'])) ?></p>
                        <p class="status">Изменено: <?= date('d.m.Y H:i', strtotime($task['updated_at'])) ?></p>

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