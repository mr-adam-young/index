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
-- Table structure for table `Personnel`
--

DROP TABLE IF EXISTS `Personnel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Personnel` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_TEXT` varchar(255) DEFAULT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `Email Address` varchar(255) DEFAULT NULL,
  `Cell Phone` varchar(255) DEFAULT NULL,
  `Birthday` datetime DEFAULT NULL,
  `Rate` decimal(19,4) DEFAULT '0.0000',
  `VacationHours` float DEFAULT '0',
  `DateJoined` datetime DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `ID_TEXT` (`ID_TEXT`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Personnel`
--

LOCK TABLES `Personnel` WRITE;
/*!40000 ALTER TABLE `Personnel` DISABLE KEYS */;
INSERT INTO `Personnel` VALUES (1,'scotthess','Scott Hess','scott@hessiron.com','7174952810','1969-10-22 00:00:00',NULL,NULL,'2005-01-01 00:00:00','shess','apples',1),(2,'lorihess','Lori Hess','lori@hessiron.com','7174877752',NULL,NULL,NULL,'2005-01-01 00:00:00','lhess','apples',1),(3,'brianness','Brian Ness','brian@hessiron.com','7174874087',NULL,NULL,NULL,'2012-01-01 00:00:00','bness',NULL,1),(4,'adamyoung','Adam Young','adam@hessiron.com','7175773404','1991-01-12 00:00:00',NULL,NULL,'2014-04-01 00:00:00','ayoung','$2y$10$b8KBhF6y3UqrlsRKoSmIq.Qq56JYbSF2QC5Ki0O8Xkcx5611vswOW',1),(5,'alanweikert','Alan Weikert','al@hessiron.com',NULL,NULL,NULL,NULL,NULL,'aweikert',NULL,0),(6,'dannymiller','Dan Miller','dan@hessiron.com',NULL,NULL,NULL,NULL,NULL,'dmiller',NULL,0),(7,'davidleiphart','Dave Leiphart','dave@hessiron.com',NULL,NULL,NULL,NULL,NULL,'dleiphart',NULL,0),(8,'travislefever','Travis Lefever','travis@hessiron.com',NULL,NULL,NULL,NULL,NULL,'tlefever',NULL,0),(9,'scottkline','Scott Kline','skline@hessiron.com','7175013180','2016-06-01 00:00:00',NULL,NULL,NULL,'skline',NULL,1),(10,'galendietz','Galen Dietz',NULL,'7178739070',NULL,NULL,NULL,NULL,'gdietz',NULL,1),(11,'asoltysik','Anthony Soltysik','anthony@hessiron.com','',NULL,0.0000,0,NULL,NULL,NULL,1),(12,'ncolehouse','Noah Colehouse','noah@hessiron.com',NULL,NULL,0.0000,0,NULL,NULL,NULL,0),(13,'ceshleman','Cynthia Eshleman','cynthia@hessiron.com',NULL,NULL,0.0000,0,'2018-04-01 00:00:00',NULL,NULL,0),(14,'nbarshinger','Nathan Barshinger',NULL,NULL,NULL,0.0000,0,'2018-06-21 00:00:00',NULL,NULL,0);
/*!40000 ALTER TABLE `Personnel` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-24 17:53:40
