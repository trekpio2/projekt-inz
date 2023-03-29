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
  `feed` int DEFAULT NULL,
  `filter` int DEFAULT NULL,
  `pump` int DEFAULT NULL,
  `is_planned` int DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `task_name` varchar(50) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `aquarium_id` int DEFAULT NULL,
  PRIMARY KEY (`activity_id`),
  KEY `aquarium_id` (`aquarium_id`),
  CONSTRAINT `FK_activity_aquarium` FOREIGN KEY (`aquarium_id`) REFERENCES `aquarium` (`aquarium_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Zrzucanie danych dla tabeli project.activity: ~6 rows (około)
INSERT INTO `activity` (`activity_id`, `activity_name`, `lights_level`, `temperature`, `feed`, `filter`, `pump`, `is_planned`, `start_time`, `task_name`, `aquarium_id`) VALUES
	(1, 'DAY', 10, 24.00, 1, 1, NULL, 0, '16:00:00', NULL, 1),
	(2, 'night', 0, 18.00, NULL, NULL, NULL, NULL, NULL, NULL, 1),
	(3, 'cos', 12, 24.00, NULL, NULL, NULL, NULL, NULL, NULL, 2),
	(11, 'testPlanowanej13', 62, 26.00, 1, NULL, 1, 1, '21:34:00', 'piotrek-testPlanowanej13', 1),
	(12, 'ts', 2, 2.00, NULL, NULL, NULL, NULL, '00:00:00', 'piotrek-ts', 1),
	(13, 'x', 2, 2.00, NULL, NULL, 1, 1, '22:33:00', 'piotrek-x', 1);

-- Zrzut struktury tabela project.animal
CREATE TABLE IF NOT EXISTS `animal` (
  `animal_id` int NOT NULL AUTO_INCREMENT,
  `animal_name` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `animal_gender` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `animal_image` varchar(50) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `species_name` varchar(50) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `aquarium_id` int DEFAULT NULL,
  PRIMARY KEY (`animal_id`),
  KEY `FK_animal_aquarium` (`aquarium_id`),
  CONSTRAINT `FK_animal_aquarium` FOREIGN KEY (`aquarium_id`) REFERENCES `aquarium` (`aquarium_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Zrzucanie danych dla tabeli project.animal: ~9 rows (około)
INSERT INTO `animal` (`animal_id`, `animal_name`, `animal_gender`, `animal_image`, `species_name`, `color`, `birthdate`, `aquarium_id`) VALUES
	(1, 'Axel', 'male', NULL, 'jakis', 'pink', '2023-01-22', 1),
	(2, 'lotla', 'female', NULL, 'jakis', NULL, '2023-01-22', 1),
	(3, 'testowy', 'male', NULL, 'inny', NULL, '2023-01-21', 2),
	(4, 'testowa', 'female', NULL, 'inny', NULL, '2023-01-22', 2),
	(5, 'Rex', 'female', '\\userImages\\piotrek\\animal5.PNG', 'jakis', NULL, NULL, 1),
	(17, 'Cody', 'male', '\\userImages\\piotrek\\animal17.PNG', 'taki', NULL, NULL, 2),
	(18, 'Fives', 'male', '\\userImages\\piotrek\\animal18.', 'jaks', '', NULL, 1),
	(23, 'xzcz', 'asd', '\\userImages\\piotrek\\animal23.', 'xf', 'gfg', NULL, 2),
	(24, 't', 's', '\\userImages\\piotrek\\animal24.', 's', 's', NULL, 1);

-- Zrzut struktury tabela project.aquarium
CREATE TABLE IF NOT EXISTS `aquarium` (
  `aquarium_id` int NOT NULL AUTO_INCREMENT,
  `aquarium_name` varchar(50) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `aquarium_length` decimal(10,2) DEFAULT NULL,
  `aquarium_width` decimal(10,2) DEFAULT NULL,
  `aquarium_height` decimal(10,2) DEFAULT NULL,
  `aquarium_volume` decimal(10,2) DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`aquarium_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `aquarium_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Zrzucanie danych dla tabeli project.aquarium: ~3 rows (około)
INSERT INTO `aquarium` (`aquarium_id`, `aquarium_name`, `aquarium_length`, `aquarium_width`, `aquarium_height`, `aquarium_volume`, `ip`, `user_id`) VALUES
	(1, 'akwarium1', 12.00, 12.00, 12.00, 1728.00, 'http://1.1.1.1', 1),
	(2, 'Akwarium2', 12.00, 11.20, 15.00, 1758.00, 'https://jsonplaceholder.typicode.com/users', 1),
	(4, 'test', 2.00, 5.00, 2.00, 7.00, '1.1.1.2', 1);

-- Zrzut struktury tabela project.plant
CREATE TABLE IF NOT EXISTS `plant` (
  `plant_id` int NOT NULL AUTO_INCREMENT,
  `plant_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `plant_height` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `plant_image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `species_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `aquarium_id` int DEFAULT NULL,
  PRIMARY KEY (`plant_id`),
  KEY `aquarium_id` (`aquarium_id`),
  CONSTRAINT `FK_plant_aquarium` FOREIGN KEY (`aquarium_id`) REFERENCES `aquarium` (`aquarium_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci ROW_FORMAT=DYNAMIC;

-- Zrzucanie danych dla tabeli project.plant: ~2 rows (około)
INSERT INTO `plant` (`plant_id`, `plant_name`, `plant_height`, `plant_image`, `species_name`, `color`, `aquarium_id`) VALUES
	(1, 'roslina1', '60', '\\userImages\\piotrek\\plant1.', 'jakis taki sobie', 'blue', 1),
	(2, 'r2', '4', '\\userImages\\piotrek\\plant2.', 'zxc', 'pink', 1);

-- Zrzut struktury tabela project.template
CREATE TABLE IF NOT EXISTS `template` (
  `template_id` int NOT NULL AUTO_INCREMENT,
  `template_name` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Zrzucanie danych dla tabeli project.template: ~0 rows (około)

-- Zrzut struktury tabela project.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `is_admin` int DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- Zrzucanie danych dla tabeli project.user: ~4 rows (około)
INSERT INTO `user` (`user_id`, `username`, `user_password`, `is_admin`) VALUES
	(1, 'piotrek', '123', 1),
	(2, 'adam', '321', NULL),
	(3, 'ala', 'kot', NULL),
	(4, 'ccc', 'zzz', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
