-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: interversal.chpbdpdleafb.us-east-2.rds.amazonaws.com    Database: isme
-- ------------------------------------------------------
-- Server version	5.6.37-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `LaborTypes`
--

DROP TABLE IF EXISTS `LaborTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LaborTypes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LaborType` varchar(255) DEFAULT NULL,
  `Rate` decimal(19,4) DEFAULT '0.0000',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LaborTypes`
--

LOCK TABLES `LaborTypes` WRITE;
/*!40000 ALTER TABLE `LaborTypes` DISABLE KEYS */;
INSERT INTO `LaborTypes` VALUES (1,'General',70.0000),(2,'Clerical',60.0000),(3,'Material Handling',60.0000),(4,'Layout',75.0000),(5,'Assembly',75.0000),(6,'Finishing',45.0000),(7,'Paint',75.0000),(8,'Installation',80.0000),(9,'Travel',75.0000),(10,'Cut Material',75.0000),(11,'Drawing',60.0000),(12,'Holiday',0.0000),(13,'Vacation',0.0000),(14,'Snow Removal',75.0000),(15,'Polishing',75.0000),(16,'Wood Fence Installation',0.0000),(17,'Shop Meeting',70.0000),(18,'Measure',60.0000),(19,'Design',60.0000),(20,'Rework',75.0000);
/*!40000 ALTER TABLE `LaborTypes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-24 17:53:39
