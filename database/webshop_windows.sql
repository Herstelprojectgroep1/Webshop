-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 04 mrt 2022 om 16:01
-- Serverversie: 10.4.20-MariaDB
-- PHP-versie: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `discount`
--

CREATE TABLE `discount` (
  `discountID` int(11) NOT NULL,
  `productID` int(11) DEFAULT NULL,
  `discount` int(11) NOT NULL,
  `newPrice` int(11) DEFAULT NULL,
  `beginDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `discount`
--

INSERT INTO `discount` (`discountID`, `productID`, `discount`, `newPrice`, `beginDate`, `endDate`) VALUES
(34, 21, 25, 74, '2022-03-28', '2022-03-31'),
(35, 28, 25, 224, '2022-03-28', '2022-03-31'),
(36, 21, 25, 74, '2022-03-02', '2022-03-09'),
(37, 28, 25, 224, '2022-03-02', '2022-03-09');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

CREATE TABLE `product` (
  `productID` int(11) NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `category` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`productID`, `name`, `description`, `price`, `category`) VALUES
(20, 'Roze badeend', 'Deze zeer kleine badeend is roze', 99, 'T'),
(21, 'zwarte badeend', 'Deze zeer kleine badeend is zwart', 99, 'T'),
(22, 'Gaius Kwakkus', 'Een badeend gekleed als een romein', 499, 'L'),
(23, 'Tor Bjürn Anka', 'Een badeend gekleed als een viking', 499, 'L'),
(24, 'Nero', 'Het is de romeinse keizer Nero', 399, 'M'),
(25, 'Schaap', 'Hij weet niet of hij een schaap is of een badeend', 399, 'M'),
(26, 'Badeend (standaard)', 'De standaard badeend die iedereen kent', 299, 'S'),
(27, 'groende badeend', 'deze badeend is dus groen', 299, 'S'),
(28, 'Glowie', 'Een kleine badeend die een lichtje is in het donker', 299, 'T'),
(29, 'Engeltje', 'Heilige badeend', 250, 'S');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discountID`);

--
-- Indexen voor tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `discount`
--
ALTER TABLE `discount`
  MODIFY `discountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT voor een tabel `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
