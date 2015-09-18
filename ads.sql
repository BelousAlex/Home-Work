-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ad`;
CREATE TABLE `ad` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `otvet` varchar(20) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `ad_title` varchar(50) NOT NULL,
  `ad_description` varchar(400) NOT NULL,
  `id_city` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `ad` (`ad_id`, `id_type`, `user_name`, `email`, `otvet`, `phone`, `ad_title`, `ad_description`, `id_city`, `id_category`, `price`) VALUES
(107,	2,	'Алексей',	'fgdf@mail.ru',	'on',	'9037451213',	'Заказ машины',	'Машина на день',	6,	5,	2500);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(40) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`id_category`, `category_name`) VALUES
(1,	'-- Выберите категорию --'),
(2,	'Недвижимость'),
(3,	'Работа'),
(4,	'Продам'),
(5,	'Транспорт');

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id_city` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id_city`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `cities` (`id_city`, `city_name`) VALUES
(1,	'-- Выберите город --'),
(2,	'Луганск'),
(3,	'Днепр'),
(4,	'Харьков'),
(5,	'Киев'),
(6,	'Донецк');

DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `types` (`id_type`, `type_name`) VALUES
(1,	'Частное лицо'),
(2,	'Компания');

-- 2015-09-18 21:08:23
