-- MySQL dump 10.14  Distrib 5.5.50-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: bpi_calendar
-- ------------------------------------------------------
-- Server version	5.5.50-MariaDB

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
-- Table structure for table `datesManif`
--

DROP TABLE IF EXISTS `datesManif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datesManif` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `manifestation_ID` bigint(20) NOT NULL,
  `debut_manif` bigint(20) NOT NULL,
  `fin_manif` bigint(20) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `manifestation_ID` (`manifestation_ID`),
  CONSTRAINT `datesManif_ibfk_1` FOREIGN KEY (`manifestation_ID`) REFERENCES `manifestation` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datesManif`
--

LOCK TABLES `datesManif` WRITE;
/*!40000 ALTER TABLE `datesManif` DISABLE KEYS */;
INSERT INTO `datesManif` VALUES (53,5,201604150800,201604150930),(56,7,201604150930,201604151030),(57,8,201604151030,201604151130),(58,9,201604151130,201604151230),(60,11,201609201400,201609201600),(62,10,201606072000,201606072200),(63,12,201610111330,201610111400);
/*!40000 ALTER TABLE `datesManif` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `espace`
--

DROP TABLE IF EXISTS `espace`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `espace` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `espace` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `espace`
--

LOCK TABLES `espace` WRITE;
/*!40000 ALTER TABLE `espace` DISABLE KEYS */;
INSERT INTO `espace` VALUES (1,'Espaces Centre'),(2,'Espaces BPI'),(3,'Hors les murs'),(4,'Atelier');
/*!40000 ALTER TABLE `espace` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lieu` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `lieu` varchar(255) NOT NULL,
  `espace_ID` bigint(20) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `espace_ID` (`espace_ID`),
  CONSTRAINT `lieu_ibfk_1` FOREIGN KEY (`espace_ID`) REFERENCES `espace` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lieu`
--

LOCK TABLES `lieu` WRITE;
/*!40000 ALTER TABLE `lieu` DISABLE KEYS */;
INSERT INTO `lieu` VALUES (17,'Niveau 1',2),(18,'Niveau 1- Mezzanine',2),(19,'Niveau 1 - Salon graphique et salon jeux vidéo',2),(20,'Niveau 2',2),(21,'Niveau 2 - Espace Autoformation',2),(22,'Niveau 2 - Espace Presse',2),(23,'Niveau 2 - Mur entrée',2),(24,'Niveau 2 - Salon 5/6',2),(25,'Centre Wallonie-Bruxelles',3),(26,'MK2 Beaubourg',3),(27,'ExterieurTest3',3),(28,'ExterieurTest4',3),(29,'ExterieurTest5',3),(30,'ExterieurTest6',3),(31,'ExterieurTest7',3),(32,'ExterieurTest8',3),(33,'ExterieurTest9',3),(34,'ExterieurTest10',3),(35,'ExterieurTest11',3),(36,'ExterieurTest12',3),(37,'Atelier',4),(39,'Ciné 1',1),(40,'Niveau 2 - Table haute Droit-éco',2),(41,'Niveau 2 - Table haute Philo-religion',2),(42,'Niveau 2 - Table haute Sciences-techniques',2),(43,'Niveau 2 - Table valorisation entrée niveau',2),(44,'Niveau 3',2),(45,'Niveau 3 - Espace Musiques',2),(46,'Niveau 3 - Espace Musiques : lift',2),(47,'Niveau 3 - Salon 7/8 ',2),(48,'Niveau 3 - Salon littérature',2),(49,'Niveau 3 - Table haute Arts-Sports-Loisirs',2),(50,'Niveau 3 - Table haute Histoire-géo',2),(51,'Niveau 3 - Table haute Littérature',2),(52,'Niveau 3 - Table haute Musique',2),(53,'Ciné 2',1),(54,'Foyer',1),(55,'Grande salle',1),(56,'Petite Salle',1);
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
  `recurrence_manifestation_ID` tinyint(4) NOT NULL,
  `fin_recurence_year` int(11) NOT NULL DEFAULT '-1',
  `fin_recurence_month` tinyint(4) NOT NULL DEFAULT '-1',
  `fin_recurence_day` tinyint(4) NOT NULL DEFAULT '-1',
  `status_manifestation_ID` tinyint(4) NOT NULL,
  `type_manifestation_ID` tinyint(4) NOT NULL,
  `intitule` varchar(255) NOT NULL,
  `responsable_ID` bigint(20) NOT NULL,
  `observations` text,
  `evenement` text,
  PRIMARY KEY (`ID`),
  KEY `status_manifestation_ID` (`status_manifestation_ID`),
  KEY `type_manifestation_ID` (`type_manifestation_ID`),
  KEY `recurrence_manifestation_ID` (`recurrence_manifestation_ID`),
  KEY `responsable_ID` (`responsable_ID`),
  CONSTRAINT `manifestation_ibfk_1` FOREIGN KEY (`status_manifestation_ID`) REFERENCES `status_manifestation` (`ID`),
  CONSTRAINT `manifestation_ibfk_2` FOREIGN KEY (`type_manifestation_ID`) REFERENCES `type_manifestation` (`ID`),
  CONSTRAINT `manifestation_ibfk_3` FOREIGN KEY (`recurrence_manifestation_ID`) REFERENCES `recurrence_manifestation` (`ID`),
  CONSTRAINT `manifestation_ibfk_4` FOREIGN KEY (`responsable_ID`) REFERENCES `responsable` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manifestation`
