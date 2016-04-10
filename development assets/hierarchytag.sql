-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 04. Apr 2016 um 00:08
-- Server-Version: 10.1.10-MariaDB
-- PHP-Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `hierarchytag`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tags`
--

INSERT INTO `tags` (`tag_id`, `title`, `description`) VALUES
(1, 'Wichtigkeit', 'wie wichtig das Ding ist'),
(2, 'wenig wichtig', 'ned so wichtig.'),
(3, 'sehr wichtig', ''),
(4, 'Dringlichkeit', 'Wie dringlich das Ding ist..'),
(5, 'wenig dringlich', 'ned so dringlich___'),
(6, 'sehr dringlich', ''),
(7, 'blubber', 'dsdsfsfd'),
(8, '1', ''),
(9, '2', ''),
(10, '3', ''),
(11, '4', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags_tags`
--

CREATE TABLE `tags_tags` (
  `id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tags_tags`
--

INSERT INTO `tags_tags` (`id`, `tag_id`, `parent_id`) VALUES
(5, 2, 1),
(6, 3, 1),
(7, 5, 4),
(8, 6, 4),
(9, 7, 2),
(10, 7, 6),
(11, 8, 2),
(12, 8, 5),
(13, 9, 3),
(14, 9, 5),
(15, 10, 2),
(16, 10, 6),
(17, 11, 3),
(18, 11, 6);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indizes für die Tabelle `tags_tags`
--
ALTER TABLE `tags_tags`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT für Tabelle `tags_tags`
--
ALTER TABLE `tags_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
