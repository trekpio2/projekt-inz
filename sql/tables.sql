-- --------------------------------------------------------
-- Host:                         localhost
-- Wersja serwera:               8.0.30 - MySQL Community Server - GPL
-- Serwer OS:                    Win64
-- HeidiSQL Wersja:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Zrzut struktury tabela project.activity
CREATE TABLE IF NOT EXISTS `activity` (
  `activity_id` int NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `lights_level` int DEFAULT NULL,
  `temperature` int DEFAULT NULL,
  `planned` int DEFAULT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Eksport danych został odznaczony.

-- Zrzut struktury tabela project.animal
CREATE TABLE IF NOT EXISTS `animal` (
  `animal_id` int NOT NULL AUTO_INCREMENT,
  `animal_name` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `animal_gender` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `animal_image` varchar(50) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `species_id` int DEFAULT NULL,
  `aquarium_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  PRIMARY KEY (`animal_id`),
  KEY `FK_animal_aquarium` (`aquarium_id`),
  KEY `user_id` (`user_id`),
  KEY `spieces_id` (`species_id`) USING BTREE,
  CONSTRAINT `FK_animal_aquarium` FOREIGN KEY (`aquarium_id`) REFERENCES `aquarium` (`aquarium_id`),
  CONSTRAINT `FK_animal_species` FOREIGN KEY (`species_id`) REFERENCES `species` (`species_id`),
  CONSTRAINT `FK_animal_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Eksport danych został odznaczony.

-- Zrzut struktury tabela project.aquarium
CREATE TABLE IF NOT EXISTS `aquarium` (
  `aquarium_id` int NOT NULL AUTO_INCREMENT,
  `aquarium_name` varchar(50) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `aquarium_length` decimal(10,2) DEFAULT NULL,
  `aquarium_width` decimal(10,2) DEFAULT NULL,
  `aquarium_height` decimal(10,2) DEFAULT NULL,
  `aquarium_volume` decimal(10,2) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `activity_id` int DEFAULT NULL,
  PRIMARY KEY (`aquarium_id`),
  KEY `activity_id` (`activity_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `aquarium_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`),
  CONSTRAINT `aquarium_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Eksport danych został odznaczony.

-- Zrzut struktury tabela project.species
CREATE TABLE IF NOT EXISTS `species` (
  `species_id` int NOT NULL AUTO_INCREMENT,
  `species_name` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  PRIMARY KEY (`species_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Eksport danych został odznaczony.

-- Zrzut struktury tabela project.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `is_admin` int DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Eksport danych został odznaczony.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
