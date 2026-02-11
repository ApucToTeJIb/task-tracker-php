<?php

require_once 'db.php';

$login = 'admin';
$password = '12345';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (login, password, role) VALUE (?, ?, 'admin')";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([$login, $hashedPassword]);
    echo "Поздравляю! Админ созда, подробнее в таблице users";
} catch (PDOException $e) {
    echo "Ошибка" . $e->getMessage();
}