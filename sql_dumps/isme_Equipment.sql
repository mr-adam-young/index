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
-- Table structure for table `Equipment`
--

DROP TABLE IF EXISTS `Equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Equipment` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `VehicleName` varchar(255) DEFAULT NULL,
  `InspectionExpires` datetime DEFAULT NULL,
  `Alert` tinyint(1) DEFAULT '0',
  `Plate` varchar(255) DEFAULT NULL,
  `LastOilChangeMileHour` int(11) DEFAULT '0',
  `ServiceInterval` int(11) DEFAULT '0',
  `VIN-Serial` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `WeightLimit` int(11) DEFAULT '0',
  `InsuranceExpires` datetime DEFAULT NULL,
  `InsurancePolicy` varchar(255) DEFAULT NULL,
  `RegistrationExpires` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Equipment`
--

LOCK TABLES `Equipment` WRITE;
/*!40000 ALTER TABLE `Equipment` DISABLE KEYS */;
INSERT INTO `Equipment` VALUES (1,'Chevy Pickup','2016-07-31 00:00:00',0,'YXN0612',214288,0,'1GCHK23D07F184371','2007 Chevrolet Silverado 3500',7000,'2016-01-05 00:00:00','AX90670008','2015-07-31 00:00:00'),(2,'Reading Truck','2016-06-30 00:00:00',0,'YSG8167',64654,0,'3D6WS26D67G759259','2007 Dodge Ram 2500, Reading Body',8650,'2016-01-05 00:00:00','AX90670008','2016-04-30 00:00:00'),(3,'Box Truck','2016-09-30 00:00:00',0,'ZGF2001',0,0,'1GB3G3CG2E1184852','2014 Chevrolet Express 3500',12300,'2016-01-05 00:00:00','AX90670008','2015-11-30 00:00:00'),(4,'Four Wheeler',NULL,0,NULL,0,0,NULL,'2014 Yamaha Grizzly 700',NULL,NULL,NULL,NULL),(5,'Bobcat',NULL,0,NULL,0,0,NULL,'Bobcat MT55 Mini Track Loader',NULL,NULL,NULL,NULL),(6,'Enclosed Trailer',NULL,0,NULL,0,0,NULL,'Horton Hauler',NULL,NULL,NULL,NULL),(7,'Car-Mate',NULL,0,NULL,0,0,NULL,'Small trailer used at farm',0,NULL,NULL,NULL),(8,'Flat Trailer',NULL,0,NULL,0,0,NULL,'Big Tex',0,NULL,NULL,NULL),(9,'Tow Motor',NULL,0,NULL,0,0,NULL,'Nissan Forklift',0,NULL,NULL,NULL),(10,'Explorer',NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL),(11,'Skid Loader',NULL,0,NULL,0,0,NULL,'Case',0,NULL,NULL,NULL),(12,'GeneratorWelder 1',NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL),(13,'GeneratorWelder 2',NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL),(14,'Push Mower',NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL),(15,'Backpack Snow Blower',NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL),(16,'Motor Snow Blower',NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL),(17,'Honda Generator',NULL,0,NULL,0,0,NULL,'Honda',0,NULL,NULL,NULL),(18,'Portable Compressor',NULL,0,NULL,0,0,NULL,'DeWalt',0,NULL,NULL,NULL),(19,'Shop Compressor',NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL),(20,'Stihl Chainsaw',NULL,0,NULL,0,0,NULL,'Stihl Farm Boss',0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Equipment` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-24 17:53:44