--

LOCK TABLES `manifestation` WRITE;
/*!40000 ALTER TABLE `manifestation` DISABLE KEYS */;
INSERT INTO `manifestation` VALUES (5,1,-1,-1,-1,1,1,'Test',13,NULL,NULL),(6,1,-1,-1,-1,1,1,'',13,NULL,NULL),(7,1,-1,-1,-1,1,1,'Test2',13,NULL,NULL),(8,1,-1,-1,-1,1,1,'Test3',13,NULL,NULL),(9,1,-1,-1,-1,1,1,'Test 4',13,NULL,NULL),(10,1,-1,-1,-1,1,1,'Corps filmés',13,NULL,NULL),(11,1,-1,-1,-1,1,1,'Mardi de l\'info : risques psychosociaux',13,NULL,NULL),(12,1,-1,-1,-1,1,2,'Café des nouveaux arrivants',13,NULL,NULL);
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
  `recurrence` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurrence_manifestation`
--

LOCK TABLES `recurrence_manifestation` WRITE;
/*!40000 ALTER TABLE `recurrence_manifestation` DISABLE KEYS */;
INSERT INTO `recurrence_manifestation` VALUES (1,NULL),(2,'Quotidien'),(3,'Hebdomadaire'),(4,'Bimensuel'),(5,'Mensuel'),(6,'Trimestriel');
/*!40000 ALTER TABLE `recurrence_manifestation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `lieu_ID` bigint(20) NOT NULL,
  `dates_manifestation_ID` bigint(20) NOT NULL,
  `debut_reservation` bigint(20) NOT NULL,
  `fin_reservation` bigint(20) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `lieu_ID` (`lieu_ID`),
  KEY `dates_manifestation_ID` (`dates_manifestation_ID`),
  CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`lieu_ID`) REFERENCES `lieu` (`ID`),
  CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`dates_manifestation_ID`) REFERENCES `datesManif` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
INSERT INTO `reservation` VALUES (51,39,53,201604150800,201604150930),(53,39,56,201604150930,201604151030),(54,39,57,201604151030,201604151130),(55,39,58,201604151130,201604151230),(57,56,60,201609201400,201609201600),(58,22,63,201610111330,201610111400);
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsable`
--

LOCK TABLES `responsable` WRITE;
/*!40000 ALTER TABLE `responsable` DISABLE KEYS */;
INSERT INTO `responsable` VALUES (12,'Arthour'),(13,'Marc Boilloux'),(14,'Jérôme Bessière');
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
INSERT INTO `type_manifestation` VALUES (1,'Manifestation publique'),(2,'Manfestation / réunion interne'),(3,'Administratif (pas d\'envoi à la presse)'),(4,'RH (pas d\'envoi à la presse)'),(5,'Financier (pas d\'envoi à la presse)'),(6,'Évènement de type calendaire (vacances, jours fériés)');
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

-- Dump completed on 2016-10-17 14:30:10
