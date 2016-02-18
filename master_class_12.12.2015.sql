-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 12 2015 г., 03:00
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `master_class`
--
CREATE DATABASE `master_class` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `master_class`;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `grade` varchar(20) CHARACTER SET cp1251 NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `year`, `grade`, `teacher_id`, `active`) VALUES
(1, 0, 'free', NULL, 1),
(2, 2015, 'Начальная ступень', 5, 1),
(3, 2014, 'Высшая ступень', 10, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `groups_students`
--

CREATE TABLE IF NOT EXISTS `groups_students` (
  `group_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `current` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups_students`
--

INSERT INTO `groups_students` (`group_id`, `student_id`, `current`) VALUES
(3, 11, 1),
(3, 12, 1),
(3, 2, 0),
(3, 3, 0),
(2, 2, 1),
(2, 3, 1),
(2, 28, 0),
(3, 28, 1),
(2, 11, 0),
(2, 12, 0),
(1, 11, 0),
(1, 12, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `hash`, `user_id`, `time`) VALUES
(10, '91bf96f75913c5978c2bb492a2dea9f1', 1, '2015-12-07 01:22:53'),
(11, '148a3832863743602b1e59e350236d9c', 1, '2015-12-07 01:24:33'),
(18, 'eb337e81bd434301d14d4f6241a02d3a', 1, '2015-12-12 02:57:05');

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `user_id` int(11) NOT NULL,
  `fio` varchar(80) CHARACTER SET cp1251 NOT NULL,
  `placeofliving` varchar(200) CHARACTER SET cp1251 DEFAULT NULL,
  `schoolgrade` int(11) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET cp1251 DEFAULT NULL,
  `email` varchar(40) CHARACTER SET cp1251 DEFAULT NULL,
  `school` varchar(200) CHARACTER SET cp1251 DEFAULT NULL,
  `parentfio` varchar(80) CHARACTER SET cp1251 DEFAULT NULL,
  `parentphone` varchar(15) CHARACTER SET cp1251 DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`user_id`, `fio`, `placeofliving`, `schoolgrade`, `birthdate`, `phone`, `email`, `school`, `parentfio`, `parentphone`) VALUES
(2, 'A B C', '', 0, NULL, '', '', '', '', ''),
(3, 'D E F', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'antonov_b', '', 7, NULL, '+2345-789-12-45', 'antonov_b@mail.ru', 'МОУ СОШ №56', 'Антонова Марина Андреевна', NULL),
(11, 'Дёмина Евлампия Фёдоровна', '', 0, '2001-01-02', '', '', '', '', ''),
(12, 'Голицина Хавронья Иннокентьевна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Палпатинов Роман Сергеевич\r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Тунаис Ульяна Фёдоровна\r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Хуманс Царина Чингизовна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Палпатинов Роман Сергеевич\r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Тунаис Ульяна Фёдоровна\r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Хуманс Царина Чингизовна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Палпатинов Роман Сергеевич\r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Тунаис Ульяна Фёдоровна\r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Хуманс Царина Чингизовна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Палпатинов Роман Сергеевич\r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'Тунаис Ульяна Фёдоровна\r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Хуманс Царина Чингизовна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'Палпатинов Роман Сергеевич\r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'Тунаис Ульяна Фёдоровна\r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'Хуманс Царина Чингизовна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'Кулебякина Анна Ивановна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `students_rating`
--

CREATE TABLE IF NOT EXISTS `students_rating` (
  `student_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `attendance` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `taskdate` date DEFAULT NULL,
  `taskname` varchar(50) CHARACTER SET cp1251 NOT NULL,
  `description` varchar(500) CHARACTER SET cp1251 DEFAULT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `group_id`, `taskdate`, `taskname`, `description`, `rating`) VALUES
(1, 2, '2015-12-01', 'Задания-занятьица', 'Ты помнишь, Алёша, дороги Смоленщины,\nКак шли бесконечные, злые дожди,\nКак кринки несли нам усталые женщины,\nПрижав, как детей, от дождя их к груди.', 0),
(3, 2, '2015-11-04', 'А сейчас поговорим о тегах', '&lt;b&gt;как п1оезд пассажирный&lt;/b&gt;&lt;a href=&quot;/lalala/&quot;&gt;неХаб&lt;/a&gt;', 10),
(4, 2, NULL, 'А сейчас не будем говорить о тегах', 'Теги не пройдут :((((((((((', 8),
(5, 2, '2015-09-12', 'Занятие 0', 'Шаблонное описание', 10),
(6, 2, '2015-09-19', 'Занятие 1', 'Шаблонное описание', 10),
(7, 2, '2015-09-26', 'Занятие 2', 'Шаблонное описание', 10),
(8, 2, '2015-10-03', 'Занятие 3', 'Шаблонное описание', 10),
(9, 2, '2015-10-10', 'Занятие 4', 'Шаблонное описание', 10),
(10, 2, '2015-10-17', 'Занятие 5', 'Шаблонное описание', 10),
(11, 2, '2015-10-24', 'Занятие 6', 'Шаблонное описание', 10),
(12, 2, '2015-10-31', 'Занятие 7', 'Шаблонное описание', 10),
(13, 2, '2015-11-07', 'Занятие 8', 'Шаблонное описание', 10),
(14, 2, '2015-11-14', 'Занятие 9', 'Шаблонное описание', 10),
(15, 2, '2015-11-21', 'Занятие 10', 'Шаблонное описание', 10),
(16, 2, '2015-11-28', 'Занятие 11', 'Шаблонное описание', 10),
(17, 2, '2015-12-05', 'Занятие 12', 'Шаблонное описание', 10),
(18, 2, '2015-12-12', 'Занятие 13', 'Шаблонное описание', 10),
(19, 2, '2015-12-19', 'Занятие 14', 'Шаблонное описание', 10),
(20, 2, '2015-12-26', 'Занятие 15', 'Шаблонное описание', 10),
(21, 2, '2016-01-02', 'Занятие 16', 'Шаблонное описание', 10),
(22, 2, '2016-01-09', 'Занятие 17', 'Шаблонное описание', 10),
(23, 2, '2016-01-16', 'Занятие 18', 'Шаблонное описание', 10),
(25, 2, NULL, 'Задание без даты', '', 9);

-- --------------------------------------------------------

--
-- Структура таблицы `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `user_id` int(11) NOT NULL,
  `fio` varchar(80) CHARACTER SET cp1251 NOT NULL,
  UNIQUE KEY `id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teachers`
--

INSERT INTO `teachers` (`user_id`, `fio`) VALUES
(1, 'mr. Admin'),
(4, 'Уваров Филорет Русланович'),
(5, 'Лисин Геннадий Леонидович'),
(10, 'Антонов Антон Антонович');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(40) CHARACTER SET cp1251 NOT NULL,
  `pass` varchar(40) CHARACTER SET cp1251 NOT NULL,
  `rights` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `rights`) VALUES
(1, 'admin', 'admin', 0),
(2, 'abc', 'xyz', 2),
(3, 'def', 'xyz', 2),
(4, 'uvarov_fr', 'ufr', 1),
(5, 'lisin_gl', 'lgl', 1),
(9, 'antonov_b', 'ab', 2),
(10, 'antonov_aa', 'aaa', 1),
(11, 'demina_ef', 'def', 2),
(12, 'golitsina_hi', 'ghi', 2),
(13, 'palpaeinov_ee_', 'xDUx0oQex6', 2),
(14, 'eenaie_ee_', 'g0LMeo6QL0', 2),
(15, 'eemane_ee_', 'UxQMUD6Lg6', 2),
(16, 'palpatinov_rs_', 'DQ6LeoxU0U', 2),
(17, 'tunais_uf_', 'QQLxQMLDgD', 2),
(18, 'humans_cch_', 'Mog6oDD6x0', 2),
(19, 'palpatinov_rs', 'DoD6oMMQgo', 2),
(20, 'tunais_uf', 'QQDgeoDULM', 2),
(21, 'humans_cch', 'QQDDD66MQD', 2),
(22, 'palpatinov_rs_1', '0xUQDLgeLx', 2),
(23, 'tunais_uf_1', 'gxDU0oLQoo', 2),
(24, 'humans_cch_1', 'L0QLLQgUMQ', 2),
(25, 'palpatinov_rs_2', 'oLQMe60ox6', 2),
(26, 'tunais_uf_2', 'gxLggeDgex', 2),
(27, 'humans_cch_2', '0egD0DQLQx', 2),
(28, 'kulebyakina_ai', 'LeD0ULQD0x', 2);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
