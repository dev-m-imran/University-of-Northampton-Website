-- MariaDB dump 10.19  Distrib 10.5.19-MariaDB, for Linux (x86_64)
--
-- Host: mysql    Database: uon
-- ------------------------------------------------------
-- Server version	12.0.2-MariaDB-ubu2404

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `uon`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `uon` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;

USE `uon`;

--
-- Table structure for table `course_modules`
--

DROP TABLE IF EXISTS `course_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_modules` (
  `course_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`course_id`,`module_id`),
  KEY `idx_course_modules_module` (`module_id`),
  CONSTRAINT `fk_course_modules_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_course_modules_module` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_modules`
--

LOCK TABLES `course_modules` WRITE;
/*!40000 ALTER TABLE `course_modules` DISABLE KEYS */;
INSERT INTO `course_modules` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(9,8),(8,9),(10,10),(11,11);
/*!40000 ALTER TABLE `course_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `course_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject_area_id` int(10) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `duration_months` smallint(5) unsigned NOT NULL,
  `course_type` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `part_time` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`course_id`),
  KEY `idx_courses_subject_area` (`subject_area_id`),
  KEY `idx_courses_type` (`course_type`),
  KEY `idx_courses_duration` (`duration_months`),
  KEY `idx_courses_part_time` (`part_time`),
  CONSTRAINT `fk_courses_subject_area` FOREIGN KEY (`subject_area_id`) REFERENCES `subject_areas` (`subject_area_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,5,'BA English Literature',36,'Undergraduate','Study classic and modern literature, critical analysis, and writing.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36'),(2,5,'BA History',36,'Undergraduate','Explore world history, historical methods, and cultural development.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36'),(3,5,'BA Philosophy',36,'Undergraduate','Examine ethics, logic, metaphysics, and philosophical thought.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36'),(4,5,'BA Sociology',36,'Undergraduate','Understand society, culture, and human behaviour through sociological theory.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36'),(5,5,'BA Criminology',36,'Undergraduate','Study crime, justice systems, and criminal behaviour.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36'),(6,5,'BA Politics & International Relations',36,'Undergraduate','Learn about political systems, global relations, and governance.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36'),(7,5,'BA Journalism & Media Studies',36,'Undergraduate','Develop skills in journalism, media production, and communication.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36'),(8,5,'BA Creative Writing',36,'Undergraduate','Enhance writing skills across fiction, poetry, and creative nonfiction.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36'),(9,5,'BA Fine Art',36,'Undergraduate','Practice painting, sculpture, and visual arts with studio-based learning.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36'),(10,5,'BA Music & Performance',36,'Undergraduate','Study music theory, performance, and composition.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36'),(11,5,'BA Anthropology',36,'Undergraduate','Explore human cultures, evolution, and social structures.',0,'2026-01-22 12:10:36','2026-01-22 12:10:36');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enquiries`
--

DROP TABLE IF EXISTS `enquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enquiries` (
  `enquiry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(254) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `responded_at` datetime DEFAULT NULL,
  `responded_by_user_id` int(10) unsigned DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `course_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`enquiry_id`),
  KEY `idx_enquiries_created_at` (`created_at`),
  KEY `idx_enquiries_responded_at` (`responded_at`),
  KEY `idx_enquiries_responded_by` (`responded_by_user_id`),
  KEY `fk_enquiries_course` (`course_id`),
  CONSTRAINT `fk_enquiries_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_enquiries_responded_by` FOREIGN KEY (`responded_by_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enquiries`
--

LOCK TABLES `enquiries` WRITE;
/*!40000 ALTER TABLE `enquiries` DISABLE KEYS */;
INSERT INTO `enquiries` VALUES (1,'czzc','sdfhdf@gmail.com','zv zczc zdzc zdscz zsczc ','2026-01-22 12:50:31','2026-01-22 12:50:47',6,'7412392893',11);
/*!40000 ALTER TABLE `enquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `module_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_code` varchar(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `course_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `uq_modules_code` (`module_code`),
  KEY `fk_modules_course` (`course_id`),
  CONSTRAINT `fk_modules_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'ENG101','Literary Analysis','An introduction to analysing poetry, prose, and drama using critical frameworks.',1,'2026-01-22 12:14:30'),(2,'HIS101','World History Overview','A survey of major global civilisations and historical developments.',2,'2026-01-22 12:14:30'),(3,'PHI101','Introduction to Philosophy','Explores fundamental philosophical questions in ethics, logic, and metaphysics.',3,'2026-01-22 12:14:30'),(4,'SOC101','Foundations of Sociology','Examines key sociological theories, concepts, and research methods.',4,'2026-01-22 12:14:30'),(5,'CRI101','Introduction to Criminology','Covers crime theories, criminal behaviour, and justice system structures.',5,'2026-01-22 12:14:30'),(6,'POL101','Global Politics & Governance','Introduces political systems, international relations, and global governance.',6,'2026-01-22 12:14:30'),(7,'JRN101','Media & Communication Theory','Studies media influence, communication models, and journalism principles.',7,'2026-01-22 12:14:30'),(8,'CWR101','Creative Writing Workshop','Develops creative writing skills across fiction, poetry, and narrative forms.',8,'2026-01-22 12:14:30'),(9,'ART101','Studio Art Fundamentals','Hands-on exploration of drawing, painting, and visual composition.',9,'2026-01-22 12:14:30'),(10,'MUS101','Music Theory & Performance','Covers music notation, harmony, rhythm, and performance techniques.',10,'2026-01-22 12:14:30'),(11,'ANT101','Introduction to Anthropology','Explores human cultures, evolution, and social structures.',11,'2026-01-22 12:14:30');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject_areas`
--

DROP TABLE IF EXISTS `subject_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject_areas` (
  `subject_area_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`subject_area_id`),
  UNIQUE KEY `uq_subject_areas_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_areas`
--

LOCK TABLES `subject_areas` WRITE;
/*!40000 ALTER TABLE `subject_areas` DISABLE KEYS */;
INSERT INTO `subject_areas` VALUES (1,'Computing & Information Technology','2026-01-22 12:06:15'),(3,'Engineering & Technology','2026-01-22 12:06:15'),(4,'Health & Life Sciences','2026-01-22 12:06:15'),(5,'Arts, Humanities & Social Sciences','2026-01-22 12:06:15');
/*!40000 ALTER TABLE `subject_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uq_users_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (6,'admin','$2y$12$nMlOIKw3B3fUCFVEu2cr4OlZKEEzeWZrucjGMfQadvfkNFclhQYq6',1,'2026-01-22 12:01:19'),(7,'imran','$2y$12$zrsRH1O9g9XkpJKaCl4x2uO/F0eLITKvy2DKXEKXSlMLQ7Ze0qUsu',0,'2026-01-22 12:05:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'uon'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-22 14:18:15
