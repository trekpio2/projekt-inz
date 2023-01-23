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
  `temperature` decimal(10,2) DEFAULT NULL,
  `is_planned` int DEFAULT NULL,
  `aquarium_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`activity_id`),
  KEY `aquarium_id` (`aquarium_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_activity_aquarium` FOREIGN KEY (`aquarium_id`) REFERENCES `aquarium` (`aquarium_id`),
  CONSTRAINT `FK_activity_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Zrzucanie danych dla tabeli project.activity: ~3 rows (około)
INSERT INTO `activity` (`activity_id`, `activity_name`, `lights_level`, `temperature`, `is_planned`, `aquarium_id`, `user_id`) VALUES
	(1, 'day', 10, 24.00, NULL, 1, 1),
	(2, 'night', 0, 18.00, NULL, 1, 1),
	(3, 'cos', 12, 24.00, NULL, 2, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Zrzucanie danych dla tabeli project.animal: ~7 rows (około)
INSERT INTO `animal` (`animal_id`, `animal_name`, `animal_gender`, `animal_image`, `species_id`, `aquarium_id`, `user_id`, `date_added`) VALUES
	(1, 'Axel', 'male', NULL, 1, 1, 1, '2023-01-22'),
	(2, 'lotla', 'female', NULL, 1, 1, 1, '2023-01-22'),
	(3, 'testowy', 'male', NULL, 1, 2, 1, '2023-01-21'),
	(4, 'testowa', 'female', NULL, 2, 2, 1, '2023-01-22'),
	(5, 'Rex', 'female', '\\userImages\\piotrek\\animal5.PNG', 1, 1, 1, NULL),
	(17, 'Cody', 'male', '\\userImages\\piotrek\\animal17.PNG', 1, 2, 1, NULL),
	(18, 'Fives', 'male', '\\userImages\\piotrek\\animal18.PNG', 1, 2, 1, NULL);

-- Zrzut struktury tabela project.aquarium
CREATE TABLE IF NOT EXISTS `aquarium` (
  `aquarium_id` int NOT NULL AUTO_INCREMENT,
  `aquarium_name` varchar(50) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `aquarium_length` decimal(10,2) DEFAULT NULL,
  `aquarium_width` decimal(10,2) DEFAULT NULL,
  `aquarium_height` decimal(10,2) DEFAULT NULL,
  `aquarium_volume` decimal(10,2) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`aquarium_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `aquarium_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Zrzucanie danych dla tabeli project.aquarium: ~2 rows (około)
INSERT INTO `aquarium` (`aquarium_id`, `aquarium_name`, `aquarium_length`, `aquarium_width`, `aquarium_height`, `aquarium_volume`, `user_id`) VALUES
	(1, 'akwarium1', 12.00, 12.00, 12.00, 1728.00, 1),
	(2, 'Akwarium2', 12.00, 11.20, 15.00, 1758.00, 1);

-- Zrzut struktury tabela project.species
CREATE TABLE IF NOT EXISTS `species` (
  `species_id` int NOT NULL AUTO_INCREMENT,
  `species_name` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  PRIMARY KEY (`species_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Zrzucanie danych dla tabeli project.species: ~2 rows (około)
INSERT INTO `species` (`species_id`, `species_name`) VALUES
	(1, 'jakis'),
	(2, 'inny');

-- Zrzut struktury tabela project.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `is_admin` int DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Zrzucanie danych dla tabeli project.user: ~1 rows (około)
INSERT INTO `user` (`user_id`, `username`, `user_password`, `is_admin`) VALUES
	(1, 'piotrek', '123', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
