<?php

require_once 'db.php';

if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "UPDATE tasks SET status = 'Выполнено' WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;