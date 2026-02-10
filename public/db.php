<?php
$host = '127.0.1.30';
$port = '3306';
$db   = 'practice';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Чтоб не было пустого экрана при ошибке в бд
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Чтобы с бд данные брались в удобной структуре
    PDO::ATTR_EMULATE_PREPARES => false, //Защита от вредоносных SQL кодов
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
} //Тест-проверка доступа бд
?>