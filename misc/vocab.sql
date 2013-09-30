-- MySQL dump 10.13  Distrib 5.5.27, for Win32 (x86)
--
-- Host: localhost    Database: vocab
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Technology','Science, Engineering, Information technology'),(2,'Business','Business and economy'),(3,'Informal','Slang expressions'),(4,'General','Everything which doesn`t fit into a specific category');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `pwd` varchar(16) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Michael','Zech','michael.zech@googlemail.com','michael',NULL),(2,'Willy','Meyer','w.m@gmx.de','willy',NULL),(3,'Thomas','Wagner','t.w@gmx.de','thomas',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `words`
--

DROP TABLE IF EXISTS `words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `english` varchar(50) NOT NULL,
  `german` varchar(50) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `note` varchar(200) DEFAULT NULL,
  `example` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `words_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `words`
--

LOCK TABLES `words` WRITE;
/*!40000 ALTER TABLE `words` DISABLE KEYS */;
INSERT INTO `words` VALUES (13,'trait','Eigenschaft, Charakterzug, Wesenszug',4,'',''),(25,'to withdraw','etw. abheben',2,'Gegenteil: to deposit == etw. einzahlen','... to withdraw from the contract.'),(28,'wire','Draht, Kabel',1,NULL,NULL),(48,'to schedule','terminieren',2,'',''),(49,'to spill','ueberlaufen',4,'',''),(54,'walkthrough','Komplettloesung, Ortsbesichtigung',1,'',''),(55,'to revert to sth.','auf etw. zurueckgreifen, zu etw. zurueckkehren',4,'',''),(75,'supernatural','uebernatuerlich',4,'',''),(100,'turn','Wende',4,'',''),(110,'amendment','Besserung',4,'',''),(111,'conscientious','gewissenhaft',4,'',''),(112,'loan','Darlehen',2,'',''),(113,'interest rate','Zinsfuss',2,'',''),(114,'pedestal ','Absatz, Sockel',1,'','to be put on a pedestal == auf ein Podest gestellt werden'),(122,'to accustom','eingewoehnen',4,'',''),(123,'to adapt','anpassen',4,'',''),(124,'mistake','Menschliches Versagen, Fehlgriff, -verhalten',4,'',''),(125,'petulant','launisch, gereizt',4,'',''),(126,'livestock','lebender Bestand, Viehbestand',4,'',''),(127,'entangled','verwickelt',4,'','to become entangled'),(128,'prolific','fruchtbar',4,'',''),(129,'eligibility','der Anspruch, die Berechtigung',2,'',''),(130,'investigator','der Ermittler, der Fahnder',4,'',''),(131,'subsequently','im Anschluss, darauffolgend',4,'',''),(132,'prowess','Faehigkeit',4,'',''),(133,'inception','Anbeginn, Gruendung',4,'','Since it`s inception it has ...'),(134,'grumbling','Murren, Noergelei',4,'',''),(135,'to revamp','auf-, ausbessern',4,'','How the foundation can revamp itself in the coming years.'),(136,'creditworthiness','Kreditwuerdigkeit, Bonitaet',2,'','Social connections can be a indicator of a person`s creditworthiness.'),(137,'susceptible','anfaellig, stoerempfindlich',4,'','It is susceptible to a brute force attack.'),(138,'to throw a spanner in sth.','jmdm. einen Strich durch die Rechnung machen',4,'',''),(139,'gregarious','gesellig',4,'',''),(140,'succinct','buendig, knapp',4,'',''),(141,'to lure','anlocken, koedern',4,'',''),(142,'appendix','Anhang, Anlagen',4,'','Could you move it to an appendix?'),(143,'responsive','ansprechbar, reaktionsfaehig',1,'',''),(144,'track record','Erfolgsgeschichte',2,'','Oracles track record for working with the wider technology community is dicey.'),(145,'dicey','heikel, unzuverlaessig',4,'See word \'track record\' for example.',''),(146,'to decelerate','verzoegern',4,'to decelerate >< to accelerate',''),(147,'amidst / amid','inmitten, mitten unter, mitten drin',4,'',''),(148,'sustainer','Bewahrer, Erhalter',4,'','');
/*!40000 ALTER TABLE `words` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-30 11:36:12
