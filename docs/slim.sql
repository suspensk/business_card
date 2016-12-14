-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 14 2016 г., 22:06
-- Версия сервера: 5.5.25-log
-- Версия PHP: 5.5.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `slim`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `username`, `passwordHash`) VALUES
(1, 'suspensk', '$2y$10$RuFxZKdoGLTPP7dxBG6qUeuoaj5qFUX7ePE8.FTi9pRWX1Cn.KhJG');

-- --------------------------------------------------------

--
-- Структура таблицы `attachements`
--

CREATE TABLE IF NOT EXISTS `attachements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(50) DEFAULT NULL,
  `text` text,
  `picture` varchar(50) DEFAULT NULL,
  `type` enum('book','film') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `text` text,
  `text-en` text,
  `category` int(11) DEFAULT NULL,
  `meta-description` text,
  `meta-keywords` text,
  `visible` enum('0','1') DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pages_pages` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `poems`
--

CREATE TABLE IF NOT EXISTS `poems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) DEFAULT NULL,
  `text` text,
  `num` int(11) DEFAULT NULL,
  `visible` enum('0','1') DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_poems_categories` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `poem_tag`
--

CREATE TABLE IF NOT EXISTS `poem_tag` (
  `poem` int(10) NOT NULL DEFAULT '0',
  `tag` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`poem`,`tag`),
  KEY `FK_poem_tag_tags` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` enum('book','film','human') DEFAULT NULL,
  `text` text,
  `content` text,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `source` varchar(50) DEFAULT NULL,
  `visible` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `category`, `text`, `content`, `date`, `source`, `visible`) VALUES
(1, NULL, NULL, 'z', '2016-12-14 20:01:24', NULL, NULL),
(2, NULL, NULL, 'c', '2016-12-14 20:01:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `review_attachement`
--

CREATE TABLE IF NOT EXISTS `review_attachement` (
  `review` int(11) DEFAULT NULL,
  `attachement` int(11) DEFAULT NULL,
  UNIQUE KEY `review_attachement` (`review`,`attachement`),
  KEY `FK_review_attachement_attachement` (`attachement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `review_tag`
--

CREATE TABLE IF NOT EXISTS `review_tag` (
  `review` int(10) NOT NULL DEFAULT '0',
  `tag` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`review`,`tag`),
  KEY `FK_review_tag_tags` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `text` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `FK_pages_pages` FOREIGN KEY (`parent`) REFERENCES `pages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `poems`
--
ALTER TABLE `poems`
  ADD CONSTRAINT `FK_poems_categories` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `poem_tag`
--
ALTER TABLE `poem_tag`
  ADD CONSTRAINT `FK_poem_tag_poems` FOREIGN KEY (`poem`) REFERENCES `poems` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_poem_tag_tags` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `review_attachement`
--
ALTER TABLE `review_attachement`
  ADD CONSTRAINT `FK_review_attachement_attachement` FOREIGN KEY (`attachement`) REFERENCES `attachements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_review_attachement_reviews` FOREIGN KEY (`review`) REFERENCES `reviews` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `review_tag`
--
ALTER TABLE `review_tag`
  ADD CONSTRAINT `FK_review_tag_reviews` FOREIGN KEY (`review`) REFERENCES `reviews` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_review_tag_tags` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
