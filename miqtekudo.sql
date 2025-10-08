-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 08 okt 2025 kl 14:54
-- Serverversion: 10.4.32-MariaDB
-- PHP-version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `miqtekudo`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `comment_event`
--

CREATE TABLE `comment_event` (
  `id_comment` int(11) NOT NULL,
  `ideve_comment` int(11) NOT NULL,
  `idpub_comment` int(11) NOT NULL,
  `iduse_comment` int(11) NOT NULL,
  `text_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `comment_event`
--

INSERT INTO `comment_event` (`id_comment`, `ideve_comment`, `idpub_comment`, `iduse_comment`, `text_comment`) VALUES
(4, 1, 2, 1, 'Glad!'),
(5, 1, 2, 2, ':c'),
(6, 1, 2, 1, 'Oh man!!');

-- --------------------------------------------------------

--
-- Tabellstruktur `confirm_event`
--

CREATE TABLE `confirm_event` (
  `id_conf` int(11) NOT NULL,
  `eveid_conf` int(11) NOT NULL,
  `useid_conf` int(11) NOT NULL,
  `situation_conf` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `confirm_event`
--

INSERT INTO `confirm_event` (`id_conf`, `eveid_conf`, `useid_conf`, `situation_conf`) VALUES
(1, 1, 1, '1'),
(2, 1, 3, '1'),
(3, 1, 2, '3');

-- --------------------------------------------------------

--
-- Tabellstruktur `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `titulo_event` varchar(200) NOT NULL,
  `dia_event` int(11) NOT NULL,
  `mes_event` int(11) NOT NULL,
  `ano_event` int(11) NOT NULL,
  `datatot_event` varchar(20) NOT NULL,
  `hora_event` varchar(20) NOT NULL,
  `place_event` varchar(200) NOT NULL,
  `desc_event` text NOT NULL,
  `creator_event` varchar(200) NOT NULL,
  `exist_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `event`
--

INSERT INTO `event` (`id_event`, `titulo_event`, `dia_event`, `mes_event`, `ano_event`, `datatot_event`, `hora_event`, `place_event`, `desc_event`, `creator_event`, `exist_event`) VALUES
(1, 'Cool event', 7, 12, 2025, '2025-12-7', '15:45', 'Beach', 'A cool event for us to hang out by the beach', '1', 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `publication_event`
--

CREATE TABLE `publication_event` (
  `id_pub` int(11) NOT NULL,
  `ideve_pub` int(11) NOT NULL,
  `iduse_pub` int(11) NOT NULL,
  `text_pub` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `publication_event`
--

INSERT INTO `publication_event` (`id_pub`, `ideve_pub`, `iduse_pub`, `text_pub`) VALUES
(2, 1, 3, 'Super looking forward!!'),
(3, 1, 2, 'Can\'t go, sorry :/');

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nome_user` varchar(200) NOT NULL,
  `login_user` varchar(200) NOT NULL,
  `apel_user` varchar(200) NOT NULL,
  `senha_user` text NOT NULL,
  `photo_user` text NOT NULL,
  `visit_user` varchar(200) NOT NULL,
  `code_user` varchar(200) NOT NULL,
  `senhamd5false_user` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`id_user`, `nome_user`, `login_user`, `apel_user`, `senha_user`, `photo_user`, `visit_user`, `code_user`, `senhamd5false_user`) VALUES
(1, 'Jean Jerrad', 'jeanjerrad', 'jeanow', '25f9e794323b453885f5181f1b624d0b', '287151980.png', '1', 'asdas8d7asd9ay8fa89s78asd', ''),
(2, 'Test 1', 'teste1', '', '7077cc5dbb52990dd754663304b672a8', '899660030.png', '1', 'vtHsGXQJC9', 'HvjPRa'),
(3, 'John Doe', 'john_doe', '', '750a0d64173db2d7d5bb3abefd80edca', '879778239.png', '1', '%utMmxgX#Y', 's40RLK');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `comment_event`
--
ALTER TABLE `comment_event`
  ADD PRIMARY KEY (`id_comment`);

--
-- Index för tabell `confirm_event`
--
ALTER TABLE `confirm_event`
  ADD PRIMARY KEY (`id_conf`);

--
-- Index för tabell `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`);

--
-- Index för tabell `publication_event`
--
ALTER TABLE `publication_event`
  ADD PRIMARY KEY (`id_pub`);

--
-- Index för tabell `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `comment_event`
--
ALTER TABLE `comment_event`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT för tabell `confirm_event`
--
ALTER TABLE `confirm_event`
  MODIFY `id_conf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `publication_event`
--
ALTER TABLE `publication_event`
  MODIFY `id_pub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
