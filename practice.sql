-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.0:3306
<<<<<<< HEAD
-- Время создания: Фев 23 2026 г., 15:28
=======
-- Время создания: Фев 14 2026 г., 22:17
>>>>>>> 0b8d77ae206ccd90b07fedb39e793e41b042cddb
-- Версия сервера: 8.0.44
-- Версия PHP: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `practice`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'В процессе',
  `user_id` int DEFAULT NULL,
  `executor_id` int DEFAULT NULL,
  `author_id` int DEFAULT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

<<<<<<< HEAD
--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `status`, `user_id`, `executor_id`, `author_id`, `description`, `created_at`, `updated_at`) VALUES
(78, 'Капкан', 'Новая', NULL, 7, 5, 'Взвести', '2026-02-23 15:07:02', '2026-02-23 15:07:02'),
(79, 'Задача', 'Выполнено', NULL, 8, 5, '', '2026-02-23 15:07:12', '2026-02-23 15:07:45');

=======
>>>>>>> 0b8d77ae206ccd90b07fedb39e793e41b042cddb
-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','guest') DEFAULT 'guest'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`) VALUES
<<<<<<< HEAD
(1, 'admin', '$2y$10$kmgteK3LX2pZ5PLTGAOREu9YuvDOtNe6bEzkZloB7TlF5VKoZ.7ES', 'admin'),
(5, 'manager1', '$2y$10$kmgteK3LX2pZ5PLTGAOREu9YuvDOtNe6bEzkZloB7TlF5VKoZ.7ES', 'manager'),
(6, 'manager2', '$2y$10$kmgteK3LX2pZ5PLTGAOREu9YuvDOtNe6bEzkZloB7TlF5VKoZ.7ES', 'manager'),
(7, 'guest1', '$2y$10$kmgteK3LX2pZ5PLTGAOREu9YuvDOtNe6bEzkZloB7TlF5VKoZ.7ES', 'guest'),
(8, 'guest2', '$2y$10$kmgteK3LX2pZ5PLTGAOREu9YuvDOtNe6bEzkZloB7TlF5VKoZ.7ES', 'guest');
=======
(1, 'admin', '$2y$10$kmgteK3LX2pZ5PLTGAOREu9YuvDOtNe6bEzkZloB7TlF5VKoZ.7ES', 'admin');
>>>>>>> 0b8d77ae206ccd90b07fedb39e793e41b042cddb

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
<<<<<<< HEAD
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
=======
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
>>>>>>> 0b8d77ae206ccd90b07fedb39e793e41b042cddb

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
<<<<<<< HEAD
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
=======
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
>>>>>>> 0b8d77ae206ccd90b07fedb39e793e41b042cddb
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
