-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 27 2025 г., 08:19
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `arthub`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `UserID` int NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `UserEmail` varchar(255) DEFAULT NULL,
  `UserPassword` varchar(255) NOT NULL,
  `UserImagePath` varchar(255) DEFAULT 'Media/Pfp/default.jpg',
  `RoleID` enum('User','Admin') DEFAULT 'User',
  `UserCreationDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `UserUpdateDate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`UserID`, `UserName`, `UserEmail`, `UserPassword`, `UserImagePath`, `RoleID`, `UserCreationDate`, `UserUpdateDate`) VALUES
(1, '123', NULL, '$2y$10$CwWW61O8pQegsktqNq02Ce8kq9ZByzlLObRZAwS4QFVScRbF0ZzLe', 'uploads/cat.gif', 'User', '2025-03-27 06:58:07', NULL),
(3, '321', NULL, '$2y$10$.enl/ZvrnO7wawe68UXH5OR2AXSgWnRKChmkNUQ2vvhhVCR8K7py.', 'uploads/1648369091_2-kartinkof-club-p-ti-bolshe-ne-armyanin-mem-2.jpg', 'User', '2025-03-27 07:12:17', NULL),
(4, '1223', NULL, '$2y$10$pM2HkO96gU2fYNynartavuosyWUxX4c5/PVCUg5m6jTd3r8qVbK3a', 'uploads/doc_2025-03-11_00-20-20.gif', 'User', '2025-03-27 07:24:24', NULL),
(6, '3232', NULL, '$2y$10$.9OqxTSynYvAEt1eQZdXHuR2gTXpASmfkNcbDrAKSrf7JIkAfyTYS', 'uploads/respect100.gif', 'User', '2025-03-27 07:47:35', NULL),
(7, '1332', NULL, '$2y$10$aIJSq7FHzmz5Hb78Ga5.reURNhyG0LDiR0FQ2bsRDkF3MoXkAsK6m', 'uploads/67e4dcfad7fdc.png', 'User', '2025-03-27 08:07:06', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD UNIQUE KEY `UserEmail` (`UserEmail`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
