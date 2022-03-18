-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 17 2020 г., 12:23
-- Версия сервера: 5.6.38
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kimsu`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authlog`
--

CREATE TABLE `authlog` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` bigint(20) UNSIGNED NOT NULL,
  `key` text NOT NULL,
  `time` bigint(11) NOT NULL,
  `lasttime` bigint(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `ua` varchar(250) NOT NULL,
  `attempts` int(11) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forgot`
--

CREATE TABLE `forgot` (
  `id` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sess` varchar(5000) NOT NULL,
  `time` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `guest`
--

CREATE TABLE `guest` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `user` varchar(15) NOT NULL,
  `text` varchar(2500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `guests`
--

CREATE TABLE `guests` (
  `id` int(18) UNSIGNED NOT NULL,
  `ip` varchar(1024) NOT NULL DEFAULT '0',
  `browser` varchar(1024) NOT NULL DEFAULT '0',
  `time` varchar(1024) NOT NULL,
  `url` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `logs_money`
--

CREATE TABLE `logs_money` (
  `id` int(255) NOT NULL,
  `id_user` int(11) DEFAULT '0',
  `type` enum('plus','minus') DEFAULT 'plus',
  `count` decimal(11,2) DEFAULT '0.00',
  `action` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `loto`
--

CREATE TABLE `loto` (
  `id` int(11) NOT NULL,
  `idu` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mail`
--

CREATE TABLE `mail` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `who` int(11) NOT NULL,
  `text` text NOT NULL,
  `time` int(11) NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mgr_sessions`
--

CREATE TABLE `mgr_sessions` (
  `id` int(15) NOT NULL,
  `key_auth` varchar(32) NOT NULL,
  `id_user` int(15) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `time` int(64) NOT NULL,
  `ua` varchar(1024) NOT NULL,
  `id_enter` int(15) NOT NULL,
  `activ` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `name` text NOT NULL,
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `name` text NOT NULL,
  `text` text NOT NULL,
  `readmsg` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `rek`
--

CREATE TABLE `rek` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comm` text NOT NULL,
  `url` text NOT NULL,
  `color` text NOT NULL,
  `clicks` int(11) NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `num` text NOT NULL,
  `pcode` int(11) NOT NULL,
  `ok` text NOT NULL,
  `gold` int(11) NOT NULL,
  `sum` int(11) NOT NULL,
  `go` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `servers`
--

CREATE TABLE `servers` (
  `id` int(11) NOT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `login` varchar(32) DEFAULT NULL,
  `pass` varchar(128) DEFAULT NULL,
  `ip_domain` varchar(64) DEFAULT NULL,
  `url_isp` varchar(64) NOT NULL,
  `ispver` int(1) NOT NULL DEFAULT '5'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `name` varchar(60) NOT NULL,
  `value` varchar(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tarifs_hosting`
--

CREATE TABLE `tarifs_hosting` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `template` varchar(64) DEFAULT NULL,
  `panel` varchar(32) DEFAULT NULL,
  `hdd` varchar(128) DEFAULT NULL,
  `trafic` varchar(32) DEFAULT NULL,
  `domain` int(11) DEFAULT '0',
  `ftp` int(11) DEFAULT '0',
  `mail` int(11) DEFAULT '0',
  `mysql` int(11) DEFAULT '0',
  `ram` varchar(32) DEFAULT NULL,
  `cpu` varchar(32) DEFAULT NULL,
  `cpu_user` varchar(32) DEFAULT NULL,
  `io` varchar(32) DEFAULT NULL,
  `price_day` decimal(11,2) DEFAULT '0.00',
  `price_week` decimal(11,2) DEFAULT '0.00',
  `price_month` decimal(11,2) DEFAULT '0.00',
  `price_year` decimal(11,2) DEFAULT '0.00',
  `activ` int(1) DEFAULT '0',
  `id_server` int(11) DEFAULT '0',
  `sort` int(3) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tgmsg`
--

CREATE TABLE `tgmsg` (
  `id` int(11) NOT NULL,
  `tg_id` int(40) NOT NULL,
  `tg_msg` varchar(1000) NOT NULL,
  `act` int(40) NOT NULL DEFAULT '1',
  `tg_files` varchar(1000) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT '0',
  `name` varchar(64) DEFAULT NULL,
  `id_kat` int(11) DEFAULT '0',
  `msg` varchar(5000) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `read_adm` int(1) DEFAULT '0',
  `read_user` int(1) DEFAULT '0',
  `close` int(1) DEFAULT '0',
  `time` int(11) DEFAULT '0',
  `time_update` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tickets_msg`
--

CREATE TABLE `tickets_msg` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `msg` text NOT NULL,
  `time` int(11) NOT NULL,
  `file` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `datereg` int(11) NOT NULL,
  `lasttime` int(11) NOT NULL,
  `login` varchar(15) NOT NULL,
  `wmr` varchar(15) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `email` varchar(35) NOT NULL,
  `admin` enum('0','1','2','3','4','5') NOT NULL,
  `ip` varchar(50) NOT NULL,
  `ua` varchar(200) NOT NULL,
  `ban` int(15) NOT NULL DEFAULT '0',
  `money` float(11,2) NOT NULL,
  `test` int(1) NOT NULL DEFAULT '2',
  `activ` enum('0','1','2','3','4','5') NOT NULL DEFAULT '1',
  `id_tarif` int(3) NOT NULL DEFAULT '1',
  `isp_login` varchar(200) NOT NULL,
  `isp_pass` varchar(200) NOT NULL,
  `tg_id` int(100) NOT NULL,
  `tg_sess` varchar(45) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `pascan` varchar(1000) NOT NULL DEFAULT '0',
  `pascan_sess` varchar(45) NOT NULL DEFAULT '0',
  `pascan_act` int(2) NOT NULL DEFAULT '1',
  `auto_pay` enum('1','2') NOT NULL DEFAULT '1',
  `time_work` int(15) NOT NULL,
  `error` int(1) NOT NULL DEFAULT '1',
  `access_cp` int(1) NOT NULL,
  `captcha` bigint(11) NOT NULL,
  `attempts` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authlog`
--
ALTER TABLE `authlog`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `forgot`
--
ALTER TABLE `forgot`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `logs_money`
--
ALTER TABLE `logs_money`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `loto`
--
ALTER TABLE `loto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `mgr_sessions`
--
ALTER TABLE `mgr_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `rek`
--
ALTER TABLE `rek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tarifs_hosting`
--
ALTER TABLE `tarifs_hosting`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tgmsg`
--
ALTER TABLE `tgmsg`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tickets_msg`
--
ALTER TABLE `tickets_msg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authlog`
--
ALTER TABLE `authlog`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `forgot`
--
ALTER TABLE `forgot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `guest`
--
ALTER TABLE `guest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `guests`
--
ALTER TABLE `guests`
  MODIFY `id` int(18) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `logs_money`
--
ALTER TABLE `logs_money`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `loto`
--
ALTER TABLE `loto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mail`
--
ALTER TABLE `mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mgr_sessions`
--
ALTER TABLE `mgr_sessions`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rek`
--
ALTER TABLE `rek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tarifs_hosting`
--
ALTER TABLE `tarifs_hosting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tgmsg`
--
ALTER TABLE `tgmsg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tickets_msg`
--
ALTER TABLE `tickets_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
