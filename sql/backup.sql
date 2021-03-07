-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
--
-- Host: localhost    Database: kuis_db
-- ------------------------------------------------------
-- Server version	8.0.23-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  `description` text,
  `image_url` text,
  `total_exam` int DEFAULT NULL,
  `require_correct` int DEFAULT NULL,
  `created_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `course_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (2,'kursus bahasa','kursus bahasa yang menyenangkan','https://campuspedia.id/news/wp-content/uploads/2020/09/tips-belajar-bahasa-asing.jpg',5,4,1);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam`
--

DROP TABLE IF EXISTS `exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `number` text,
  `text` text,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam`
--

LOCK TABLES `exam` WRITE;
/*!40000 ALTER TABLE `exam` DISABLE KEYS */;
INSERT INTO `exam` VALUES (1,2,'1','apakah kursus bahasa menyenangkan?'),(2,2,'2','apakah kursus bahasa menyulitkan?'),(3,2,'3','apakah kursus bahasa bisa dimana saja?'),(4,2,'4','apakah kursus bahasa cocok untuk saya?'),(5,2,'5','apakah kursus bahasa ite geh?');
/*!40000 ALTER TABLE `exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_answer`
--

DROP TABLE IF EXISTS `exam_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_answer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_id` int NOT NULL,
  `label` text,
  `text` text,
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`),
  CONSTRAINT `exam_answer_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_answer`
--

LOCK TABLES `exam_answer` WRITE;
/*!40000 ALTER TABLE `exam_answer` DISABLE KEYS */;
INSERT INTO `exam_answer` VALUES (1,1,'a','iya'),(2,1,'b','tidak'),(3,1,'c','entah'),(4,2,'a','iya'),(5,2,'b','tidak'),(6,2,'c','entah'),(7,3,'a','iya'),(8,4,'a','iya'),(9,5,'a','iya'),(10,5,'b','tidak'),(11,4,'b','tidak'),(12,3,'b','tidak'),(13,3,'c','entah'),(14,4,'c','entah'),(15,5,'c','entah');
/*!40000 ALTER TABLE `exam_answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_progress`
--

DROP TABLE IF EXISTS `exam_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_id` int NOT NULL,
  `exam_answer_id` int NOT NULL,
  `answer_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `answer_by` (`answer_by`),
  KEY `exam_id` (`exam_id`),
  KEY `exam_answer_id` (`exam_answer_id`),
  CONSTRAINT `exam_progress_ibfk_1` FOREIGN KEY (`answer_by`) REFERENCES `user` (`id`),
  CONSTRAINT `exam_progress_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`),
  CONSTRAINT `exam_progress_ibfk_3` FOREIGN KEY (`exam_answer_id`) REFERENCES `exam_answer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_progress`
--

LOCK TABLES `exam_progress` WRITE;
/*!40000 ALTER TABLE `exam_progress` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_solution`
--

DROP TABLE IF EXISTS `exam_solution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_solution` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_id` int NOT NULL,
  `exam_answer_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`),
  KEY `exam_answer_id` (`exam_answer_id`),
  CONSTRAINT `exam_solution_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`),
  CONSTRAINT `exam_solution_ibfk_2` FOREIGN KEY (`exam_answer_id`) REFERENCES `exam_answer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_solution`
--

LOCK TABLES `exam_solution` WRITE;
/*!40000 ALTER TABLE `exam_solution` DISABLE KEYS */;
INSERT INTO `exam_solution` VALUES (2,1,1),(3,5,15),(4,3,12),(5,4,14),(7,2,5);
/*!40000 ALTER TABLE `exam_solution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  `username` text,
  `password` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'reno','renosyah','12345');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-07 21:53:08
