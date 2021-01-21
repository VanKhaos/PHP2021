-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               10.4.14-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Exportiere Datenbank Struktur für rentmobil
CREATE DATABASE IF NOT EXISTS `rentmobil` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `rentmobil`;

-- Exportiere Struktur von Tabelle rentmobil.fahrzeug
CREATE TABLE IF NOT EXISTS `fahrzeug` (
  `kennzeichen` char(13) NOT NULL,
  `hersteller` varchar(50) NOT NULL,
  `typ` varchar(50) NOT NULL,
  `kilometerstand` int(11) NOT NULL DEFAULT 0,
  `zulassungsdatum` date NOT NULL,
  PRIMARY KEY (`kennzeichen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle rentmobil.kunde
CREATE TABLE IF NOT EXISTS `kunde` (
  `kundennummer` int(11) NOT NULL,
  `nachname` varchar(100) NOT NULL DEFAULT '',
  `vorname` varchar(100) NOT NULL DEFAULT '',
  `geburtsdatum` date DEFAULT NULL,
  `fuehrerscheinklasse` char(50) DEFAULT NULL,
  PRIMARY KEY (`kundennummer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle rentmobil.vertrag
CREATE TABLE IF NOT EXISTS `vertrag` (
  `vertragsnummer` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `ende` datetime NOT NULL,
  `gefahrene_kilometer` int(11) NOT NULL,
  `vertragsabschluss` datetime NOT NULL,
  PRIMARY KEY (`vertragsnummer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
