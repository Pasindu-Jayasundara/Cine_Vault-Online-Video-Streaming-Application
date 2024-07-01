-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.37 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for cine_vault
CREATE DATABASE IF NOT EXISTS `cine_vault` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cine_vault`;

-- Dumping structure for table cine_vault.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `admin_status_id` int NOT NULL,
  `tmp_code` varchar(45) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `fk_admin_status1_idx` (`admin_status_id`),
  CONSTRAINT `fk_admin_status1` FOREIGN KEY (`admin_status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.admin: ~1 rows (approximately)
INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `password`, `admin_status_id`, `tmp_code`, `reg_date`) VALUES
	(1, 'Pasindu', 'Jayasundara', '123456789', 1, NULL, '2024-06-30 15:06:43');

-- Dumping structure for table cine_vault.admin_address
CREATE TABLE IF NOT EXISTS `admin_address` (
  `admin_address_id` int NOT NULL AUTO_INCREMENT,
  `line_1` text NOT NULL,
  `line_2` text NOT NULL,
  `admin_address_status_id` int NOT NULL,
  `city_id` int NOT NULL,
  `added_date` datetime NOT NULL,
  `admin_admin_id` int NOT NULL,
  PRIMARY KEY (`admin_address_id`),
  KEY `fk_admin_address_status1_idx` (`admin_address_status_id`),
  KEY `fk_admin_address_city1_idx` (`city_id`),
  KEY `fk_admin_address_admin1_idx` (`admin_admin_id`),
  CONSTRAINT `fk_admin_address_admin1` FOREIGN KEY (`admin_admin_id`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_admin_address_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `fk_admin_address_status1` FOREIGN KEY (`admin_address_status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.admin_address: ~1 rows (approximately)
INSERT INTO `admin_address` (`admin_address_id`, `line_1`, `line_2`, `admin_address_status_id`, `city_id`, `added_date`, `admin_admin_id`) VALUES
	(1, '70/1/3, george r de silva lane,', 'foreshore, colombo 13', 1, 2, '2024-06-30 15:48:02', 1);

-- Dumping structure for table cine_vault.admin_email
CREATE TABLE IF NOT EXISTS `admin_email` (
  `admin_email_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `admin_email_status_id` int NOT NULL,
  `added_date` datetime DEFAULT NULL,
  `admin_admin_id` int NOT NULL,
  PRIMARY KEY (`admin_email_id`),
  KEY `fk_admin_email_status1_idx` (`admin_email_status_id`),
  KEY `fk_admin_email_admin1_idx` (`admin_admin_id`),
  CONSTRAINT `fk_admin_email_admin1` FOREIGN KEY (`admin_admin_id`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_admin_email_status1` FOREIGN KEY (`admin_email_status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.admin_email: ~1 rows (approximately)
INSERT INTO `admin_email` (`admin_email_id`, `email`, `admin_email_status_id`, `added_date`, `admin_admin_id`) VALUES
	(1, 'pasindubathiya28@gmail.com', 1, '2024-06-30 15:48:22', 1);

-- Dumping structure for table cine_vault.admin_message
CREATE TABLE IF NOT EXISTS `admin_message` (
  `admin_message_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL COMMENT 'who send the msg',
  `status_id` int NOT NULL,
  `message` text NOT NULL,
  `date_time` datetime NOT NULL,
  `admin_admin_id` int NOT NULL,
  `message_status_message_status_id` int NOT NULL DEFAULT '2' COMMENT '1 read\n2 not read',
  PRIMARY KEY (`admin_message_id`),
  KEY `fk_admin_message_user1_idx` (`user_id`),
  KEY `fk_admin_message_status1_idx` (`status_id`),
  KEY `fk_admin_message_admin1_idx` (`admin_admin_id`),
  KEY `fk_admin_message_message_status1_idx` (`message_status_message_status_id`),
  CONSTRAINT `fk_admin_message_admin1` FOREIGN KEY (`admin_admin_id`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_admin_message_message_status1` FOREIGN KEY (`message_status_message_status_id`) REFERENCES `message_status` (`message_status_id`),
  CONSTRAINT `fk_admin_message_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_admin_message_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.admin_message: ~0 rows (approximately)

-- Dumping structure for table cine_vault.admin_mobile
CREATE TABLE IF NOT EXISTS `admin_mobile` (
  `admin_mobile_id` int NOT NULL AUTO_INCREMENT,
  `mobile` varchar(13) NOT NULL,
  `admin_mobile_status_id` int NOT NULL,
  `added_date` datetime NOT NULL,
  `admin_admin_id` int NOT NULL,
  PRIMARY KEY (`admin_mobile_id`),
  KEY `fk_admin_mobile_status1_idx` (`admin_mobile_status_id`),
  KEY `fk_admin_mobile_admin1_idx` (`admin_admin_id`),
  CONSTRAINT `fk_admin_mobile_admin1` FOREIGN KEY (`admin_admin_id`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_admin_mobile_status1` FOREIGN KEY (`admin_mobile_status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.admin_mobile: ~1 rows (approximately)
INSERT INTO `admin_mobile` (`admin_mobile_id`, `mobile`, `admin_mobile_status_id`, `added_date`, `admin_admin_id`) VALUES
	(1, '0740211671', 1, '2024-06-30 15:48:40', 1);

-- Dumping structure for table cine_vault.admin_profile_image
CREATE TABLE IF NOT EXISTS `admin_profile_image` (
  `admin_profile_img_id` int NOT NULL AUTO_INCREMENT,
  `link` text,
  `date_time` datetime DEFAULT NULL,
  `admin_admin_id` int NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`admin_profile_img_id`),
  KEY `fk_admin_profile_image_admin1_idx` (`admin_admin_id`),
  KEY `fk_admin_profile_image_status1_idx` (`status_id`),
  CONSTRAINT `fk_admin_profile_image_admin1` FOREIGN KEY (`admin_admin_id`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_admin_profile_image_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.admin_profile_image: ~1 rows (approximately)
INSERT INTO `admin_profile_image` (`admin_profile_img_id`, `link`, `date_time`, `admin_admin_id`, `status_id`) VALUES
	(1, '../admin_profile_image/admin.png', '2024-06-30 23:29:37', 1, 1);

-- Dumping structure for table cine_vault.admin_status_change
CREATE TABLE IF NOT EXISTS `admin_status_change` (
  `admin_status_change_id` int NOT NULL AUTO_INCREMENT,
  `reason` text,
  `date_time` datetime DEFAULT NULL,
  `by` int NOT NULL COMMENT 'who blocked the admin',
  `of` int NOT NULL COMMENT 'how got blocked',
  PRIMARY KEY (`admin_status_change_id`),
  KEY `fk_admin_status_change_admin1_idx` (`by`),
  KEY `fk_admin_status_change_admin2_idx` (`of`),
  CONSTRAINT `fk_admin_status_change_admin1` FOREIGN KEY (`by`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_admin_status_change_admin2` FOREIGN KEY (`of`) REFERENCES `admin` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.admin_status_change: ~0 rows (approximately)

-- Dumping structure for table cine_vault.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type_id` int NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  `code` varchar(45) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `fk_cart_user1_idx` (`user_id`),
  KEY `fk_cart_type1_idx` (`type_id`),
  KEY `fk_cart_status1_idx` (`status_id`),
  CONSTRAINT `fk_cart_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_cart_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  CONSTRAINT `fk_cart_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.cart: ~2 rows (approximately)
INSERT INTO `cart` (`cart_id`, `user_id`, `type_id`, `status_id`, `code`, `date_time`) VALUES
	(1, 1, 1, 1, '66813c2469ef8', '2024-06-30 21:05:02'),
	(2, 1, 2, 1, 'TW2024', '2024-06-30 23:27:17'),
	(3, 1, 1, 1, 'MV0002', '2024-06-30 23:57:05'),
	(4, 1, 2, 1, 'BB2024', '2024-06-30 23:57:44');

-- Dumping structure for table cine_vault.city
CREATE TABLE IF NOT EXISTS `city` (
  `id` int NOT NULL AUTO_INCREMENT,
  `city` varchar(45) DEFAULT NULL,
  `district_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_city_district1_idx` (`district_id`),
  CONSTRAINT `fk_city_district1` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.city: ~2 rows (approximately)
INSERT INTO `city` (`id`, `city`, `district_id`) VALUES
	(1, 'Maharagama', 1),
	(2, 'colombo', 1);

-- Dumping structure for table cine_vault.comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment` text,
  `date_time` datetime DEFAULT NULL,
  `type_id` int NOT NULL,
  `user_id` int NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_comment_type1_idx` (`type_id`),
  KEY `fk_comment_user1_idx` (`user_id`),
  KEY `fk_comment_status1_idx` (`status_id`),
  CONSTRAINT `fk_comment_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_comment_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  CONSTRAINT `fk_comment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.comment: ~34 rows (approximately)
INSERT INTO `comment` (`id`, `comment`, `date_time`, `type_id`, `user_id`, `code`, `status_id`) VALUES
	(1, 'A thought-provoking journey that resonated deeply', '2024-06-30 23:14:38', 1, 1, 'MV0010', 1),
	(2, 'Every scene was crafted with such attention to detail', '2024-06-30 23:14:38', 1, 1, 'MV0009', 1),
	(3, 'I can\'t wait to recommend this to all my friends', '2024-06-30 23:14:38', 1, 1, 'MV0008', 1),
	(4, 'This movie challenged my perspective and left me inspired', '2024-06-30 23:14:38', 1, 1, 'MV0007', 1),
	(5, 'The characters were so well-developed; I felt like I knew them personally', '2024-06-30 23:14:38', 1, 1, 'MV0006', 1),
	(6, 'A must-watch for anyone who loves great storytelling', '2024-06-30 23:14:38', 1, 1, 'MV0005', 1),
	(7, 'One of those rare movies that leaves a lasting impression', '2024-06-30 23:14:38', 1, 1, 'MV0004', 1),
	(8, 'The plot twists kept me guessing until the very end', '2024-06-30 23:14:38', 1, 1, 'MV0003', 1),
	(9, 'The script was sharp and witty, with memorable dialogues', '2024-06-30 23:14:38', 1, 1, 'MV0002', 1),
	(10, 'The cinematography was breathtaking', '2024-06-30 23:14:38', 1, 1, 'MV0001', 1),
	(11, 'I laughed, I cried, and I cheered. An unforgettable experience', '2024-06-30 23:14:38', 1, 1, '66814261e2bba', 1),
	(12, 'A perfect blend of action, drama, and suspense', '2024-06-30 23:14:38', 1, 1, '668140462dada', 1),
	(13, 'The soundtrack was hauntingly beautiful and perfectly suited the film', '2024-06-30 23:14:38', 1, 1, '66813c2469ef8', 1),
	(14, 'Incredible direction that brought the story to life', '2024-06-30 23:14:38', 1, 1, 'MV0009', 1),
	(15, 'A timeless classic that everyone should watch', '2024-06-30 23:14:38', 1, 1, 'MV0006', 1),
	(16, 'This movie had me thinking long after the credits rolled', '2024-06-30 23:14:38', 1, 1, 'MV0001', 1),
	(17, 'A visual spectacle! The special effects were mind-blowing', '2024-06-30 23:14:38', 1, 1, 'MV0009', 1),
	(18, 'The acting was superb; I felt every emotion the characters went through', '2024-06-30 23:14:38', 1, 1, 'MV0006', 1),
	(19, 'Brilliant storytelling that kept me on the edge of my seat', '2024-06-30 23:14:38', 1, 1, '668140462dada', 1),
	(20, 'A cinematic masterpiece! Every frame was meticulously crafted', '2024-06-30 23:14:38', 1, 1, 'MV0005', 1),
	(21, 'Couldn\'t stop talking about this series with friends', '2024-06-30 23:14:38', 2, 1, 'CH2024', 1),
	(22, 'The cliffhangers are killing me!', '2024-06-30 23:14:38', 2, 1, 'TE2024', 1),
	(23, 'A standout performance', '2024-06-30 23:14:38', 2, 1, 'WW2024', 1),
	(24, 'Perfect mix of drama and suspense', '2024-06-30 23:14:38', 2, 1, 'TB2024', 1),
	(25, 'This series made me laugh out loud and shed a tear or two', '2024-06-30 23:14:38', 2, 1, 'TM2024', 1),
	(26, 'The world-building is phenomenal', '2024-06-30 23:14:38', 2, 1, 'GoT2024', 1),
	(27, 'Fantastic chemistry among the cast', '2024-06-30 23:14:38', 2, 1, 'BB2024', 1),
	(28, 'Binge-watched this in a weekend. Worth every minute', '2024-06-30 23:14:38', 2, 1, 'TC2024', 1),
	(29, 'The writing is sharp and intelligent', '2024-06-30 23:14:38', 2, 1, 'TW2024', 1),
	(30, 'So many plot twists! Keeps you guessing', '2024-06-30 23:14:38', 2, 1, 'TW2024', 1),
	(31, 'This series tackles important themes with grace and depth', '2024-06-30 23:14:38', 2, 1, 'ST2024', 1),
	(32, 'The characters feel like old friends now', '2024-06-30 23:14:38', 2, 1, 'TW2024', 1),
	(33, 'Each episode leaves you wanting more', '2024-06-30 23:14:38', 2, 1, 'TE2024', 1),
	(34, 'Addictive! Can\'t wait for the next season', '2024-06-30 23:14:38', 2, 1, 'TM2024', 1);

-- Dumping structure for table cine_vault.content_status_change
CREATE TABLE IF NOT EXISTS `content_status_change` (
  `content_status_change_id` int NOT NULL AUTO_INCREMENT,
  `reason` text,
  `date_time` datetime DEFAULT NULL,
  `by` int NOT NULL,
  `content_type` int NOT NULL COMMENT 'movie,tv',
  `code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`content_status_change_id`),
  KEY `fk_content_status_change_admin1_idx` (`by`),
  KEY `fk_content_status_change_type1_idx` (`content_type`),
  CONSTRAINT `fk_content_status_change_admin1` FOREIGN KEY (`by`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_content_status_change_type1` FOREIGN KEY (`content_type`) REFERENCES `type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.content_status_change: ~0 rows (approximately)

-- Dumping structure for table cine_vault.content_uploaded_by
CREATE TABLE IF NOT EXISTS `content_uploaded_by` (
  `content_uploaded_by_id` int NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `by` int NOT NULL COMMENT 'uploaded by',
  `content_type` int NOT NULL COMMENT 'movie, tv',
  `code` varchar(45) DEFAULT NULL COMMENT 'code of that upload',
  PRIMARY KEY (`content_uploaded_by_id`),
  KEY `fk_content_uploaded_by_admin1_idx` (`by`),
  KEY `fk_content_uploaded_by_type1_idx` (`content_type`),
  CONSTRAINT `fk_content_uploaded_by_admin1` FOREIGN KEY (`by`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_content_uploaded_by_type1` FOREIGN KEY (`content_type`) REFERENCES `type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.content_uploaded_by: ~0 rows (approximately)

-- Dumping structure for table cine_vault.country
CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int NOT NULL AUTO_INCREMENT,
  `country` varchar(45) DEFAULT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`country_id`),
  KEY `fk_country_status1_idx` (`status_id`),
  CONSTRAINT `fk_country_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.country: ~20 rows (approximately)
INSERT INTO `country` (`country_id`, `country`, `status_id`) VALUES
	(1, 'United States', 1),
	(2, 'Canada', 1),
	(3, 'United Kingdom', 1),
	(4, 'Australia', 1),
	(5, 'Germany', 1),
	(6, 'France', 1),
	(7, 'Italy', 1),
	(8, 'Spain', 1),
	(9, 'China', 1),
	(10, 'Japan', 1),
	(11, 'South Korea', 1),
	(12, 'India', 1),
	(13, 'Russia', 1),
	(14, 'Brazil', 1),
	(15, 'Mexico', 1),
	(16, 'Argentina', 1),
	(17, 'South Africa', 1),
	(18, 'Sri Lanka', 1),
	(19, 'Egypt', 1),
	(20, 'Saudi Arabia', 1);

-- Dumping structure for table cine_vault.district
CREATE TABLE IF NOT EXISTS `district` (
  `id` int NOT NULL AUTO_INCREMENT,
  `district` varchar(45) DEFAULT NULL,
  `province_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_district_province1_idx` (`province_id`),
  CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.district: ~1 rows (approximately)
INSERT INTO `district` (`id`, `district`, `province_id`) VALUES
	(1, 'Colombo', 1);

-- Dumping structure for table cine_vault.download
CREATE TABLE IF NOT EXISTS `download` (
  `download_id` int NOT NULL AUTO_INCREMENT,
  `status_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type_id` int NOT NULL DEFAULT '1',
  `code` varchar(45) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`download_id`),
  KEY `fk_download_status1_idx` (`status_id`),
  KEY `fk_download_user1_idx` (`user_id`),
  KEY `fk_download_type1_idx` (`type_id`),
  CONSTRAINT `fk_download_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_download_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  CONSTRAINT `fk_download_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.download: ~0 rows (approximately)

-- Dumping structure for table cine_vault.episode
CREATE TABLE IF NOT EXISTS `episode` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ep_number` int DEFAULT NULL,
  `tv_series_id` int NOT NULL,
  `date_time` datetime DEFAULT NULL COMMENT 'release date time',
  `url` text,
  `name` varchar(45) DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `length` time DEFAULT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_episode_tv_series1_idx` (`tv_series_id`),
  KEY `fk_episode_status1_idx` (`status_id`),
  CONSTRAINT `fk_episode_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_episode_tv_series1` FOREIGN KEY (`tv_series_id`) REFERENCES `tv_series` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.episode: ~20 rows (approximately)
INSERT INTO `episode` (`id`, `ep_number`, `tv_series_id`, `date_time`, `url`, `name`, `rating`, `length`, `status_id`) VALUES
	(1, 1, 1, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/sBEvEcpnG7k?si=Sbvlr4iB8fwzUXc1', 'Episode 1', 8.5, '00:50:00', 1),
	(2, 2, 1, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/sBEvEcpnG7k?si=LdUGmJf2ZNJezYjN', 'Episode 2', 8.7, '00:48:00', 1),
	(3, 1, 2, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/ndl1W4ltcmg?si=Xkeu76_8RWbAsqM9', 'Episode 1', 8.5, '00:50:00', 1),
	(4, 2, 2, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/kr3br-3i8TY?si=S_oOMuepkIVoh7W-', 'Episode 2', 8.7, '00:48:00', 1),
	(5, 1, 3, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/1weI6ICx-hg?si=YaeNeTL9kpFihjT2', 'Episode 1', 8.5, '00:50:00', 1),
	(6, 2, 3, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/JWtnJjn6ng0?si=sMIkC-WF6OXNUm2C', 'Episode 2', 8.7, '00:48:00', 1),
	(7, 1, 4, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/HhesaQXLuRY?si=oBHf5t-ldvqb4dLN', 'Episode 1', 8.5, '00:50:00', 1),
	(8, 2, 4, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/46l2HlRQHk8?si=MXrk61CFU91PAy-j', 'Episode 2', 8.7, '00:48:00', 1),
	(9, 1, 5, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/KPLWWIOCOOQ?si=Srq4F3bBQ2zVMxa5', 'Episode 1', 8.5, '00:50:00', 1),
	(10, 2, 5, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/LxaiuRHoOTc?si=xBDT8JgOBtFa1duE', 'Episode 2', 8.7, '00:48:00', 1),
	(11, 1, 6, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/aOC8E8z_ifw?si=AcwtaW5APnlH1rfu', 'Episode 1', 8.5, '00:50:00', 1),
	(12, 2, 6, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/eW7Twd85m2g?si=nTj_n7rxp-XbAI2l', 'Episode 2', 8.7, '00:48:00', 1),
	(13, 1, 7, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/EzFXDvC-EwM?si=xd8l2HCS1-nqGWxI', 'Episode 1', 8.5, '00:50:00', 1),
	(14, 2, 7, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/d017jvDGYrA?si=xsokpmkp7KM79r4U', 'Episode 2', 8.7, '00:48:00', 1),
	(15, 1, 8, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/9BqKiZhEFFw?si=S3XjS25F6QPyIxtf', 'Episode 1', 8.5, '00:50:00', 1),
	(16, 2, 8, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/iZjuCWEa79Y?si=ge_Yl-yCdkyS4yND', 'Episode 2', 8.7, '00:48:00', 1),
	(17, 1, 9, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/M0QwBp_da28?si=DTlIRIbUQ4LwePAb', 'Episode 1', 8.5, '00:50:00', 1),
	(18, 2, 9, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/XuqEX1PnG9I?si=WwrSXcrZ_G_xTwHi', 'Episode 2', 8.7, '00:48:00', 1),
	(19, 1, 10, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/s9APLXM9Ei8?si=XmcggCSq3WHo6yso', 'Episode 1', 8.5, '00:50:00', 1),
	(20, 2, 10, '2024-06-30 22:07:23', 'https://www.youtube.com/embed/MljytTReJ_o?si=5HvSwDTlSgdZA5Cq', 'Episode 2', 8.7, '00:48:00', 1);

-- Dumping structure for table cine_vault.episode_status_change
CREATE TABLE IF NOT EXISTS `episode_status_change` (
  `episode_status_change_id` int NOT NULL AUTO_INCREMENT,
  `reason` text,
  `date_time` datetime DEFAULT NULL,
  `by` int NOT NULL,
  `episode_id` int NOT NULL,
  `tv_series_id` int NOT NULL,
  PRIMARY KEY (`episode_status_change_id`),
  KEY `fk_episode_status_change_admin1_idx` (`by`),
  KEY `fk_episode_status_change_episode1_idx` (`episode_id`),
  KEY `fk_episode_status_change_tv_series1_idx` (`tv_series_id`),
  CONSTRAINT `fk_episode_status_change_admin1` FOREIGN KEY (`by`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_episode_status_change_episode1` FOREIGN KEY (`episode_id`) REFERENCES `episode` (`id`),
  CONSTRAINT `fk_episode_status_change_tv_series1` FOREIGN KEY (`tv_series_id`) REFERENCES `tv_series` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.episode_status_change: ~0 rows (approximately)

-- Dumping structure for table cine_vault.favourite
CREATE TABLE IF NOT EXISTS `favourite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `status_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_favourite_status1_idx` (`status_id`),
  KEY `fk_favourite_user2_idx` (`user_id`),
  KEY `fk_favourite_type2_idx` (`type_id`),
  CONSTRAINT `fk_favourite_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_favourite_type2` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  CONSTRAINT `fk_favourite_user2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.favourite: ~2 rows (approximately)
INSERT INTO `favourite` (`id`, `date_time`, `code`, `status_id`, `user_id`, `type_id`) VALUES
	(1, '2024-06-30 17:26:05', '66813c2469ef8', 1, 1, 1),
	(2, '2024-06-30 21:05:16', 'TM2024', 1, 1, 2),
	(3, '2024-06-30 23:52:29', 'BB2024', 1, 1, 2),
	(4, '2024-06-30 23:53:05', 'MV0005', 1, 1, 1),
	(5, '2024-06-30 23:56:41', '668140462dada', 1, 1, 1);

-- Dumping structure for table cine_vault.genre
CREATE TABLE IF NOT EXISTS `genre` (
  `genre_id` int NOT NULL AUTO_INCREMENT,
  `genre` varchar(45) NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`genre_id`),
  KEY `fk_genre_status1_idx` (`status_id`),
  CONSTRAINT `fk_genre_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.genre: ~19 rows (approximately)
INSERT INTO `genre` (`genre_id`, `genre`, `status_id`) VALUES
	(1, 'Drama', 1),
	(2, 'Crime', 1),
	(3, 'Science Fiction', 1),
	(4, 'Action', 1),
	(5, 'Fantasy', 1),
	(6, 'Comedy', 1),
	(7, 'Thriller', 1),
	(8, 'Horror', 1),
	(9, 'Romance', 1),
	(10, 'Documentary', 1),
	(11, 'Adventure', 1),
	(12, 'Animation', 1),
	(13, 'Mystery', 1),
	(14, 'Musical', 1),
	(15, 'Biography', 1),
	(16, 'Family', 1),
	(17, 'Historical', 1),
	(18, 'War', 1),
	(19, 'Western', 1);

-- Dumping structure for table cine_vault.language
CREATE TABLE IF NOT EXISTS `language` (
  `language_id` int NOT NULL AUTO_INCREMENT,
  `language` varchar(45) NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`language_id`),
  KEY `fk_language_status1_idx` (`status_id`),
  CONSTRAINT `fk_language_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.language: ~20 rows (approximately)
INSERT INTO `language` (`language_id`, `language`, `status_id`) VALUES
	(1, 'English', 1),
	(2, 'Spanish', 1),
	(3, 'French', 1),
	(4, 'German', 1),
	(5, 'Italian', 1),
	(6, 'Chinese', 1),
	(7, 'Japanese', 1),
	(8, 'Korean', 1),
	(9, 'Portuguese', 1),
	(10, 'Russian', 1),
	(11, 'Hindi', 1),
	(12, 'Arabic', 1),
	(13, 'Dutch', 1),
	(14, 'Greek', 1),
	(15, 'Hebrew', 1),
	(16, 'Turkish', 1),
	(17, 'Swedish', 1),
	(18, 'Norwegian', 1),
	(19, 'Danish', 1),
	(20, 'Finnish', 1);

-- Dumping structure for table cine_vault.message_status
CREATE TABLE IF NOT EXISTS `message_status` (
  `message_status_id` int NOT NULL AUTO_INCREMENT,
  `message_status` varchar(45) DEFAULT NULL COMMENT 'read ,not read',
  PRIMARY KEY (`message_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.message_status: ~0 rows (approximately)

-- Dumping structure for table cine_vault.movie
CREATE TABLE IF NOT EXISTS `movie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL COMMENT 'released',
  `description` text,
  `price` double DEFAULT NULL COMMENT 'movie price',
  `code` varchar(45) NOT NULL,
  `status_id` int NOT NULL,
  `quality_quality_id` int NOT NULL,
  `year_year_id` int NOT NULL,
  `language_language_id` int NOT NULL,
  `country_country_id` int NOT NULL,
  `rating` double DEFAULT NULL,
  `director` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`,`code`),
  KEY `fk_movie_status1_idx` (`status_id`),
  KEY `fk_movie_quality1_idx` (`quality_quality_id`),
  KEY `fk_movie_year1_idx` (`year_year_id`),
  KEY `fk_movie_language1_idx` (`language_language_id`),
  KEY `fk_movie_country1_idx` (`country_country_id`),
  CONSTRAINT `fk_movie_country1` FOREIGN KEY (`country_country_id`) REFERENCES `country` (`country_id`),
  CONSTRAINT `fk_movie_language1` FOREIGN KEY (`language_language_id`) REFERENCES `language` (`language_id`),
  CONSTRAINT `fk_movie_quality1` FOREIGN KEY (`quality_quality_id`) REFERENCES `quality` (`quality_id`),
  CONSTRAINT `fk_movie_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_movie_year1` FOREIGN KEY (`year_year_id`) REFERENCES `year` (`year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.movie: ~13 rows (approximately)
INSERT INTO `movie` (`id`, `name`, `date_time`, `description`, `price`, `code`, `status_id`, `quality_quality_id`, `year_year_id`, `language_language_id`, `country_country_id`, `rating`, `director`) VALUES
	(1, 'Hit Man', '2023-02-28 00:00:00', 'A professor moonlighting as a hit man of sorts for his city police department, descends into dangerous, dubious territory when he finds himself attracted to a woman who enlists his services.', 150, '66813c2469ef8', 1, 3, 34, 1, 2, 3.5, 'Richard Linklater'),
	(2, 'Inside Out 2', '2024-04-10 00:00:00', 'Follows Riley, in her teenage years, encountering new emotions.', 250, '668140462dada', 1, 3, 35, 1, 1, 8.5, 'Kelsey Mann'),
	(3, 'The Bikeriders', '2023-11-30 00:00:00', 'After a chance encounter, headstrong Kathy is drawn to Benny, member of Midwestern motorcycle club the Vandals. As the club transforms into a dangerous underworld of violence, Benny must choose between Kathy and his loyalty to the club.', 300, '66814261e2bba', 1, 5, 34, 1, 4, 6.5, ' Jeff Nichols'),
	(4, 'Inception', '2024-06-30 17:00:00', 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.', 10.99, 'MV0001', 1, 2, 33, 1, 1, 8.8, 'Christopher Nolan'),
	(5, 'Avatar', '2024-06-30 17:00:00', 'A paraplegic Marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.', 9.99, 'MV0002', 1, 3, 15, 1, 1, 7.8, 'James Cameron'),
	(6, 'Interstellar', '2024-06-30 17:00:00', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.', 12.99, 'MV0003', 1, 2, 20, 1, 1, 8.6, 'Christopher Nolan'),
	(7, 'The Dark Knight', '2024-06-30 17:00:00', 'When the menace known as the Joker emerges from his mysterious past, he wreaks havoc and chaos on the people of Gotham.', 11.99, 'MV0004', 1, 1, 10, 1, 1, 9, 'Christopher Nolan'),
	(8, 'Fight Club', '2024-06-30 17:00:00', 'https://i.pinimg.com/736x/84/48/0b/84480bf313c6606280325fc0c22f9a91.jpg', 8.99, 'MV0005', 1, 1, 11, 1, 1, 8.8, 'David Fincher'),
	(9, 'Forrest Gump', '2024-06-30 17:00:00', 'The presidencies of Kennedy and Johnson, the Vietnam War, the Watergate scandal and other historical events unfold from the perspective of an Alabama man with an IQ of 75.', 7.99, 'MV0006', 1, 1, 2, 1, 1, 8.8, 'Robert Zemeckis'),
	(10, 'The Matrix', '2024-06-30 17:00:00', 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.', 10.99, 'MV0007', 1, 2, 3, 1, 1, 8.7, 'Lana Wachowski, Lilly Wachowski'),
	(11, 'The Godfather', '2024-06-30 17:00:00', 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', 9.99, 'MV0008', 1, 1, 10, 1, 1, 9.2, 'Francis Ford Coppola'),
	(12, 'Gladiator', '2024-06-30 17:00:00', 'A former Roman General sets out to exact vengeance against the corrupt emperor who murdered his family and sent him into slavery.', 8.99, 'MV0009', 1, 1, 17, 1, 1, 8.5, 'Ridley Scott'),
	(13, 'Jurassic Park', '2024-06-30 17:00:00', 'During a preview tour, a theme park suffers a major power breakdown that allows its cloned dinosaur exhibits to run amok.', 7.99, 'MV0010', 1, 1, 22, 1, 1, 8.1, 'Steven Spielberg');

-- Dumping structure for table cine_vault.movie_cover
CREATE TABLE IF NOT EXISTS `movie_cover` (
  `id` int NOT NULL AUTO_INCREMENT,
  `link` text,
  `movie_id` int NOT NULL,
  `movie_code` varchar(45) NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_movie_cover_movie2_idx` (`movie_id`,`movie_code`),
  KEY `fk_movie_cover_status1_idx` (`status_id`),
  CONSTRAINT `fk_movie_cover_movie2` FOREIGN KEY (`movie_id`, `movie_code`) REFERENCES `movie` (`id`, `code`),
  CONSTRAINT `fk_movie_cover_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.movie_cover: ~13 rows (approximately)
INSERT INTO `movie_cover` (`id`, `link`, `movie_id`, `movie_code`, `status_id`) VALUES
	(1, '../images/66813c2469efb.png', 1, '66813c2469ef8', 1),
	(2, '../images/668140462dadc.png', 2, '668140462dada', 1),
	(3, '../images/66814261e2bbd.png', 3, '66814261e2bba', 1),
	(4, 'https://images8.alphacoders.com/640/640499.jpg', 4, 'MV0001', 1),
	(5, 'https://wallpapercave.com/wp/wp12520171.jpg', 5, 'MV0002', 1),
	(6, 'https://papers.co/wallpaper/papers.co-ag74-interstellar-wide-space-film-movie-art-36-3840x2400-4k-wallpaper.jpg', 6, 'MV0003', 1),
	(7, 'https://m.media-amazon.com/images/I/81AJdOIEIhL._AC_SY679_.jpg', 7, 'MV0004', 1),
	(8, 'https://m.media-amazon.com/images/I/51v5ZpFyaFL._AC_SY679_.jpg', 8, 'MV0005', 1),
	(9, 'https://c4.wallpaperflare.com/wallpaper/457/21/69/actor-comedy-drama-forrest-wallpaper-preview.jpg', 9, 'MV0006', 1),
	(10, 'https://w0.peakpx.com/wallpaper/207/763/HD-wallpaper-the-matrix-resurrections-2022-films-poster.jpg', 10, 'MV0007', 1),
	(11, 'https://images5.alphacoders.com/131/1315822.jpg', 11, 'MV0008', 1),
	(12, 'https://c4.wallpaperflare.com/wallpaper/366/756/867/movie-gladiator-wallpaper-preview.jpg', 12, 'MV0009', 1),
	(13, 'https://wallpapercave.com/wp/wp1818544.jpg', 13, 'MV0010', 1);

-- Dumping structure for table cine_vault.movie_has_genre
CREATE TABLE IF NOT EXISTS `movie_has_genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `movie_id` int NOT NULL,
  `movie_code` varchar(45) NOT NULL,
  `status_id` int NOT NULL,
  `genre_genre_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_movie_has_genre_movie1_idx` (`movie_id`,`movie_code`),
  KEY `fk_movie_has_genre_status1_idx` (`status_id`),
  KEY `fk_movie_has_genre_genre1_idx` (`genre_genre_id`),
  CONSTRAINT `fk_movie_has_genre_genre1` FOREIGN KEY (`genre_genre_id`) REFERENCES `genre` (`genre_id`),
  CONSTRAINT `fk_movie_has_genre_movie1` FOREIGN KEY (`movie_id`, `movie_code`) REFERENCES `movie` (`id`, `code`),
  CONSTRAINT `fk_movie_has_genre_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.movie_has_genre: ~13 rows (approximately)
INSERT INTO `movie_has_genre` (`id`, `movie_id`, `movie_code`, `status_id`, `genre_genre_id`) VALUES
	(1, 1, '66813c2469ef8', 1, 4),
	(2, 2, '668140462dada', 1, 12),
	(3, 3, '66814261e2bba', 1, 2),
	(4, 4, 'MV0001', 1, 1),
	(5, 5, 'MV0002', 1, 2),
	(6, 6, 'MV0003', 1, 3),
	(7, 7, 'MV0004', 1, 4),
	(8, 8, 'MV0005', 1, 5),
	(9, 9, 'MV0006', 1, 6),
	(10, 10, 'MV0007', 1, 7),
	(11, 11, 'MV0008', 1, 8),
	(12, 12, 'MV0009', 1, 9),
	(13, 13, 'MV0010', 1, 10);

-- Dumping structure for table cine_vault.movie_url
CREATE TABLE IF NOT EXISTS `movie_url` (
  `id` int NOT NULL AUTO_INCREMENT,
  `url` text,
  `movie_id` int NOT NULL,
  `lenght` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_movie_url_movie1_idx` (`movie_id`),
  CONSTRAINT `fk_movie_url_movie1` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.movie_url: ~13 rows (approximately)
INSERT INTO `movie_url` (`id`, `url`, `movie_id`, `lenght`) VALUES
	(1, 'https://www.youtube.com/embed/pAMy7IhOVQE?si=xoVmrqpFXLB_a9-B', 1, '01:30:00'),
	(2, 'https://www.youtube.com/embed/LEjhY15eCx0?si=rf266StxTj0I_o4a', 2, '01:45:00'),
	(3, 'https://www.youtube.com/embed/BrSaVt5pvPk?si=LIjt3ECpAnJa1hZW', 3, '02:30:00'),
	(4, 'https://www.youtube.com/embed/8hP9D6kZseM?si=ufanpIA3e0-WH-DZ', 4, '02:30:00'),
	(5, 'https://www.youtube.com/embed/d9MyW72ELq0?si=LwX7dzdL_8aY9Hmz', 5, '03:00:00'),
	(6, 'https://www.youtube.com/embed/zSWdZVtXT7E?si=Wb-qQOcwG_lUfVNz', 6, '03:30:00'),
	(7, 'https://www.youtube.com/embed/xGcfBRkJSWQ?si=0RBUMLxpGr5o4qZJ', 7, '03:00:00'),
	(8, 'https://www.youtube.com/embed/qtRKdVHc-cE?si=viLo2Vimx4j3G345', 8, '02:30:00'),
	(9, 'https://www.youtube.com/embed/bLvqoHBptjg?si=uacYh0JB3pbAbQki', 9, '01:30:00'),
	(10, 'https://www.youtube.com/embed/9ix7TUGVYIo?si=Onl_gxeLBmYSHr_f', 10, '03:00:00'),
	(11, 'https://www.youtube.com/embed/UaVTIH8mujA?si=6mIEndmHwAiXnz45', 11, '02:45:00'),
	(12, 'https://www.youtube.com/embed/lKn-Agk-yAI?si=vgEguJ4M2RXMHVVP', 12, '03:00:00'),
	(13, 'https://www.youtube.com/embed/fb5ELWi-ekk?si=jvQYa8ozOl48pX0f', 13, '03:30:00');

-- Dumping structure for table cine_vault.profile_image
CREATE TABLE IF NOT EXISTS `profile_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `status_id` int NOT NULL,
  `link` varbinary(100) DEFAULT '../profile_image/user.png',
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_profile_image_status1_idx` (`status_id`),
  KEY `fk_profile_image_user1_idx` (`user_id`),
  CONSTRAINT `fk_profile_image_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_profile_image_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.profile_image: ~1 rows (approximately)
INSERT INTO `profile_image` (`id`, `date_time`, `status_id`, `link`, `user_id`) VALUES
	(1, '2024-06-30 23:24:57', 1, _binary 0x2e2e2f70726f66696c655f696d6167652f757365722e706e67, 1);

-- Dumping structure for table cine_vault.promo_code
CREATE TABLE IF NOT EXISTS `promo_code` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `form` datetime DEFAULT NULL,
  `to` datetime DEFAULT NULL,
  `precentage` decimal(10,0) DEFAULT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_promo_code_status1_idx` (`status_id`),
  CONSTRAINT `fk_promo_code_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.promo_code: ~0 rows (approximately)

-- Dumping structure for table cine_vault.province
CREATE TABLE IF NOT EXISTS `province` (
  `id` int NOT NULL AUTO_INCREMENT,
  `province` varchar(45) DEFAULT NULL,
  `country_country_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_province_country1_idx` (`country_country_id`),
  CONSTRAINT `fk_province_country1` FOREIGN KEY (`country_country_id`) REFERENCES `country` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.province: ~1 rows (approximately)
INSERT INTO `province` (`id`, `province`, `country_country_id`) VALUES
	(1, 'Western', 18);

-- Dumping structure for table cine_vault.purchased_item_code
CREATE TABLE IF NOT EXISTS `purchased_item_code` (
  `purchased_item_code_id` int NOT NULL AUTO_INCREMENT,
  `purchased_item_code` varchar(45) DEFAULT NULL,
  `purchase_history_purchase_history_id` int NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`purchased_item_code_id`),
  KEY `fk_purchased_item_code_purchase_history1_idx` (`purchase_history_purchase_history_id`),
  KEY `fk_purchased_item_code_status1_idx` (`status_id`),
  CONSTRAINT `fk_purchased_item_code_purchase_history1` FOREIGN KEY (`purchase_history_purchase_history_id`) REFERENCES `purchase_history` (`purchase_history_id`),
  CONSTRAINT `fk_purchased_item_code_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.purchased_item_code: ~0 rows (approximately)

-- Dumping structure for table cine_vault.purchase_history
CREATE TABLE IF NOT EXISTS `purchase_history` (
  `purchase_history_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `promo_code_id` int DEFAULT '0',
  `price` double DEFAULT NULL,
  PRIMARY KEY (`purchase_history_id`),
  KEY `fk_purchase_history_user1_idx` (`user_id`),
  KEY `fk_purchase_history_promo_code1_idx` (`promo_code_id`),
  CONSTRAINT `fk_purchase_history_promo_code1` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_code` (`id`),
  CONSTRAINT `fk_purchase_history_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.purchase_history: ~0 rows (approximately)

-- Dumping structure for table cine_vault.quality
CREATE TABLE IF NOT EXISTS `quality` (
  `quality_id` int NOT NULL AUTO_INCREMENT,
  `quality` varchar(45) NOT NULL COMMENT 'quality types',
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`quality_id`),
  KEY `fk_quality_status1_idx` (`status_id`),
  CONSTRAINT `fk_quality_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.quality: ~7 rows (approximately)
INSERT INTO `quality` (`quality_id`, `quality`, `status_id`) VALUES
	(1, '144p', 1),
	(2, '240p', 1),
	(3, '360p', 1),
	(4, '480p', 1),
	(5, '1080p', 1),
	(6, 'UHD', 1),
	(7, '4K', 1);

-- Dumping structure for table cine_vault.reaction
CREATE TABLE IF NOT EXISTS `reaction` (
  `reaction_id` int NOT NULL AUTO_INCREMENT,
  `like` int NOT NULL DEFAULT '0' COMMENT 'number of ratings',
  `dis_like` varchar(45) DEFAULT '0',
  `status_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type_id` int NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`reaction_id`),
  KEY `fk_reaction_status1_idx` (`status_id`),
  KEY `fk_reaction_user1_idx` (`user_id`),
  KEY `fk_reaction_type1_idx` (`type_id`),
  CONSTRAINT `fk_reaction_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_reaction_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  CONSTRAINT `fk_reaction_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.reaction: ~9 rows (approximately)
INSERT INTO `reaction` (`reaction_id`, `like`, `dis_like`, `status_id`, `user_id`, `type_id`, `code`, `date_time`) VALUES
	(1, 1, '0', 1, 1, 1, 'MV0007', '2024-06-30 21:08:47'),
	(2, 1, '0', 1, 1, 1, 'MV0005', '2024-06-30 21:09:32'),
	(3, 1, '0', 1, 1, 1, 'MV0003', '2024-06-30 21:10:38'),
	(4, 1, '0', 1, 1, 1, 'MV0001', '2024-06-30 21:11:20'),
	(5, 1, '0', 1, 1, 1, 'MV0007', '2024-06-30 21:08:47'),
	(6, 1, '0', 1, 1, 2, 'TE2024', '2024-06-30 21:51:24'),
	(7, 1, '0', 1, 1, 2, 'TM2024', '2024-06-30 21:51:51'),
	(8, 1, '0', 1, 1, 2, 'BB2024', '2024-06-30 21:52:09'),
	(9, 1, '0', 1, 1, 2, 'TW2024', '2024-06-30 21:52:27');

-- Dumping structure for table cine_vault.shop
CREATE TABLE IF NOT EXISTS `shop` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `line_1` text,
  `line_2` text,
  `logo_link` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.shop: ~1 rows (approximately)
INSERT INTO `shop` (`id`, `name`, `email`, `mobile`, `line_1`, `line_2`, `logo_link`) VALUES
	(1, 'Cine Vault', 'cinevaultborwse@gmail.com', '+94740211671', '70/1/3, George R De Silva Lane,', ' Foreshore, Colombo 13', '../logo/logo.png');

-- Dumping structure for table cine_vault.shop_update
CREATE TABLE IF NOT EXISTS `shop_update` (
  `shop_update_id` int NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `admin_admin_id` int NOT NULL,
  `shop_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`shop_update_id`),
  KEY `fk_shop_update_admin1_idx` (`admin_admin_id`),
  KEY `fk_shop_update_shop1_idx` (`shop_id`),
  CONSTRAINT `fk_shop_update_admin1` FOREIGN KEY (`admin_admin_id`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_shop_update_shop1` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.shop_update: ~0 rows (approximately)

-- Dumping structure for table cine_vault.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.status: ~2 rows (approximately)
INSERT INTO `status` (`id`, `status`) VALUES
	(1, 'Active'),
	(2, 'In-Active');

-- Dumping structure for table cine_vault.subscription
CREATE TABLE IF NOT EXISTS `subscription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL COMMENT 'subscription type',
  `price` double DEFAULT NULL,
  `status_id` int NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `subscription_time_period_id` int NOT NULL,
  `download_limit` int DEFAULT NULL,
  `watch_limit` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subscription_status1_idx` (`status_id`),
  KEY `fk_subscription_subscription_time_period1_idx` (`subscription_time_period_id`),
  CONSTRAINT `fk_subscription_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_subscription_subscription_time_period1` FOREIGN KEY (`subscription_time_period_id`) REFERENCES `subscription_time_period` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.subscription: ~3 rows (approximately)
INSERT INTO `subscription` (`id`, `type`, `price`, `status_id`, `date_time`, `subscription_time_period_id`, `download_limit`, `watch_limit`) VALUES
	(1, 'Basic', 0, 1, '2024-06-30 15:43:38', 1, 0, 5),
	(2, 'Pro', 80, 1, '2024-06-30 15:44:23', 1, 10, 30),
	(3, 'Premium', 120, 1, '2024-06-30 15:44:51', 1, 30, 100);

-- Dumping structure for table cine_vault.subscription_features
CREATE TABLE IF NOT EXISTS `subscription_features` (
  `id` int NOT NULL AUTO_INCREMENT,
  `feature` text,
  `date_time` datetime DEFAULT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subscription_features_status1_idx` (`status_id`),
  CONSTRAINT `fk_subscription_features_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.subscription_features: ~24 rows (approximately)
INSERT INTO `subscription_features` (`id`, `feature`, `date_time`, `status_id`) VALUES
	(1, 'Access to a selection of classic movies.', '2024-06-30 20:58:42', 1),
	(2, 'Ad-supported viewing.', '2024-06-30 20:58:42', 1),
	(3, 'Limited offline downloads.', '2024-06-30 20:58:42', 1),
	(4, 'Access to regional content.', '2024-06-30 20:58:42', 1),
	(5, 'Access to curated playlists.', '2024-06-30 20:58:42', 1),
	(6, 'Access to documentaries.', '2024-06-30 20:58:42', 1),
	(7, 'Access to educational content.', '2024-06-30 20:58:42', 1),
	(8, 'Basic streaming quality (SD).', '2024-06-30 20:58:42', 1),
	(9, 'Access to full HD streaming.', '2024-06-30 20:58:54', 1),
	(10, 'Enhanced parental controls.', '2024-06-30 20:58:54', 1),
	(11, 'Extended trial periods for new releases.', '2024-06-30 20:58:54', 1),
	(12, 'Priority customer support.', '2024-06-30 20:58:54', 1),
	(13, 'Access to live sports events.', '2024-06-30 20:58:54', 1),
	(14, 'Access to exclusive interviews.', '2024-06-30 20:58:54', 1),
	(15, 'Ad-free viewing experience.', '2024-06-30 20:58:54', 1),
	(16, 'Offline downloads on multiple devices.', '2024-06-30 20:58:54', 1),
	(17, 'Access to exclusive behind-the-scenes content.', '2024-06-30 20:59:05', 1),
	(18, 'Access to premium live events.', '2024-06-30 20:59:05', 1),
	(19, 'Unlimited offline downloads.', '2024-06-30 20:59:05', 1),
	(20, 'Access to virtual reality content.', '2024-06-30 20:59:05', 1),
	(21, '4K Ultra HD streaming.', '2024-06-30 20:59:05', 1),
	(22, 'Access to all content without restrictions.', '2024-06-30 20:59:05', 1),
	(23, 'Early access to new releases.', '2024-06-30 20:59:05', 1),
	(24, 'Personalized content recommendations.', '2024-06-30 20:59:05', 1);

-- Dumping structure for table cine_vault.subscription_has_subscription_features
CREATE TABLE IF NOT EXISTS `subscription_has_subscription_features` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subscription_id` int NOT NULL,
  `subscription_features_id` int NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subscription_has_subscription_features_subscription_feat_idx` (`subscription_features_id`),
  KEY `fk_subscription_has_subscription_features_subscription1_idx` (`subscription_id`),
  KEY `fk_subscription_has_subscription_features_status1_idx` (`status_id`),
  CONSTRAINT `fk_subscription_has_subscription_features_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_subscription_has_subscription_features_subscription1` FOREIGN KEY (`subscription_id`) REFERENCES `subscription` (`id`),
  CONSTRAINT `fk_subscription_has_subscription_features_subscription_featur1` FOREIGN KEY (`subscription_features_id`) REFERENCES `subscription_features` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.subscription_has_subscription_features: ~24 rows (approximately)
INSERT INTO `subscription_has_subscription_features` (`id`, `subscription_id`, `subscription_features_id`, `status_id`) VALUES
	(1, 1, 1, 1),
	(2, 1, 2, 1),
	(3, 1, 3, 1),
	(4, 1, 4, 1),
	(5, 1, 5, 1),
	(6, 1, 6, 1),
	(7, 1, 7, 1),
	(8, 1, 8, 1),
	(16, 2, 9, 1),
	(17, 2, 10, 1),
	(18, 2, 11, 1),
	(19, 2, 12, 1),
	(20, 2, 13, 1),
	(21, 2, 14, 1),
	(22, 2, 15, 1),
	(23, 2, 16, 1),
	(31, 3, 17, 1),
	(32, 3, 18, 1),
	(33, 3, 19, 1),
	(34, 3, 20, 1),
	(35, 3, 21, 1),
	(36, 3, 22, 1),
	(37, 3, 23, 1),
	(38, 3, 24, 1);

-- Dumping structure for table cine_vault.subscription_time_period
CREATE TABLE IF NOT EXISTS `subscription_time_period` (
  `id` int NOT NULL AUTO_INCREMENT,
  `short_form` varchar(10) DEFAULT NULL,
  `long_form` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.subscription_time_period: ~3 rows (approximately)
INSERT INTO `subscription_time_period` (`id`, `short_form`, `long_form`) VALUES
	(1, '/M', 'Monthhly'),
	(2, '/HY', 'Half Year'),
	(3, '/Y', 'Yearly');

-- Dumping structure for table cine_vault.summary
CREATE TABLE IF NOT EXISTS `summary` (
  `summary_id` int NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `active_users` int DEFAULT NULL,
  `basic_subscription` int DEFAULT NULL,
  `pro_subscription` int DEFAULT NULL,
  `primium_subscription` int DEFAULT NULL,
  `basic_price` double DEFAULT NULL,
  `pro_price` double DEFAULT NULL,
  `primium_price` double DEFAULT NULL,
  `tv_series` int DEFAULT NULL,
  `movie` int DEFAULT NULL,
  `summary_date_summary_date_id` int NOT NULL,
  `purchase_price` double DEFAULT '0',
  PRIMARY KEY (`summary_id`),
  KEY `fk_summary_summary_date1_idx` (`summary_date_summary_date_id`),
  CONSTRAINT `fk_summary_summary_date1` FOREIGN KEY (`summary_date_summary_date_id`) REFERENCES `summary_date` (`summary_date_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.summary: ~6 rows (approximately)
INSERT INTO `summary` (`summary_id`, `created_date_time`, `active_users`, `basic_subscription`, `pro_subscription`, `primium_subscription`, `basic_price`, `pro_price`, `primium_price`, `tv_series`, `movie`, `summary_date_summary_date_id`, `purchase_price`) VALUES
	(1, '2024-06-30 18:00:00', 1000, 500, 300, 200, 9.99, 19.99, 29.99, 50, 100, 1, 1500),
	(2, '2024-06-29 17:30:00', 1200, 600, 350, 250, 10.99, 21.99, 31.99, 55, 110, 2, 1800),
	(3, '2024-06-28 16:45:00', 950, 480, 320, 180, 8.99, 17.99, 27.99, 45, 90, 3, 1400),
	(4, '2024-06-29 15:15:00', 1200, 600, 350, 250, 10.99, 21.99, 31.99, 55, 110, 4, 1800),
	(5, '2024-06-30 15:15:00', 1000, 500, 300, 200, 9.99, 19.99, 29.99, 50, 100, 5, 1500),
	(6, '2024-07-01 15:15:00', 950, 480, 320, 180, 8.99, 17.99, 27.99, 45, 90, 6, 1400);

-- Dumping structure for table cine_vault.summary_date
CREATE TABLE IF NOT EXISTS `summary_date` (
  `summary_date_id` int NOT NULL AUTO_INCREMENT,
  `summary_date` int DEFAULT NULL,
  `summary_month_summary_month_id` int NOT NULL,
  PRIMARY KEY (`summary_date_id`),
  KEY `fk_summary_date_summary_month1_idx` (`summary_month_summary_month_id`),
  CONSTRAINT `fk_summary_date_summary_month1` FOREIGN KEY (`summary_month_summary_month_id`) REFERENCES `summary_month` (`summary_month_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.summary_date: ~6 rows (approximately)
INSERT INTO `summary_date` (`summary_date_id`, `summary_date`, `summary_month_summary_month_id`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 3, 2),
	(4, 4, 4),
	(5, 5, 5),
	(6, 6, 6);

-- Dumping structure for table cine_vault.summary_month
CREATE TABLE IF NOT EXISTS `summary_month` (
  `summary_month_id` int NOT NULL AUTO_INCREMENT,
  `summary_month` int DEFAULT NULL,
  `summary_year_summary_year_id` int NOT NULL,
  PRIMARY KEY (`summary_month_id`),
  KEY `fk_summary_month_summary_year1_idx` (`summary_year_summary_year_id`),
  CONSTRAINT `fk_summary_month_summary_year1` FOREIGN KEY (`summary_year_summary_year_id`) REFERENCES `summary_year` (`summary_year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.summary_month: ~6 rows (approximately)
INSERT INTO `summary_month` (`summary_month_id`, `summary_month`, `summary_year_summary_year_id`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 3, 1),
	(4, 1, 2),
	(5, 2, 2),
	(6, 1, 3);

-- Dumping structure for table cine_vault.summary_year
CREATE TABLE IF NOT EXISTS `summary_year` (
  `summary_year_id` int NOT NULL AUTO_INCREMENT,
  `summary_year` year DEFAULT NULL,
  PRIMARY KEY (`summary_year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.summary_year: ~3 rows (approximately)
INSERT INTO `summary_year` (`summary_year_id`, `summary_year`) VALUES
	(1, '2024'),
	(2, '2023'),
	(3, '2022');

-- Dumping structure for table cine_vault.tv_series
CREATE TABLE IF NOT EXISTS `tv_series` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL COMMENT 'released',
  `description` text,
  `price` double DEFAULT NULL COMMENT 'price for that tv-series',
  `code` varchar(45) NOT NULL,
  `status_id` int NOT NULL,
  `year_year_id` int NOT NULL,
  `quality_quality_id` int NOT NULL,
  `language_language_id` int NOT NULL,
  `country_country_id` int NOT NULL,
  `rating` double DEFAULT NULL,
  `director` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`,`code`),
  KEY `fk_tv_series_status1_idx` (`status_id`),
  KEY `fk_tv_series_year1_idx` (`year_year_id`),
  KEY `fk_tv_series_quality1_idx` (`quality_quality_id`),
  KEY `fk_tv_series_language1_idx` (`language_language_id`),
  KEY `fk_tv_series_country1_idx` (`country_country_id`),
  CONSTRAINT `fk_tv_series_country1` FOREIGN KEY (`country_country_id`) REFERENCES `country` (`country_id`),
  CONSTRAINT `fk_tv_series_language1` FOREIGN KEY (`language_language_id`) REFERENCES `language` (`language_id`),
  CONSTRAINT `fk_tv_series_quality1` FOREIGN KEY (`quality_quality_id`) REFERENCES `quality` (`quality_id`),
  CONSTRAINT `fk_tv_series_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_tv_series_year1` FOREIGN KEY (`year_year_id`) REFERENCES `year` (`year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.tv_series: ~10 rows (approximately)
INSERT INTO `tv_series` (`id`, `name`, `date_time`, `description`, `price`, `code`, `status_id`, `year_year_id`, `quality_quality_id`, `language_language_id`, `country_country_id`, `rating`, `director`) VALUES
	(1, 'Stranger Things', '2024-06-30 12:00:00', 'A group of kids face supernatural forces in their town.', 29.99, 'ST2024', 1, 35, 1, 1, 1, 8.7, 'The Duffer Brothers'),
	(2, 'The Witcher', '2024-06-30 12:00:00', 'Geralt of Rivia, a monster hunter, struggles to find his place in a world where people often prove more wicked than beasts.', 34.99, 'TW2024', 1, 35, 1, 1, 1, 8.2, 'Lauren Schmidt Hissrich'),
	(3, 'The Crown', '2024-06-30 12:00:00', 'The political rivalries and romance of Queen Elizabeth II\'s reign and the events that shaped the second half of the twentieth century.', 39.99, 'TC2024', 1, 35, 1, 1, 1, 8.6, 'Peter Morgan'),
	(4, 'Breaking Bad', '2024-06-30 12:00:00', 'A high school chemistry teacher turned methamphetamine manufacturer.', 49.99, 'BB2024', 1, 35, 1, 1, 1, 9.5, 'Vince Gilligan'),
	(5, 'Game of Thrones', '2024-06-30 12:00:00', 'Nine noble families fight for control over the lands of Westeros, while an ancient enemy returns after being dormant for millennia.', 59.99, 'GoT2024', 1, 35, 1, 1, 1, 9.2, 'David Benioff, D.B. Weiss'),
	(6, 'The Mandalorian', '2024-06-30 12:00:00', 'The travels of a lone bounty hunter in the outer reaches of the galaxy, far from the authority of the New Republic.', 34.99, 'TM2024', 1, 35, 1, 1, 1, 8.8, 'Jon Favreau'),
	(7, 'The Boys', '2024-06-30 12:00:00', 'A group of vigilantes set out to take down corrupt superheroes who abuse their superpowers.', 29.99, 'TB2024', 1, 35, 1, 1, 1, 8.7, 'Eric Kripke'),
	(8, 'Westworld', '2024-06-30 12:00:00', 'Set at the intersection of the near future and the reimagined past, explore a world in which every human appetite can be indulged without consequence.', 49.99, 'WW2024', 1, 35, 1, 1, 1, 8.6, 'Jonathan Nolan, Lisa Joy'),
	(9, 'The Expanse', '2024-06-30 12:00:00', 'In the 24th century, a disparate band of antiheroes unravel a vast conspiracy that threatens the Solar System\'s fragile state of cold war.', 39.99, 'TE2024', 1, 35, 1, 1, 1, 8.5, 'Mark Fergus, Hawk Ostby'),
	(10, 'Chernobyl', '2024-06-30 12:00:00', 'A dramatization of the true story of one of the worst man-made catastrophes in history, the 1986 nuclear accident at the Chernobyl Nuclear Power Plant.', 19.99, 'CH2024', 1, 35, 1, 1, 1, 9.4, 'Craig Mazin');

-- Dumping structure for table cine_vault.tv_series_cover
CREATE TABLE IF NOT EXISTS `tv_series_cover` (
  `id` int NOT NULL AUTO_INCREMENT,
  `link` text,
  `tv_series_id` int NOT NULL,
  `tv_series_code` varchar(45) NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_tv_series_cover_tv_series1_idx` (`tv_series_id`,`tv_series_code`),
  KEY `fk_tv_series_cover_status1_idx` (`status_id`),
  CONSTRAINT `fk_tv_series_cover_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_tv_series_cover_tv_series1` FOREIGN KEY (`tv_series_id`, `tv_series_code`) REFERENCES `tv_series` (`id`, `code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.tv_series_cover: ~10 rows (approximately)
INSERT INTO `tv_series_cover` (`id`, `link`, `tv_series_id`, `tv_series_code`, `status_id`) VALUES
	(1, 'https://c4.wallpaperflare.com/wallpaper/260/579/821/stranger-things-netflix-hd-wallpaper-preview.jpg', 1, 'ST2024', 1),
	(2, 'https://w0.peakpx.com/wallpaper/774/229/HD-wallpaper-cool-netflix-the-witcher.jpg', 2, 'TW2024', 1),
	(3, 'https://c4.wallpaperflare.com/wallpaper/46/288/22/tv-show-the-crown-claire-foy-princess-margaret-wallpaper-preview.jpg', 3, 'TC2024', 1),
	(4, 'https://m.media-amazon.com/images/I/71R9eJR+tDL._AC_UF1000,1000_QL80_.jpg', 4, 'BB2024', 1),
	(5, 'https://wallpapers.com/images/featured/game-of-thrones-92acb30ilmkjbmu9.jpg', 5, 'GoT2024', 1),
	(6, 'https://w0.peakpx.com/wallpaper/42/9/HD-wallpaper-the-mandalorian-star-wars-season-3-the-mandalorian-season-3-the-mandalorian-tv-shows-star-wars.jpg', 6, 'TM2024', 1),
	(7, 'https://images4.alphacoders.com/124/1240557.jpg', 7, 'TB2024', 1),
	(8, 'https://w0.peakpx.com/wallpaper/752/444/HD-wallpaper-westworld.jpg', 8, 'WW2024', 1),
	(9, 'https://theexpanselives.com/wp-content/uploads/2019/11/expanse_S4_artwork_4K.png', 9, 'TE2024', 1),
	(10, 'https://c4.wallpaperflare.com/wallpaper/645/190/366/chernobyl-tv-series-gas-masks-group-of-people-disaster-hd-wallpaper-preview.jpg', 10, 'CH2024', 1);

-- Dumping structure for table cine_vault.tv_series_has_genre
CREATE TABLE IF NOT EXISTS `tv_series_has_genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tv_series_id` int NOT NULL,
  `tv_series_code` varchar(45) NOT NULL,
  `status_id` int NOT NULL,
  `genre_genre_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tv_series_has_genre_tv_series1_idx` (`tv_series_id`,`tv_series_code`),
  KEY `fk_tv_series_has_genre_status1_idx` (`status_id`),
  KEY `fk_tv_series_has_genre_genre1_idx` (`genre_genre_id`),
  CONSTRAINT `fk_tv_series_has_genre_genre1` FOREIGN KEY (`genre_genre_id`) REFERENCES `genre` (`genre_id`),
  CONSTRAINT `fk_tv_series_has_genre_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_tv_series_has_genre_tv_series1` FOREIGN KEY (`tv_series_id`, `tv_series_code`) REFERENCES `tv_series` (`id`, `code`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.tv_series_has_genre: ~20 rows (approximately)
INSERT INTO `tv_series_has_genre` (`id`, `tv_series_id`, `tv_series_code`, `status_id`, `genre_genre_id`) VALUES
	(1, 1, 'ST2024', 1, 1),
	(2, 1, 'ST2024', 1, 2),
	(3, 2, 'TW2024', 1, 3),
	(4, 2, 'TW2024', 1, 4),
	(5, 3, 'TC2024', 1, 5),
	(6, 3, 'TC2024', 1, 6),
	(7, 4, 'BB2024', 1, 7),
	(8, 4, 'BB2024', 1, 8),
	(9, 5, 'GoT2024', 1, 3),
	(10, 5, 'GoT2024', 1, 9),
	(11, 6, 'TM2024', 1, 10),
	(12, 6, 'TM2024', 1, 4),
	(13, 7, 'TB2024', 1, 7),
	(14, 7, 'TB2024', 1, 11),
	(15, 8, 'WW2024', 1, 10),
	(16, 8, 'WW2024', 1, 6),
	(17, 9, 'TE2024', 1, 12),
	(18, 9, 'TE2024', 1, 13),
	(19, 10, 'CH2024', 1, 5),
	(20, 10, 'CH2024', 1, 6);

-- Dumping structure for table cine_vault.type
CREATE TABLE IF NOT EXISTS `type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(15) DEFAULT NULL COMMENT 'movie or tv-series',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.type: ~2 rows (approximately)
INSERT INTO `type` (`id`, `type`) VALUES
	(1, 'Movie'),
	(2, 'Tv-Series');

-- Dumping structure for table cine_vault.upcomming_content
CREATE TABLE IF NOT EXISTS `upcomming_content` (
  `upcomming_content_id` int NOT NULL AUTO_INCREMENT,
  `content_name` varchar(45) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `date_time` datetime DEFAULT NULL COMMENT 'added date time',
  `url` text,
  `by` int NOT NULL COMMENT 'added by',
  `status_id` int NOT NULL,
  PRIMARY KEY (`upcomming_content_id`),
  KEY `fk_upcomming_content_admin1_idx` (`by`),
  KEY `fk_upcomming_content_status1_idx` (`status_id`),
  CONSTRAINT `fk_upcomming_content_admin1` FOREIGN KEY (`by`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_upcomming_content_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.upcomming_content: ~12 rows (approximately)
INSERT INTO `upcomming_content` (`upcomming_content_id`, `content_name`, `release_date`, `date_time`, `url`, `by`, `status_id`) VALUES
	(1, 'MaXXXine', '2024-07-05', '2024-06-30 16:13:07', '../upcomming/MaXXXine668136bbb711a.png', 1, 1),
	(2, 'Kill', '2024-07-08', '2024-06-30 16:15:50', '../upcomming/Kill6681375e31058.png', 1, 1),
	(3, 'Oppenheimer', '2024-07-21', '2024-06-30 12:00:00', 'https://imageservice.sky.com/pcms/3552c914-f325-11ee-afd5-6337c8f3399b/LAND_16_9?proposition=NOWTV&language=eng&versionId=f50f40c5-75ae-5a25-afb8-3f417cd4ec9b&territory=GB', 1, 1),
	(4, 'Dune: Part Two', '2024-11-03', '2024-06-30 12:00:00', 'https://images7.alphacoders.com/135/1350736.jpeg', 1, 1),
	(5, 'The Marvels', '2024-11-10', '2024-06-30 12:00:00', 'https://static1.colliderimages.com/wordpress/wp-content/uploads/2023/09/f7hwnnjx0aaqrqw.jpeg', 1, 1),
	(6, 'Aquaman and the Lost Kingdom', '2024-12-20', '2024-06-30 12:00:00', 'https://w0.peakpx.com/wallpaper/430/942/HD-wallpaper-aquaman-and-the-lost-kingdom-international-poster-aquaman-and-the-lost-kingdom-2023-movies-movies-aquaman-superheroes-jason-momoa.jpg', 1, 1),
	(7, 'Indiana Jones and the Dial of Destiny', '2024-07-28', '2024-06-30 12:00:00', 'https://bleedingcool.com/wp-content/uploads/2023/05/Fxd_-syXoAAY2bh-1200x900.jpg', 1, 1),
	(8, 'Mission: Impossible - Dead Reckoning Part One', '2024-08-11', '2024-06-30 12:00:00', 'https://images.hdqwalls.com/wallpapers/2023-mission-impossible-dead-reckoning-part-one-4k-6b.jpg', 1, 1),
	(9, 'Avatar: The Way of Water', '2024-12-17', '2024-06-30 12:00:00', 'https://eu-assets.simpleview-europe.com/peterborough/imageresizer/?image=%2Fdmsimgs%2Favatar_1__1553350993.jpg&action=ProductDetailProFullWidth', 1, 1),
	(10, 'Guardians of the Galaxy Vol. 3', '2024-05-05', '2024-06-30 12:00:00', 'https://static1.moviewebimages.com/wordpress/wp-content/uploads/2023/02/guardians-3-topper.jpg', 1, 1),
	(11, 'The Flash', '2024-06-23', '2024-06-30 12:00:00', 'https://w0.peakpx.com/wallpaper/101/761/HD-wallpaper-the-flash-2023-movie-poster.jpg', 1, 1),
	(12, 'Black Panther: Wakanda Forever', '2024-11-09', '2024-06-30 12:00:00', 'https://4kwallpapers.com/images/wallpapers/black-panther-wakanda-forever-2022-movies-marvel-comics-2560x1080-8804.jpg', 1, 1);

-- Dumping structure for table cine_vault.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  `tmp_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_status1_idx` (`status_id`),
  CONSTRAINT `fk_user_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.user: ~1 rows (approximately)
INSERT INTO `user` (`id`, `first_name`, `last_name`, `password`, `status_id`, `tmp_code`) VALUES
	(1, 'Dananji', 'Jayasundra', '123456789', 1, NULL);

-- Dumping structure for table cine_vault.user_address
CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `line_1` text,
  `line_2` text,
  `user_id` int NOT NULL,
  `status_id` int NOT NULL,
  `city_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_address_user1_idx` (`user_id`),
  KEY `fk_user_address_status1_idx` (`status_id`),
  KEY `fk_user_address_city1_idx` (`city_id`),
  CONSTRAINT `fk_user_address_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `fk_user_address_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_user_address_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.user_address: ~1 rows (approximately)
INSERT INTO `user_address` (`id`, `line_1`, `line_2`, `user_id`, `status_id`, `city_id`) VALUES
	(1, '70/1/3, george r de silva lane,', 'foreshore, colombo 13', 1, 1, 1);

-- Dumping structure for table cine_vault.user_email
CREATE TABLE IF NOT EXISTS `user_email` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `user_id` int NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_user_email_user_idx` (`user_id`),
  KEY `fk_user_email_status1_idx` (`status_id`),
  CONSTRAINT `fk_user_email_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_user_email_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.user_email: ~1 rows (approximately)
INSERT INTO `user_email` (`id`, `email`, `user_id`, `status_id`) VALUES
	(1, 'dananjisanjula1998@gmail.com', 1, 1);

-- Dumping structure for table cine_vault.user_status_change
CREATE TABLE IF NOT EXISTS `user_status_change` (
  `user_status_change` int NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `reason` text,
  `by` int NOT NULL COMMENT 'admin id',
  `of` int NOT NULL COMMENT 'user id',
  PRIMARY KEY (`user_status_change`),
  KEY `fk_user_status_change_admin1_idx` (`by`),
  KEY `fk_user_status_change_user1_idx` (`of`),
  CONSTRAINT `fk_user_status_change_admin1` FOREIGN KEY (`by`) REFERENCES `admin` (`admin_id`),
  CONSTRAINT `fk_user_status_change_user1` FOREIGN KEY (`of`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.user_status_change: ~0 rows (approximately)

-- Dumping structure for table cine_vault.user_subscription
CREATE TABLE IF NOT EXISTS `user_subscription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date_time` datetime DEFAULT NULL COMMENT 'updated date time',
  `status_id` int NOT NULL DEFAULT '1' COMMENT 'wheather this account type changed or not,\nif changed ->deactive\nnew type -> active',
  `subscription_id` int NOT NULL,
  `paid_price` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_has_account_type_user1_idx` (`user_id`),
  KEY `fk_user_has_account_type_status1_idx` (`status_id`),
  KEY `fk_user_has_account_type_subscription1_idx` (`subscription_id`),
  CONSTRAINT `fk_user_has_account_type_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_user_has_account_type_subscription1` FOREIGN KEY (`subscription_id`) REFERENCES `subscription` (`id`),
  CONSTRAINT `fk_user_has_account_type_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.user_subscription: ~1 rows (approximately)
INSERT INTO `user_subscription` (`id`, `user_id`, `date_time`, `status_id`, `subscription_id`, `paid_price`) VALUES
	(1, 1, '2024-06-30 15:45:26', 1, 1, 0);

-- Dumping structure for table cine_vault.watch
CREATE TABLE IF NOT EXISTS `watch` (
  `watch_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type_id` int NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  `code` varchar(45) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`watch_id`),
  KEY `fk_watch_user1_idx` (`user_id`),
  KEY `fk_watch_type1_idx` (`type_id`),
  KEY `fk_watch_status1_idx` (`status_id`),
  CONSTRAINT `fk_watch_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_watch_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  CONSTRAINT `fk_watch_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.watch: ~2 rows (approximately)
INSERT INTO `watch` (`watch_id`, `user_id`, `type_id`, `status_id`, `code`, `date_time`) VALUES
	(1, 1, 1, 1, 'MV0005', '2024-06-30 21:55:00'),
	(2, 1, 2, 1, 'TE2024', '2024-06-30 21:55:11');

-- Dumping structure for table cine_vault.year
CREATE TABLE IF NOT EXISTS `year` (
  `year_id` int NOT NULL AUTO_INCREMENT,
  `year` year NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`year_id`),
  KEY `fk_year_status1_idx` (`status_id`),
  CONSTRAINT `fk_year_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cine_vault.year: ~35 rows (approximately)
INSERT INTO `year` (`year_id`, `year`, `status_id`) VALUES
	(1, '1990', 1),
	(2, '1991', 1),
	(3, '1992', 1),
	(4, '1993', 1),
	(5, '1994', 1),
	(6, '1995', 1),
	(7, '1996', 1),
	(8, '1997', 1),
	(9, '1998', 1),
	(10, '1999', 1),
	(11, '2000', 1),
	(12, '2001', 1),
	(13, '2002', 1),
	(14, '2003', 1),
	(15, '2004', 1),
	(16, '2005', 1),
	(17, '2006', 1),
	(18, '2007', 1),
	(19, '2008', 1),
	(20, '2009', 1),
	(21, '2010', 1),
	(22, '2011', 1),
	(23, '2012', 1),
	(24, '2013', 1),
	(25, '2014', 1),
	(26, '2015', 1),
	(27, '2016', 1),
	(28, '2017', 1),
	(29, '2018', 1),
	(30, '2019', 1),
	(31, '2020', 1),
	(32, '2021', 1),
	(33, '2022', 1),
	(34, '2023', 1),
	(35, '2024', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
