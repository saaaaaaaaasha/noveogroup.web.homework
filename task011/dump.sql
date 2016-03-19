-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 01 2014 г., 14:51
-- Версия сервера: 5.6.20
-- Версия PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yiihomework2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
`id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `id_post` int(11) unsigned NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `text`, `id_user`, `id_post`, `date`) VALUES
(2, 'Отличная новость!', 1, 1, '2014-11-01 14:50:00'),
(3, 'И ещё один комментарий к новости!', 1, 1, '2014-11-01 14:55:00'),
(4, 'Проверка проверка проверка', 2, 1, '2014-11-01 15:50:00');

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE IF NOT EXISTS `post` (
`id` int(11) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`id`, `title`, `text`, `id_user`, `date`) VALUES
(1, 'Пеллегрини не чувствует давления', 'Рулевой "Манчестер Сити" Мануэль Пеллегрини заявил, что не чувствует давления из-за последних поражений.\r\nК концу октября "горожане" уже на шесть очков отстают от лидирующего в Премьер-Лиге "Челси", а совсем недавно вылетели из Кубка Лиги. Кроме того, Сити осложнил себе жизнь в группе Лиги Чемпионов, потеряв очки в матче с ЦСКА. \r\n\r\nТем не менее, Пеллегрини не покидает уверенность, что совсем скоро "Сити" наладит свою игру. По словам чилийца, он не волнуется за свою работу после череды неудач. ', 2, '2014-11-01 00:00:00'),
(3, 'Ван Галь не завидует составу "Сити"', 'Главный тренер "Манчестер Юнайтед" Луи Ван Галь заявил, что не завидует подбору игроков, которым обладает "Манчестер Сити".', 2, '2014-11-05 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `email`) VALUES
(1, 'Sasha', 'fxl@list.ru'),
(2, 'Alexey', 'voodoo@mail.ru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_cu` (`id_user`), ADD KEY `fk_cp` (`id_post`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
 ADD PRIMARY KEY (`id`), ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comment`
--
ALTER TABLE `comment`
ADD CONSTRAINT `fk_cp` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`),
ADD CONSTRAINT `fk_cu` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `post`
--
ALTER TABLE `post`
ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
