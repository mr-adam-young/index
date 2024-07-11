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
-- Table structure for table `Materials`
--

DROP TABLE IF EXISTS `Materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Materials` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(255) DEFAULT NULL,
  `Width` float DEFAULT '0',
  `Height` float DEFAULT '0',
  `Thick` float DEFAULT '0',
  `WeightPerLength` float DEFAULT '0',
  `PricePerFoot` float DEFAULT '0',
  `Material` varchar(255) DEFAULT NULL,
  `QuoteDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Length` float DEFAULT '0',
  `Alloy` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Materials`
--

LOCK TABLES `Materials` WRITE;
/*!40000 ALTER TABLE `Materials` DISABLE KEYS */;
INSERT INTO `Materials` VALUES (1,'Tubing',0.75,0.75,0.065,14.5,0.4,'Steel','2016-04-07 04:00:00',NULL,'A6'),(2,'Tubing',0.75,0.75,0.12,24.65,0.65,'Steel','2016-04-07 04:00:00',NULL,'A6'),(3,'Channel',1.5,0.75,0.125,0,0,'Aluminum','2016-12-05 20:58:53',192,'6063-T6'),(4,'Square Bar',1.5,1.5,0,0,5.0833,'Aluminum','2017-06-02 14:58:13',144,'6061-T6'),(5,'Square Bar',1,0,0,0,2.12,'Aluminum','2017-06-02 14:58:13',144,'6061-T6'),(6,'Square Bar',0.5,0,0,0,0.5694,'Aluminum','2017-06-02 14:58:13',192,'6063-T6'),(7,'Square Bar',0.625,0,0,0,0,'Aluminum','2017-06-02 14:58:13',144,'6061-T6');
/*!40000 ALTER TABLE `Materials` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-24 17:53:45
