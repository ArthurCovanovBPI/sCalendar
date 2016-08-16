-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: bpi_calendar
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

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
-- Table structure for table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lieu` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `lieu` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lieu`
--

LOCK TABLES `lieu` WRITE;
/*!40000 ALTER TABLE `lieu` DISABLE KEYS */;
/*!40000 ALTER TABLE `lieu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manifestation`
--

DROP TABLE IF EXISTS `manifestation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manifestation` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `debut_manif_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fin_manif_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status_manifestation_id` tinyint(4) NOT NULL,
  `type_manifestation_id` tinyint(4) NOT NULL,
  `recurrence_manifestation_id` tinyint(4) NOT NULL,
  `fin_recurence_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `intitule` varchar(255) NOT NULL,
  `responsable_id` bigint(20) NOT NULL,
  `lieu_id` bigint(20) NOT NULL,
  `observations` text,
  `evenement` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manifestation`
--

LOCK TABLES `manifestation` WRITE;
/*!40000 ALTER TABLE `manifestation` DISABLE KEYS */;
INSERT INTO `manifestation` VALUES (1,'2015-11-27 13:52:50','2015-11-30 13:52:50',1,1,1,'0000-00-00 00:00:00','ts2t',1,1,'Observation TST2','Evenement TST2');
/*!40000 ALTER TABLE `manifestation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recurrence_manifestation`
--

DROP TABLE IF EXISTS `recurrence_manifestation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recurrence_manifestation` (
  `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `recurence` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurrence_manifestation`
--

LOCK TABLES `recurrence_manifestation` WRITE;
/*!40000 ALTER TABLE `recurrence_manifestation` DISABLE KEYS */;
INSERT INTO `recurrence_manifestation` VALUES (1,''),(2,'Quotidien'),(3,'Hebdomadaire'),(4,'Bimensuel'),(5,'Mensuel'),(6,'Trimestriel');
/*!40000 ALTER TABLE `recurrence_manifestation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responsable` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsable`
--

LOCK TABLES `responsable` WRITE;
/*!40000 ALTER TABLE `responsable` DISABLE KEYS */;
/*!40000 ALTER TABLE `responsable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_manifestation`
--

DROP TABLE IF EXISTS `status_manifestation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_manifestation` (
  `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_manifestation`
--

LOCK TABLES `status_manifestation` WRITE;
/*!40000 ALTER TABLE `status_manifestation` DISABLE KEYS */;
INSERT INTO `status_manifestation` VALUES (1,'Confirmée'),(2,'En projet'),(3,'Annulée');
/*!40000 ALTER TABLE `status_manifestation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_manifestation`
--

DROP TABLE IF EXISTS `type_manifestation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_manifestation` (
  `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_manifestation`
--

LOCK TABLES `type_manifestation` WRITE;
/*!40000 ALTER TABLE `type_manifestation` DISABLE KEYS */;
INSERT INTO `type_manifestation` VALUES (1,'Manifestation normale (envoi à la presse)'),(2,'Réunion privée (pas d\'envoi à la presse)'),(3,'Administratif (pas d\'envoi à la presse)'),(4,'RH (pas d\'envoi à la presse)'),(5,'Financier (pas d\'envoi à la presse)'),(6,'Évènement de type calendaire (vacances, jours fériés)');
/*!40000 ALTER TABLE `type_manifestation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-30  9:49:32
