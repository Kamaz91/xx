-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 23 Kwi 2017, 16:09
-- Wersja serwera: 10.1.22-MariaDB
-- Wersja PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `mydb`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `battles`
--

CREATE TABLE `battles` (
  `ID` int(11) NOT NULL,
  `attacker` int(11) NOT NULL,
  `defender` int(11) NOT NULL,
  `region` int(11) NOT NULL,
  `attackerRounds` int(11) NOT NULL DEFAULT '0',
  `defenderRounds` int(11) NOT NULL DEFAULT '0',
  `roundTime` time NOT NULL DEFAULT '02:00:00',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `company`
--

CREATE TABLE `company` (
  `ID` int(11) NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `type` text COLLATE utf8_bin NOT NULL,
  `level` int(11) DEFAULT '1',
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `country`
--

CREATE TABLE `country` (
  `ID` int(11) NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `isocode` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `currency`
--

CREATE TABLE `currency` (
  `usrid` int(11) NOT NULL,
  `gold` int(11) NOT NULL DEFAULT '0',
  `pln` int(11) NOT NULL DEFAULT '0',
  `usd` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `items`
--

CREATE TABLE `items` (
  `usrid` int(11) NOT NULL,
  `grain` int(11) NOT NULL DEFAULT '0',
  `foodq1` int(11) NOT NULL DEFAULT '0',
  `foodq2` int(11) NOT NULL DEFAULT '0',
  `foodq3` int(11) NOT NULL DEFAULT '0',
  `foodq4` int(11) NOT NULL DEFAULT '0',
  `foodq5` int(11) NOT NULL DEFAULT '0',
  `chemicals` int(11) NOT NULL DEFAULT '0',
  `medkitq1` int(11) NOT NULL DEFAULT '0',
  `medkitq2` int(11) NOT NULL DEFAULT '0',
  `medkitq3` int(11) NOT NULL DEFAULT '0',
  `medkitq4` int(11) NOT NULL DEFAULT '0',
  `medkitq5` int(11) NOT NULL DEFAULT '0',
  `iron` int(11) NOT NULL DEFAULT '0',
  `weaponq1` int(11) NOT NULL DEFAULT '0',
  `weaponq2` int(11) NOT NULL DEFAULT '0',
  `weaponq3` int(11) NOT NULL DEFAULT '0',
  `weaponq4` int(11) NOT NULL DEFAULT '0',
  `weaponq5` int(11) NOT NULL DEFAULT '0',
  `oil` int(11) NOT NULL DEFAULT '0',
  `ticketq1` int(11) NOT NULL DEFAULT '0',
  `ticketq2` int(11) NOT NULL DEFAULT '0',
  `ticketq3` int(11) NOT NULL DEFAULT '0',
  `ticketq4` int(11) NOT NULL DEFAULT '0',
  `ticketq5` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `jobOffers`
--

CREATE TABLE `jobOffers` (
  `ID` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `salary` double NOT NULL,
  `currency` text COLLATE utf8_bin NOT NULL,
  `skill` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `modules`
--

CREATE TABLE `modules` (
  `ID` int(10) NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `modules`
--

INSERT INTO `modules` (`ID`, `name`, `enabled`) VALUES
(1, 'login', 1),
(2, 'register', 1),
(3, 'battle', 0),
(4, 'main', 1),
(8, 'stats', 1),
(10, 'company', 1),
(11, 'train', 1),
(12, 'createCompany', 1),
(13, 'myCompanies', 1),
(14, 'postJobOffer', 1),
(15, 'jobMarket', 1),
(16, 'applyForWork', 1),
(17, 'work', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` text COLLATE utf8_bin NOT NULL,
  `author` int(11) NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `settings`
--

CREATE TABLE `settings` (
  `ID` int(11) NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `settings`
--

INSERT INTO `settings` (`ID`, `name`, `value`) VALUES
(1, 'day', '1'),
(2, 'maintenance', '0'),
(4, 'currencyTypes', 'gold,usd,pln'),
(5, 'companyTypesRaw', 'iron,grain,oil,chemicals'),
(6, 'companyTypesProduce', 'weapon,food,ticket,medkit');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `shouts`
--

CREATE TABLE `shouts` (
  `ID` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `ID` bigint(255) NOT NULL,
  `nick` text COLLATE utf8_bin NOT NULL,
  `email` text COLLATE utf8_bin NOT NULL,
  `pass` text COLLATE utf8_bin NOT NULL,
  `day` int(255) NOT NULL,
  `usrgroup` int(2) NOT NULL DEFAULT '1',
  `country` int(11) NOT NULL,
  `xp` int(11) NOT NULL DEFAULT '0',
  `lvl` int(11) NOT NULL DEFAULT '1',
  `eco` double NOT NULL DEFAULT '1',
  `str` int(11) NOT NULL DEFAULT '100',
  `food` int(11) NOT NULL DEFAULT '10',
  `med` int(11) NOT NULL DEFAULT '10',
  `damage` bigint(20) NOT NULL DEFAULT '0',
  `company` int(11) DEFAULT NULL,
  `mu` int(11) DEFAULT NULL,
  `work` tinyint(1) NOT NULL DEFAULT '0',
  `train` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `battles`
--
ALTER TABLE `battles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`usrid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`usrid`);

--
-- Indexes for table `jobOffers`
--
ALTER TABLE `jobOffers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `shouts`
--
ALTER TABLE `shouts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `battles`
--
ALTER TABLE `battles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `company`
--
ALTER TABLE `company`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `country`
--
ALTER TABLE `country`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `jobOffers`
--
ALTER TABLE `jobOffers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `modules`
--
ALTER TABLE `modules`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT dla tabeli `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `settings`
--
ALTER TABLE `settings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT dla tabeli `shouts`
--
ALTER TABLE `shouts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `ID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
