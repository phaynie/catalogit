-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: BaseTesting
-- ------------------------------------------------------
-- Server version	8.0.18

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
-- Current Database: `BaseTesting`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `BaseTesting` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `BaseTesting`;

--
-- Table structure for table `b2r2o`
--

DROP TABLE IF EXISTS `b2r2o`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `b2r2o` (
  `book_ID` int(8) unsigned NOT NULL,
  `role_ID` int(8) unsigned NOT NULL,
  `org_ID` int(8) unsigned NOT NULL,
  KEY `book_ID` (`book_ID`),
  KEY `role_ID` (`role_ID`),
  KEY `org_ID` (`org_ID`),
  CONSTRAINT `b2r2o_ibfk_1` FOREIGN KEY (`book_ID`) REFERENCES `books` (`ID`),
  CONSTRAINT `b2r2o_ibfk_2` FOREIGN KEY (`role_ID`) REFERENCES `roles` (`ID`),
  CONSTRAINT `b2r2o_ibfk_3` FOREIGN KEY (`org_ID`) REFERENCES `organizations` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `b2r2o`
--

LOCK TABLES `b2r2o` WRITE;
/*!40000 ALTER TABLE `b2r2o` DISABLE KEYS */;
INSERT INTO `b2r2o` VALUES (39,5,46),(44,5,47),(46,5,48),(46,5,47),(47,5,47),(49,5,49),(48,5,50),(50,5,46),(51,5,47);
/*!40000 ALTER TABLE `b2r2o` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `b2r2p`
--

DROP TABLE IF EXISTS `b2r2p`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `b2r2p` (
  `book_ID` int(8) unsigned NOT NULL,
  `role_ID` int(8) unsigned NOT NULL,
  `people_ID` int(8) unsigned NOT NULL,
  KEY `book_ID` (`book_ID`),
  KEY `role_ID` (`role_ID`),
  KEY `people_ID` (`people_ID`),
  CONSTRAINT `b2r2p_ibfk_1` FOREIGN KEY (`book_ID`) REFERENCES `books` (`ID`),
  CONSTRAINT `b2r2p_ibfk_2` FOREIGN KEY (`role_ID`) REFERENCES `roles` (`ID`),
  CONSTRAINT `b2r2p_ibfk_3` FOREIGN KEY (`people_ID`) REFERENCES `people` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `b2r2p`
--

LOCK TABLES `b2r2p` WRITE;
/*!40000 ALTER TABLE `b2r2p` DISABLE KEYS */;
INSERT INTO `b2r2p` VALUES (39,4,119);
/*!40000 ALTER TABLE `b2r2p` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag1` varchar(350) DEFAULT NULL,
  `tag2` varchar(350) DEFAULT NULL,
  `book_vol` varchar(80) DEFAULT NULL,
  `book_num` varchar(20) DEFAULT NULL,
  `physBookLoc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (39,'Classics to Moderns','Original  Piano Music of Three Centuries','Music for Millions Series','Volume 47',NULL,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(40,'Men\'s Vocal Arrangements','Sheet Music Collection',NULL,'1',NULL,'Not a physical Book - Search by Composition Title for sheet music location'),(41,'SATB Vocal Arrangements',NULL,NULL,'1',NULL,'Not a physical Book - Search by Composition Title for sheet music location'),(42,'SSA Vocal Arrangements','Collection of SSA Sheet music',NULL,'1',NULL,'Not a physical Book - Search by Composition Title for sheet music location'),(43,'Three-part Mixed Vocal Arrangements','Collection of Three-Part Mixed Vocal Sheet Music',NULL,'1',NULL,'Not a physical Book - Search by Composition Title for sheet music location'),(44,'Disney Solos','For Trombone/Baritone',NULL,NULL,NULL,'Book Shelf: Trombone Anthologies / Alphabetical by Title / \"Disney Solos for Trombone/Baritone\"'),(45,'Faber Piano Adventures','The Basic Piano Method',NULL,'Performance Book','3B','Book Shelf: Piano Method  / Alphabetical by Title / Faber Piano Adventures / Level 3B / Performance'),(46,'Twenty-Four Italian Songs and Arias','of the Seventeenth and Eighteenth Centuries','For Medium Low Voice','1723',NULL,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(47,'John Williams Piano Anthology, The','Over 40 Timeless Selections',NULL,NULL,NULL,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(48,'Christmas Encores for Two','Contemporary Duet Arrangements of Christmas Favorites',NULL,NULL,'1','Book Shelf: Piano Anthologies / Christmas / Piano Duets / Alphabetical by Title / \"Christmas Encores for Two\"'),(49,'A Call to Prayer','10 Arrangements of Hymns That Speak to the Heart','Alfred\'s Sacred Performer Collections',NULL,NULL,'Book Shelf: Piano Anthologies / Religious / Alphabetical by Title / \"A Call to Prayer\"'),(50,'Piano Duets','These thirty-five duets have been expertly selected and edited to encourage the pianist to develop a rhythmical steadiness, quicken the sense of hearing  in relation to color and nuance, and to improve their ensemble playing skills.',NULL,'Everybody\'s Favorite series 7',NULL,'Book Shelf: Piano / General Ensembles / Alphabetical by Title /\"Piano Duets\"'),(51,'Disney Movie Hits (Violin)','Solo Arrangements With CD Accompaniment','Violin',NULL,NULL,'Book Shelf: Violin / Alphabetical by Composer / Disney');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c2d`
--

DROP TABLE IF EXISTS `c2d`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `c2d` (
  `composition_ID` int(8) unsigned NOT NULL,
  `difficulty_ID` int(8) unsigned NOT NULL,
  KEY `difficulty_ID` (`difficulty_ID`),
  KEY `composition_ID` (`composition_ID`),
  CONSTRAINT `c2d_ibfk_1` FOREIGN KEY (`difficulty_ID`) REFERENCES `difficulties` (`ID`),
  CONSTRAINT `c2d_ibfk_2` FOREIGN KEY (`composition_ID`) REFERENCES `compositions` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c2d`
--

LOCK TABLES `c2d` WRITE;
/*!40000 ALTER TABLE `c2d` DISABLE KEYS */;
INSERT INTO `c2d` VALUES (94,8),(94,28),(95,10),(95,34),(96,9),(96,33),(97,9),(97,33),(98,10),(98,34),(99,10),(99,34),(100,9),(100,32),(101,8),(101,28),(102,8),(102,28),(103,9),(103,32),(104,10),(104,34),(105,10),(105,34),(106,8),(106,34),(107,8),(107,34),(108,8),(108,34),(109,9),(109,32),(110,9),(110,32),(111,9),(111,32),(112,10),(112,34),(113,10),(113,34),(114,10),(114,34),(115,10),(115,34),(116,10),(116,34),(117,8),(117,28),(118,8),(118,28),(119,9),(119,32),(120,8),(120,28),(121,8),(121,28),(122,9),(122,32),(123,10),(123,34),(124,10),(124,34),(125,10),(125,34),(126,9),(126,32),(127,9),(127,32),(128,10),(128,34),(129,8),(129,28),(130,9),(130,32),(131,10),(131,34),(132,10),(132,34),(133,10),(133,34),(134,10),(134,34),(135,10),(135,34),(136,10),(136,34),(137,9),(137,32),(138,8),(138,28),(139,8),(139,28),(140,8),(140,28),(141,9),(141,32),(142,8),(142,28),(143,9),(143,32),(144,8),(144,28),(145,8),(145,28),(146,8),(146,28),(147,10),(147,34),(148,9),(148,32),(149,9),(149,32),(158,10),(158,34),(157,10),(157,34),(156,10),(156,34),(155,10),(155,34),(154,10),(154,34),(153,10),(153,34),(152,10),(152,34),(151,10),(151,34),(150,10),(150,34),(159,10),(159,34),(160,10),(160,34),(161,10),(161,34),(162,10),(162,34),(163,10),(163,34),(164,10),(164,34),(165,10),(165,34),(166,10),(166,34),(167,10),(167,34),(168,10),(168,34),(169,10),(169,34),(170,10),(170,34),(171,10),(171,34),(172,10),(172,34),(173,10),(173,34),(174,10),(174,34),(175,10),(175,34),(177,3),(177,34),(176,3),(176,34),(180,3),(180,34),(178,3),(178,34),(181,3),(181,34),(182,3),(182,34),(183,3),(183,34),(184,3),(184,34),(179,3),(179,34),(185,3),(185,34),(186,3),(186,34),(187,3),(187,34),(188,3),(188,34),(189,3),(189,34),(190,10),(190,34),(191,10),(191,34),(192,10),(192,34),(193,10),(193,34),(194,10),(194,34),(195,10),(195,34),(196,10),(196,34),(197,10),(197,34),(198,10),(198,34),(199,10),(199,34),(200,10),(200,34),(201,10),(201,34),(202,10),(202,34),(203,10),(203,34),(204,10),(204,34),(205,10),(205,34),(206,10),(206,34),(207,10),(207,34),(208,10),(208,34),(209,10),(209,34),(210,10),(210,34),(211,10),(211,34),(212,10),(212,34),(213,10),(213,34),(214,10),(214,34),(215,10),(215,34),(216,10),(216,34),(217,10),(217,34),(218,10),(218,34),(219,10),(219,34),(220,10),(220,34),(221,10),(221,34),(222,10),(222,34),(223,10),(223,34),(224,10),(224,34),(225,10),(225,34),(226,10),(226,34),(227,10),(227,34),(228,10),(228,34),(229,10),(229,34),(230,10),(230,34),(231,10),(231,34),(232,10),(232,34),(233,10),(233,34),(234,10),(234,34),(235,10),(235,34),(236,10),(236,34),(237,10),(237,34),(238,10),(238,34),(239,10),(239,34),(240,10),(240,34),(241,10),(241,34),(242,10),(242,34),(243,10),(243,34),(244,10),(244,34),(245,10),(245,34),(246,10),(246,34),(247,10),(247,34),(248,10),(248,34),(249,10),(249,34),(250,10),(250,34),(251,10),(251,34),(252,10),(252,34),(253,10),(253,34),(254,10),(254,34),(255,10),(255,34),(256,10),(256,34),(257,5),(257,34),(258,5),(258,34),(259,5),(259,34),(260,6),(260,34),(267,7),(267,34),(266,7),(266,34),(265,7),(265,34),(264,7),(264,34),(263,7),(263,34),(262,10),(262,34),(261,7),(261,34),(268,7),(268,34),(269,7),(269,34),(270,7),(270,34),(271,10),(271,34),(272,10),(272,34),(273,10),(273,34),(274,10),(274,34),(275,10),(275,34),(276,10),(276,34),(277,10),(277,34),(278,10),(278,34),(279,10),(279,34),(280,10),(280,34),(281,10),(281,34),(282,10),(282,34),(283,10),(283,34),(284,10),(284,34),(285,10),(285,34),(286,10),(286,34),(287,10),(287,34),(288,10),(288,34),(289,10),(289,34),(290,10),(290,34),(291,10),(291,34),(292,10),(292,34),(293,10),(293,34),(294,10),(294,34),(295,10),(295,34),(296,10),(296,34),(297,10),(297,34),(298,10),(298,34),(299,10),(299,34),(300,10),(300,34),(301,10),(301,34),(302,10),(302,34),(303,10),(303,34),(304,10),(304,34),(305,10),(305,34),(306,10),(306,34),(310,10),(310,34),(309,10),(309,34),(308,10),(308,34),(307,10),(307,34),(311,10),(311,34),(312,10),(312,34),(313,10),(313,34),(314,10),(314,34),(315,10),(315,34),(316,10),(316,34),(317,10),(317,34);
/*!40000 ALTER TABLE `c2d` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c2g`
--

DROP TABLE IF EXISTS `c2g`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `c2g` (
  `composition_ID` int(8) unsigned NOT NULL,
  `genre_ID` int(8) unsigned NOT NULL,
  KEY `composition_ID` (`composition_ID`),
  KEY `genre_ID` (`genre_ID`),
  CONSTRAINT `c2g_ibfk_1` FOREIGN KEY (`composition_ID`) REFERENCES `compositions` (`ID`),
  CONSTRAINT `c2g_ibfk_2` FOREIGN KEY (`genre_ID`) REFERENCES `genres` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c2g`
--

LOCK TABLES `c2g` WRITE;
/*!40000 ALTER TABLE `c2g` DISABLE KEYS */;
INSERT INTO `c2g` VALUES (94,12),(95,12),(96,12),(97,12),(98,12),(99,12),(100,12),(101,12),(102,12),(103,12),(104,12),(105,12),(106,12),(107,12),(108,12),(109,12),(110,12),(111,12),(112,12),(113,12),(114,12),(115,12),(116,12),(117,12),(118,12),(119,12),(120,12),(121,12),(122,12),(123,12),(124,12),(125,12),(126,12),(127,12),(128,12),(129,12),(130,12),(131,12),(132,12),(133,12),(134,12),(135,12),(136,12),(137,12),(138,12),(139,12),(140,12),(141,12),(142,12),(143,12),(144,12),(145,12),(146,12),(147,12),(148,12),(149,12),(158,37),(157,37),(156,37),(155,37),(154,37),(153,37),(152,37),(151,29),(151,37),(150,1),(159,37),(160,37),(161,37),(162,7),(163,30),(164,22),(165,22),(166,22),(167,22),(168,22),(169,22),(170,22),(171,22),(172,22),(172,7),(173,22),(174,22),(175,22),(177,11),(176,11),(180,11),(178,11),(181,12),(181,11),(182,14),(182,11),(183,11),(184,5),(184,11),(179,14),(179,11),(185,12),(185,11),(186,11),(187,11),(188,12),(188,11),(189,11),(189,30),(190,1),(191,12),(192,12),(192,9),(193,12),(194,12),(195,12),(196,12),(197,12),(198,12),(199,12),(200,12),(201,12),(202,12),(203,12),(204,12),(205,12),(206,12),(207,12),(208,12),(209,12),(210,12),(211,12),(212,12),(213,12),(214,12),(215,21),(216,21),(217,21),(218,21),(218,6),(219,21),(220,21),(221,21),(222,21),(223,21),(224,21),(225,21),(226,21),(227,21),(228,21),(229,21),(230,21),(231,21),(232,21),(233,21),(234,21),(235,21),(236,21),(237,21),(238,21),(239,21),(240,21),(241,21),(242,21),(243,21),(244,21),(245,21),(246,21),(247,21),(248,21),(249,21),(250,21),(251,21),(252,21),(253,21),(254,21),(255,21),(256,3),(256,37),(257,3),(258,3),(259,3),(260,3),(267,17),(267,38),(266,17),(266,38),(265,17),(265,38),(264,17),(264,38),(263,17),(263,38),(262,17),(262,38),(261,17),(261,38),(268,17),(268,38),(269,17),(269,38),(270,17),(270,38),(271,12),(272,12),(273,12),(274,12),(275,12),(276,12),(277,12),(278,12),(279,12),(280,12),(281,12),(282,12),(283,12),(284,12),(285,12),(286,12),(287,12),(288,12),(289,12),(290,12),(291,12),(292,12),(293,12),(294,12),(295,12),(296,12),(297,12),(298,12),(299,12),(300,12),(301,12),(302,12),(303,12),(304,12),(305,12),(306,12),(310,21),(310,22),(309,21),(309,22),(308,21),(308,22),(307,21),(307,22),(311,21),(311,22),(312,21),(312,22),(313,21),(313,22),(314,21),(314,22),(315,21),(315,22),(316,21),(316,22),(317,21),(317,22);
/*!40000 ALTER TABLE `c2g` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c2i`
--

DROP TABLE IF EXISTS `c2i`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `c2i` (
  `composition_ID` int(8) unsigned NOT NULL,
  `instrument_ID` int(8) unsigned NOT NULL,
  KEY `composition_ID` (`composition_ID`),
  KEY `instrument_ID` (`instrument_ID`),
  CONSTRAINT `c2i_ibfk_1` FOREIGN KEY (`composition_ID`) REFERENCES `compositions` (`ID`),
  CONSTRAINT `c2i_ibfk_2` FOREIGN KEY (`instrument_ID`) REFERENCES `instruments` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c2i`
--

LOCK TABLES `c2i` WRITE;
/*!40000 ALTER TABLE `c2i` DISABLE KEYS */;
INSERT INTO `c2i` VALUES (94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,1),(114,1),(115,1),(116,1),(117,1),(118,1),(119,1),(120,1),(121,1),(122,1),(123,1),(124,1),(125,1),(126,1),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(137,1),(138,1),(139,1),(140,1),(141,1),(142,1),(143,1),(144,1),(145,1),(146,1),(147,1),(148,1),(149,1),(158,2),(157,2),(156,2),(155,2),(154,2),(153,2),(152,2),(151,2),(150,1),(150,2),(159,2),(160,2),(161,2),(162,1),(162,2),(163,52),(163,1),(163,2),(164,52),(164,12),(165,52),(165,12),(166,52),(166,12),(167,52),(167,12),(168,52),(168,12),(169,52),(169,12),(170,52),(170,12),(171,52),(171,12),(172,52),(172,12),(173,52),(173,12),(174,52),(174,12),(175,52),(175,12),(177,1),(176,1),(180,1),(178,1),(181,1),(182,1),(183,1),(184,1),(179,1),(185,1),(186,1),(187,1),(188,1),(189,1),(190,1),(190,2),(191,1),(191,2),(192,1),(192,2),(193,1),(193,2),(194,1),(194,2),(195,1),(195,2),(196,1),(196,2),(197,1),(197,2),(198,1),(198,4),(199,1),(199,2),(200,1),(200,2),(201,1),(201,2),(202,1),(202,2),(203,1),(203,2),(204,1),(204,2),(205,1),(205,2),(206,1),(206,2),(207,1),(207,2),(208,1),(208,2),(209,1),(209,2),(210,1),(210,2),(211,1),(211,2),(212,1),(212,2),(213,1),(213,2),(214,1),(214,2),(215,1),(216,1),(217,1),(218,1),(219,1),(220,1),(221,1),(222,1),(223,1),(224,1),(225,1),(226,1),(227,1),(228,1),(229,1),(230,1),(231,1),(232,1),(233,1),(234,1),(235,1),(236,1),(237,1),(238,1),(239,1),(240,1),(241,1),(242,1),(243,1),(244,1),(245,1),(246,1),(247,1),(248,1),(249,1),(250,1),(251,1),(252,1),(253,1),(254,1),(255,1),(256,2),(257,1),(258,1),(259,1),(260,1),(267,1),(266,1),(265,1),(264,1),(263,1),(262,1),(261,1),(268,1),(269,1),(270,1),(271,1),(272,1),(273,1),(274,1),(275,1),(276,1),(277,1),(278,1),(279,1),(280,1),(281,1),(282,1),(283,1),(284,1),(285,1),(286,1),(287,1),(288,1),(289,1),(290,1),(291,1),(292,1),(293,1),(294,1),(295,1),(296,1),(297,1),(298,1),(299,1),(300,1),(301,1),(302,1),(303,1),(304,1),(305,1),(306,1),(310,4),(309,2),(308,4),(307,4),(311,4),(312,4),(313,4),(314,4),(315,2),(316,4),(317,4);
/*!40000 ALTER TABLE `c2i` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c2k`
--

DROP TABLE IF EXISTS `c2k`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `c2k` (
  `composition_ID` int(8) unsigned NOT NULL,
  `keysig_ID` int(8) unsigned NOT NULL,
  KEY `composition_ID` (`composition_ID`),
  KEY `keysig_ID` (`keysig_ID`),
  CONSTRAINT `c2k_ibfk_1` FOREIGN KEY (`composition_ID`) REFERENCES `compositions` (`ID`),
  CONSTRAINT `c2k_ibfk_2` FOREIGN KEY (`keysig_ID`) REFERENCES `keysignatures` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c2k`
--

LOCK TABLES `c2k` WRITE;
/*!40000 ALTER TABLE `c2k` DISABLE KEYS */;
INSERT INTO `c2k` VALUES (94,2),(95,4),(96,14),(97,2),(98,3),(98,12),(99,24),(100,15),(101,12),(102,12),(103,16),(104,25),(105,23),(106,3),(106,15),(107,12),(108,24),(109,25),(110,3),(111,6),(112,3),(113,11),(114,24),(115,10),(116,17),(117,10),(118,25),(119,22),(120,24),(121,2),(122,2),(123,12),(124,2),(124,12),(125,10),(126,22),(127,7),(128,1),(129,6),(129,7),(130,5),(131,5),(132,13),(133,7),(134,13),(135,15),(136,10),(137,9),(138,15),(139,3),(140,2),(141,9),(142,5),(142,6),(143,9),(144,17),(145,2),(146,14),(147,24),(148,2),(149,2),(158,14),(157,6),(156,4),(155,2),(155,5),(154,4),(153,4),(152,3),(151,5),(150,2),(159,2),(160,2),(161,24),(162,13),(163,2),(163,12),(164,12),(165,25),(166,10),(167,12),(168,11),(169,24),(170,10),(171,12),(172,10),(172,12),(173,2),(173,9),(173,11),(173,12),(174,11),(175,13),(177,15),(176,14),(180,25),(178,3),(181,3),(182,14),(183,4),(184,3),(179,25),(185,2),(186,4),(187,3),(188,3),(189,2),(190,15),(191,4),(192,22),(193,6),(194,25),(195,23),(196,5),(197,24),(198,14),(199,2),(200,25),(201,22),(202,2),(203,15),(204,25),(205,23),(206,11),(207,15),(208,25),(209,11),(210,11),(211,15),(212,13),(213,14),(214,2),(215,22),(215,23),(215,25),(216,2),(217,2),(218,13),(219,17),(219,25),(220,12),(220,17),(221,2),(221,3),(221,4),(221,12),(221,13),(222,3),(222,14),(222,16),(222,23),(222,24),(223,15),(224,2),(225,12),(225,13),(226,2),(227,2),(228,14),(228,15),(229,3),(230,24),(231,2),(232,24),(233,14),(234,12),(235,2),(236,2),(236,3),(236,13),(237,14),(237,21),(237,22),(237,24),(237,25),(238,14),(239,23),(240,2),(240,14),(241,2),(242,15),(243,2),(244,2),(244,14),(245,14),(245,16),(245,20),(245,25),(246,14),(246,22),(246,23),(247,25),(248,2),(249,4),(249,12),(250,2),(250,12),(251,14),(252,2),(253,2),(253,9),(254,16),(254,21),(255,3),(256,23),(257,3),(257,10),(258,4),(259,14),(260,2),(260,3),(267,4),(267,11),(266,2),(266,4),(265,6),(265,13),(264,2),(263,4),(263,5),(262,3),(262,4),(261,3),(261,13),(268,5),(268,13),(269,2),(270,3),(270,13),(271,5),(272,3),(272,4),(273,14),(274,3),(275,5),(276,3),(277,25),(278,2),(278,13),(279,3),(280,13),(281,14),(282,9),(283,13),(284,2),(285,3),(286,4),(286,5),(287,14),(288,4),(289,4),(290,24),(291,5),(292,3),(293,5),(293,14),(294,7),(295,3),(295,12),(296,13),(297,5),(297,14),(297,17),(298,5),(299,4),(300,13),(301,25),(302,13),(303,14),(304,5),(304,14),(305,4),(305,12),(306,3),(310,3),(310,13),(309,2),(309,11),(308,3),(308,13),(307,4),(307,13),(311,13),(312,4),(312,6),(312,13),(313,3),(313,13),(314,3),(315,2),(316,3),(317,2);
/*!40000 ALTER TABLE `c2k` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c2r2p`
--

DROP TABLE IF EXISTS `c2r2p`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `c2r2p` (
  `composition_ID` int(8) unsigned NOT NULL,
  `role_ID` int(8) unsigned NOT NULL,
  `people_ID` int(8) unsigned NOT NULL,
  KEY `composition_ID` (`composition_ID`),
  KEY `role_ID` (`role_ID`),
  KEY `people_ID` (`people_ID`),
  CONSTRAINT `c2r2p_ibfk_1` FOREIGN KEY (`composition_ID`) REFERENCES `compositions` (`ID`),
  CONSTRAINT `c2r2p_ibfk_2` FOREIGN KEY (`role_ID`) REFERENCES `roles` (`ID`),
  CONSTRAINT `c2r2p_ibfk_3` FOREIGN KEY (`people_ID`) REFERENCES `people` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c2r2p`
--

LOCK TABLES `c2r2p` WRITE;
/*!40000 ALTER TABLE `c2r2p` DISABLE KEYS */;
INSERT INTO `c2r2p` VALUES (94,1,120),(95,1,121),(96,1,121),(97,1,122),(98,1,122),(99,1,123),(100,1,124),(101,1,124),(102,1,124),(103,1,124),(104,1,125),(105,1,124),(106,1,126),(107,1,126),(108,1,126),(109,1,127),(110,1,128),(111,1,128),(112,1,129),(113,1,129),(114,1,130),(115,1,129),(116,1,131),(117,1,131),(118,1,130),(119,1,131),(120,1,132),(121,1,132),(122,1,133),(123,1,133),(124,1,133),(125,1,133),(126,1,134),(127,1,134),(128,1,135),(129,1,136),(130,1,136),(131,1,137),(132,1,138),(133,1,139),(134,1,140),(135,1,141),(136,1,142),(137,1,143),(138,1,144),(139,1,145),(140,1,146),(141,1,147),(142,1,147),(143,1,148),(144,1,149),(145,1,150),(146,1,151),(147,1,152),(148,1,153),(149,1,153),(150,2,154),(151,2,155),(152,2,156),(153,1,157),(153,1,158),(153,2,159),(154,1,160),(154,2,159),(155,2,161),(156,1,162),(156,1,163),(156,2,161),(157,1,164),(157,1,165),(157,1,166),(157,1,167),(157,2,168),(157,2,169),(157,2,161),(158,1,170),(158,1,171),(158,1,163),(158,1,172),(158,1,173),(158,1,174),(158,1,175),(158,1,176),(158,1,177),(158,1,178),(158,2,168),(159,1,179),(159,3,180),(160,1,181),(160,2,182),(161,1,183),(161,1,184),(161,2,185),(162,1,159),(163,1,186),(163,2,187),(163,3,188),(164,1,189),(164,3,190),(165,1,189),(165,3,193),(166,1,194),(166,3,195),(167,1,194),(167,3,195),(168,1,189),(168,3,193),(169,1,189),(169,3,190),(170,1,189),(170,3,190),(171,1,189),(171,3,190),(172,1,197),(172,3,198),(173,1,199),(173,3,199),(174,1,181),(174,3,181),(175,1,189),(175,3,198),(176,1,200),(177,1,200),(178,1,129),(180,1,201),(179,2,200),(179,2,201),(181,1,202),(183,2,200),(183,2,201),(184,1,200),(185,1,203),(185,2,200),(185,2,201),(186,1,204),(186,2,200),(186,2,201),(187,1,200),(188,1,132),(188,2,200),(188,2,201),(189,1,205),(189,3,206),(189,2,200),(189,2,201),(190,1,187),(190,3,207),(191,1,209),(191,3,210),(191,3,209),(192,1,211),(192,3,211),(192,3,210),(193,1,212),(193,3,212),(193,3,213),(194,1,212),(194,3,212),(194,3,210),(195,1,212),(195,3,212),(195,3,210),(196,1,214),(196,3,214),(196,3,215),(197,1,216),(197,3,216),(197,3,210),(198,1,216),(198,3,216),(198,3,210),(199,1,217),(199,3,217),(199,3,210),(200,1,218),(200,3,218),(200,3,210),(201,1,219),(201,3,219),(201,3,210),(202,1,220),(202,3,220),(202,3,210),(203,1,221),(203,3,221),(203,3,210),(204,1,222),(204,3,222),(204,3,210),(205,1,223),(205,3,223),(205,3,210),(206,1,224),(206,3,224),(206,3,210),(207,1,226),(207,3,226),(207,3,210),(208,1,226),(208,3,226),(208,3,210),(209,1,227),(209,3,227),(209,3,210),(210,1,227),(211,1,227),(211,3,227),(211,3,210),(212,1,227),(212,3,227),(212,3,210),(213,1,228),(213,3,228),(213,3,215),(214,1,229),(214,3,229),(214,3,213),(215,1,230),(216,1,230),(217,1,230),(218,1,230),(219,1,230),(220,1,230),(221,1,230),(222,1,230),(223,1,230),(224,1,230),(225,1,230),(226,1,230),(227,1,230),(228,1,230),(229,1,230),(230,1,230),(231,1,230),(232,1,230),(233,1,230),(234,1,230),(235,1,230),(236,1,230),(237,1,230),(239,1,230),(240,1,230),(241,1,230),(242,1,230),(243,1,230),(244,1,230),(245,1,230),(246,1,230),(247,1,230),(248,1,230),(249,1,230),(250,1,230),(251,1,230),(252,1,230),(253,1,230),(254,1,230),(255,1,230),(256,1,231),(256,3,232),(257,2,233),(258,2,233),(259,1,234),(259,2,233),(260,2,233),(261,3,233),(262,2,233),(262,3,235),(262,3,236),(263,2,233),(264,1,237),(264,3,238),(264,2,233),(265,1,240),(265,3,241),(265,2,233),(266,2,233),(267,3,242),(267,1,237),(267,2,233),(268,1,237),(268,3,243),(268,2,233),(269,1,244),(269,2,233),(270,3,245),(270,1,246),(270,2,233),(271,1,132),(272,1,131),(273,1,247),(274,1,248),(275,1,139),(276,1,129),(278,1,249),(280,1,133),(281,1,133),(284,1,250),(285,1,251),(286,1,134),(287,1,139),(288,1,131),(289,1,252),(290,1,253),(291,1,136),(291,1,218),(292,1,130),(293,1,254),(294,1,129),(295,1,138),(297,1,130),(298,1,255),(299,1,256),(301,1,131),(302,1,257),(304,1,136),(305,1,258),(306,1,126),(307,1,189),(307,3,190),(308,1,189),(308,3,195),(309,1,189),(309,3,190),(310,1,189),(310,3,193),(311,1,194),(311,3,195),(312,1,189),(312,3,190),(313,1,259),(314,1,181),(315,1,189),(315,3,190),(316,1,181),(317,1,194),(317,3,195);
/*!40000 ALTER TABLE `c2r2p` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c2v`
--

DROP TABLE IF EXISTS `c2v`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `c2v` (
  `composition_ID` int(8) unsigned NOT NULL,
  `voice_ID` int(8) unsigned NOT NULL,
  KEY `composition_ID` (`composition_ID`),
  KEY `voice_ID` (`voice_ID`),
  CONSTRAINT `c2v_ibfk_1` FOREIGN KEY (`composition_ID`) REFERENCES `compositions` (`ID`),
  CONSTRAINT `c2v_ibfk_2` FOREIGN KEY (`voice_ID`) REFERENCES `voicing` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c2v`
--

LOCK TABLES `c2v` WRITE;
/*!40000 ALTER TABLE `c2v` DISABLE KEYS */;
/*!40000 ALTER TABLE `c2v` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compositions`
--

DROP TABLE IF EXISTS `compositions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compositions` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `comp_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `opus_like` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comp_num` int(8) unsigned DEFAULT NULL,
  `comp_no` int(8) unsigned DEFAULT NULL,
  `parent_comp_ID` int(8) unsigned DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_ID` int(8) unsigned DEFAULT NULL,
  `movement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `era_ID` int(8) unsigned NOT NULL,
  `voice_ID` int(8) unsigned NOT NULL,
  `ensemble_ID` int(8) unsigned NOT NULL,
  `physCompositionLoc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `parent_comp_ID` (`parent_comp_ID`),
  KEY `book_ID` (`book_ID`),
  KEY `era_ID` (`era_ID`),
  KEY `voice_ID` (`voice_ID`),
  KEY `ensemble_ID` (`ensemble_ID`),
  CONSTRAINT `compositions_ibfk_1` FOREIGN KEY (`parent_comp_ID`) REFERENCES `compositions` (`ID`),
  CONSTRAINT `compositions_ibfk_2` FOREIGN KEY (`book_ID`) REFERENCES `books` (`ID`),
  CONSTRAINT `compositions_ibfk_3` FOREIGN KEY (`era_ID`) REFERENCES `eras` (`ID`),
  CONSTRAINT `compositions_ibfk_4` FOREIGN KEY (`voice_ID`) REFERENCES `voicing` (`ID`),
  CONSTRAINT `compositions_ibfk_5` FOREIGN KEY (`ensemble_ID`) REFERENCES `ensembles` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=318 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compositions`
--

LOCK TABLES `compositions` WRITE;
/*!40000 ALTER TABLE `compositions` DISABLE KEYS */;
INSERT INTO `compositions` VALUES (94,'Prelude',NULL,NULL,NULL,NULL,'from Suite No. 5',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(95,'La Linotte Effarouchee',NULL,NULL,NULL,NULL,'The Startled Bird',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(96,'La Bandoline',NULL,NULL,NULL,NULL,NULL,39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(97,'Sonata','L.',104,NULL,NULL,NULL,39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(98,'Sonata','L.',90,NULL,NULL,NULL,39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(99,'L\'Egyptienne',NULL,NULL,NULL,NULL,NULL,39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(100,'Sinfonia 7',NULL,NULL,NULL,NULL,'Three- Voices Invention',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(101,'Praeludium 21',NULL,NULL,NULL,NULL,'From \"The Well-Tempered Clavier\", Part 1',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(102,'Fuga 21',NULL,NULL,NULL,NULL,'From \"The Well-Tempered Clavier\", Part 1',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(103,'Echo','BWV',831,NULL,NULL,'From the \"French Overture\"',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(104,'Fantasia',NULL,NULL,NULL,NULL,'In d minor',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(105,'Rondeaux',NULL,NULL,NULL,NULL,'From Partita No. 2',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(106,'Gigue',NULL,NULL,NULL,NULL,'From Suite No. 4',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(107,'Air and Variations',NULL,NULL,NULL,NULL,'From Suite No. 1 Book 2',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(108,'Ouverture',NULL,NULL,NULL,NULL,'From a Suite in G minor',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(109,'Allegro Assai',NULL,NULL,NULL,NULL,'From a Sonata in D minor',39,NULL,2,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(110,'Presto','HOB XVI',NULL,NULL,NULL,'From Sonata No. 40',39,NULL,3,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(111,'Tempo Di Menuetto','HOB XVI',NULL,NULL,NULL,'Finale from Sonata No. 22',39,NULL,3,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(112,'Two German Dances 1 & 2',NULL,NULL,12,NULL,'Edited by Denes Agay',39,NULL,3,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(113,'Bagatelle',NULL,NULL,NULL,NULL,NULL,39,NULL,3,12,1,NULL),(114,'Sonata','K.',312,NULL,NULL,NULL,39,NULL,3,12,1,NULL),(115,'Andante Con Variazioni',NULL,NULL,NULL,NULL,'From Sonata No. 12, Op. 26',39,NULL,3,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(116,'Two Landler',NULL,NULL,NULL,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(117,'Impromptu',NULL,NULL,NULL,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(118,'Fantasie',NULL,NULL,NULL,NULL,NULL,39,NULL,3,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(119,'Moment Musical','Opus',94,5,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(120,'Song Without Words','Opus',102,4,NULL,'\"Sighing Song\"',39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(121,'Song Without Words','Opus',102,3,NULL,'\"Tarantella\"',39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(122,'Fantasy Piece','Opus',111,3,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(123,'Friendly Landscape','Opus',82,5,NULL,'From \"Waldscenen\"',39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(124,'Romanze','Opus',26,2,NULL,'From \"Faschingsschwank aus Wien\"',39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(125,'The Elf','Opus',127,17,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(126,'Waltz','Opus',70,2,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(127,'Nocturne','Opus',32,1,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(128,'Appassionato',NULL,NULL,NULL,NULL,'(f#Major)',39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(129,'Two Waltzes','Opus',39,NULL,NULL,'No.\'s 1 & 2',39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(130,'Intermezzo','Opus',118,2,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(131,'Valse - Scherzo','Opus',59,2,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(132,'Conversation Piece','Opus',85,11,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(133,'Humoreske','Opus',61,2,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(134,'Scherzino',NULL,NULL,NULL,NULL,'\"Ballet of Unhatched Chickens\" From \"Pictures From and Exhibition\"',39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(135,'Once Upon a Time','Opus',44,3,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(136,'Scotch Poem','Opus',31,2,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(137,'Prelude','Opus',11,16,NULL,NULL,39,NULL,5,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(138,'Album Leaf','Opus',2,4,NULL,NULL,39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(139,'Spanish Dance','Opus',5,2,NULL,'\"Minueto\" from \"Danzas Espanoles\"',39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(140,'Postludium','Opus',13,10,NULL,'From  \"Winterreigen\"',39,NULL,4,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(141,'Clair De Lune',NULL,NULL,3,NULL,'From \"Suite Bergamasque\"',39,NULL,5,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(142,'First Arabesque',NULL,NULL,NULL,NULL,'From \"Two Arabesques\"',39,NULL,5,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(143,'Menuet',NULL,NULL,NULL,NULL,'From Sonatine',39,NULL,5,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(144,'Gavotte','Opus',32,3,NULL,NULL,39,NULL,5,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(145,'Fantastic Dance',NULL,NULL,3,NULL,NULL,39,NULL,5,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(146,'Prelude','Opus',38,2,NULL,NULL,39,NULL,5,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(147,'Armenian Dance',NULL,NULL,NULL,NULL,NULL,39,NULL,5,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(148,'Bagatelle','Opus',6,2,NULL,NULL,39,NULL,5,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(149,'See-Saw','Opus',9,NULL,NULL,'From \"Seven Sketches\"',39,NULL,5,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"Classics to Moderns\"'),(150,'The Boatman Dance',NULL,NULL,NULL,NULL,NULL,40,NULL,7,31,8,'File Cabinet: Alphabetical by Title / \"Boatman Dance, The\"'),(151,'Happy Birthday',NULL,NULL,NULL,NULL,NULL,40,NULL,7,12,4,'File Cabinet: Alphabetical by Title / \"Happy Birthday\"'),(152,'Ring of Fire',NULL,NULL,NULL,NULL,NULL,40,NULL,7,5,4,'File Cabinet: Alphabetical by Title / \"Ring of Fire\"'),(153,'Runaround Sue',NULL,NULL,NULL,NULL,NULL,40,NULL,7,5,4,'File Cabinet: Alphabetical by Title / \"Runaround Sue\"'),(154,'The Longest Time',NULL,NULL,NULL,NULL,NULL,40,NULL,7,5,4,'File Cabinet: Alphabetical by Title / \"Longest Time, The\"'),(155,'Bright Lights Bigger City / Magic',NULL,NULL,NULL,NULL,'Featured in the movie Pitch Perfect',40,NULL,7,5,4,'File Cabinet: Alphabetical by Title / \"Bright Lights Bigger City / Magic\"'),(156,'Since U Been Gone',NULL,NULL,NULL,NULL,'Featured in the movie Pitch Perfect',40,NULL,7,5,4,'File Cabinet: Alphabetical by Title / \"Since U Been Gone\"'),(157,'Don\'t Stop the Music',NULL,NULL,NULL,NULL,'From Universal Studios Motion Picture Pitch Perfect',40,NULL,7,5,4,'File box: Alphabetical by title - \"Don\'t Stop the Music\"'),(158,'Right Round',NULL,NULL,NULL,NULL,'From the Universal Studios Motion Picture Pitch Perfect',40,NULL,7,5,4,'File Cabinet: Alphabetical by Title / \"Right Round\"'),(159,'Peg O\' My Heart',NULL,NULL,NULL,NULL,'(Mixed Voices)',41,NULL,7,8,4,'File Cabinet: Alphabetical by Title / \"Peg O\' My Heart\"'),(160,'Short People',NULL,NULL,NULL,NULL,'King Singers 25th Anniversary Jubilee!',41,NULL,7,8,4,'File Cabinet: Alphabetical by Title / \"Short People\"'),(161,'Can\'t Buy Me Love',NULL,NULL,NULL,NULL,'For SATB a cappella',41,NULL,7,8,4,'File box: Alphabetical by title - \"Can\'t Buy Me Love\"'),(162,'Hello Sunshine',NULL,NULL,NULL,NULL,'SSA with Piano and Optional Rhythm Section',42,NULL,7,2,9,'File Cabinet: Alphabetical by Title / \"Hello Sunshine\"'),(163,'America, The Beautiful',NULL,NULL,NULL,NULL,'Three-Part Mixed, with opt. Baritone, accompanied',43,NULL,7,8,9,'File Cabinet: Alphabetical by Title / \"America, The Beautiful\"'),(164,'Be Our Guest',NULL,NULL,NULL,NULL,'From Walt Disney\'s Beauty and the Beast',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(165,'The Bells of Notre Dame',NULL,NULL,NULL,NULL,'From Walt Disney\'s The Hunchback of Notre Dame',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(166,'Can You Feel the Love Tonight',NULL,NULL,NULL,NULL,'From Walt Disney Pictures\' The Lion King',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(167,'I Just Can\'t Wait to be King',NULL,NULL,NULL,NULL,'from Walt Disney Pictures\' The Lion King',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(168,'Colors of the Wind',NULL,NULL,NULL,NULL,'from Walt Disney\'s Pocahontas',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(169,'Friend Like Me',NULL,NULL,NULL,NULL,'from Walt Disney\'s Aladdin',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(170,'Part of Your World',NULL,NULL,NULL,NULL,'from Walt Disney\'s The Little Mermaid',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(171,'Under the Sea',NULL,NULL,NULL,NULL,'from Walt Disney\'s The Little Mermaid',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(172,'Reflection',NULL,NULL,NULL,NULL,'Pop Version - From Walt Disney Pictures\' MULAN',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(173,'You\'ll be in My Heart',NULL,NULL,NULL,NULL,'Pop Version - From Walt Disney Pictures\' TARZAN',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(174,'You\'ve Got a Friend in Me',NULL,NULL,NULL,NULL,'from Walt Disney\'s TOY STORY',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(175,'Zero to Hero',NULL,NULL,NULL,NULL,'from Walt Disney Pictures\' HERCULES',44,NULL,7,12,7,'Book Shelf: Instrument Anthologies / Trombone-Baritone / Alphabetical by Title / \"Disney Solos\"\"'),(176,'The Medieval Piper',NULL,NULL,NULL,NULL,NULL,45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(177,'Mysterious Ballet',NULL,NULL,NULL,NULL,NULL,45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(178,'German Dance',NULL,NULL,NULL,NULL,'Original Form',45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(179,'Tum-Balalaika',NULL,NULL,NULL,NULL,'Jewish Folk Song',45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(180,'Whispers of the Wind',NULL,NULL,NULL,NULL,NULL,45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(181,'Minuet in G',NULL,NULL,NULL,NULL,'from the Notebook for Anna Magdalena Bach - Original form',45,NULL,3,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(182,'Hava Nagila',NULL,NULL,NULL,NULL,'Hebrew Folk Song',45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(183,'All Through the Night',NULL,NULL,NULL,NULL,'Traditional Welsh Air',45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(184,'100 Degree Blues',NULL,NULL,NULL,NULL,NULL,45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(185,'Blue Danube Waltz',NULL,NULL,NULL,NULL,NULL,45,NULL,4,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(186,'Fascination',NULL,NULL,NULL,NULL,NULL,45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(187,'Bagatelle in G',NULL,NULL,NULL,NULL,NULL,45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(188,'On Wings of Song',NULL,NULL,NULL,NULL,'Primo & Secundo',45,NULL,4,12,2,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(189,'The Star-Spangled Banner',NULL,NULL,NULL,NULL,NULL,45,NULL,7,12,1,'Book Shelf: Piano Method / Alphabetical by Title / \"Faber Piano Adventures\" / Level 3B / Performance'),(190,'Blow, Bugle, Blow',NULL,NULL,NULL,NULL,'Two or Three-part Equal Voices and Piano',43,NULL,7,32,9,'File Cabinet: Alphabetical by Title / \"Blow, Bugle. Blow\"'),(191,'Per la gloria d\'adorarvi - For the Love my heart doth prize',NULL,NULL,NULL,NULL,'from the opera \"Griselda\"',46,NULL,2,29,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(192,'Amarilli, mia bella - Amarilli, my fair one',NULL,NULL,NULL,NULL,'Madrigal',46,NULL,1,29,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(193,'Alma del core - Fairest adored',NULL,NULL,NULL,NULL,NULL,46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(194,'Come raggio di sol - As on the swelling wave',NULL,NULL,NULL,NULL,'Aria',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(195,'Sebben, crudele - Tho\' not deserving',NULL,NULL,NULL,NULL,'Canzonetta',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(196,'Vittoria, mio core! - Victorious my heart is!',NULL,NULL,NULL,NULL,'Cantata',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(197,'Danza, danza, fanciulla gentile - Dance, Dance, maiden gay',NULL,NULL,NULL,NULL,'Arietta',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(198,'Vergin, tutto amor - Virgin, fount of love',NULL,NULL,NULL,NULL,'Preghiera - Prayer',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(199,'Caro mio ben - Thou, all my bliss',NULL,NULL,NULL,NULL,'Arietta',46,NULL,7,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(200,'O del mio dolce ardor - I thou belov\'d',NULL,NULL,NULL,NULL,'Aria',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(201,'Che fiero costume - How void of compassion',NULL,NULL,NULL,NULL,'Arietta',46,NULL,1,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(202,'Pur dicesti, o bocca bella - Mouth so charmful',NULL,NULL,NULL,NULL,'Arietta',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(203,'Il mio bel foco - My joyful ardor',NULL,NULL,NULL,NULL,'Recitativo ed Aria',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(204,'Non posso disperar - I do not dare despond',NULL,NULL,NULL,NULL,'Arietta',46,NULL,1,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(205,'Lasciatemi morire! - No longer let me languish!',NULL,NULL,NULL,NULL,'Canto from the opera \"Ariana\"',46,NULL,1,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(206,'Nel cor piu non mi sento - Why feels my heart so dormant',NULL,NULL,NULL,NULL,'Arietta',46,NULL,3,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(207,'Se tu m\'ami, se sospiri - If thou lov\'st me',NULL,NULL,NULL,NULL,'Arietta',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(208,'Nina',NULL,NULL,NULL,NULL,'Canzonetta',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(209,'Gia il sole dal Gange - O\'er Ganges now launches',NULL,NULL,NULL,NULL,'Canzonetta',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(210,'Le Violette - The Violets',NULL,NULL,NULL,NULL,'Canzone',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(211,'O cessate di piagarmi - O no longer seek to pain me',NULL,NULL,NULL,NULL,'Arietta',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(212,'Se Florindo e fedele - Should Florindo be faithful',NULL,NULL,NULL,NULL,'Arietta',46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(213,'Pieta, Signore! - O Lord, have mercy',NULL,NULL,NULL,NULL,NULL,46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(214,'Tu lo sai - Ask thy heart',NULL,NULL,NULL,NULL,NULL,46,NULL,2,12,7,'Book Shelf: Vocal Anthologies / Alphabetical by Title / \"Twenty-Four Italian Songs and Arias\"'),(215,'Across the Stars',NULL,NULL,NULL,NULL,'Love Theme from STAR WARS: ATTACK OF THE CLONES',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(216,'Theme From Angela\'s Ashes',NULL,NULL,NULL,NULL,'Paramount Pictures and Universal Pictures International Present ANGELA\'S ASHES',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Anthology, The\"'),(217,'The Book Thief',NULL,NULL,NULL,NULL,'from THE BOOK THIEF',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(218,'Cantina Band',NULL,NULL,NULL,NULL,'from STAR WARS: A NEW HOPE',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(219,'Born on the Fourth of July',NULL,NULL,NULL,NULL,'from BORN ON THE FOURTH OF JULY',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(220,'Catch Me if you Can',NULL,NULL,NULL,NULL,'from the DreamWorks film CATCH ME IF YOU CAN',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(221,'Cowboys, The',NULL,NULL,NULL,NULL,'from the Motion Picture THE COWBOYS',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(222,'The Duel',NULL,NULL,NULL,NULL,'from the Paramount Pictures film THE ADVENTURES OF TINTIN',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(223,'Duel of the Fates',NULL,NULL,NULL,NULL,'from STAR WARS: THE PHANTOM MENACE',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(224,'Theme From E.T. (The Extra-Terrestrial)',NULL,NULL,NULL,NULL,'from the Universal Picture E.T. (THE EXTRA-TERRESTRIAL)',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(225,'Far and Away (Main Theme)',NULL,NULL,NULL,NULL,'from the Universal Motion Picture FAR AND AWAY',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(226,'Flight to Neverland',NULL,NULL,NULL,NULL,'from HOOK',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(227,'Harry\'s Wondrous World',NULL,NULL,NULL,NULL,'from HARRY POTTER AND THE SORCERER\'S STONE',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(228,'Hedwig\'s Theme',NULL,NULL,NULL,NULL,'from the Motion Picture HARRY POTTER AND THE SORCERER\'S STONE',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(229,'Hymn to the Fallen',NULL,NULL,NULL,NULL,'from the Paramount and DreamWorks Motion Picture SAVING PRIVATE RYAN',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(230,'The Imperial March (Darth Vadar\'s Theme)',NULL,NULL,NULL,NULL,'from STAR WARS: THE EMPIRE STRIKES BACK',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(231,'Theme from \"JAWS\"',NULL,NULL,NULL,NULL,'from the Universal Picture JAWS',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(232,'The Jedi Steps and Finale',NULL,NULL,NULL,NULL,'from STAR WARS: THE FORCE AWAKENS',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(233,'Theme From J.F.K',NULL,NULL,NULL,NULL,'Warner Bros. presents and OLIVER STONE film J.F.K',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(234,'Theme From \"Jurassic Park\"',NULL,NULL,NULL,NULL,'from the Universal Motion Picture JURASSIC PARK',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(235,'Luke And Leia',NULL,NULL,NULL,NULL,'from STAR WARS: RETURN OF THE JEDI',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(236,'The March From \"1941\"',NULL,NULL,NULL,NULL,NULL,47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(237,'March of the Resistance',NULL,NULL,NULL,NULL,'from STAR WARS: THE FORCE AWAKENS',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(238,'Nimbus 2000',NULL,NULL,NULL,NULL,'from the Motion Picture HARRY POTTER AND THE SORCERER\'S STONE',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(239,'May the Force Be With You',NULL,NULL,NULL,NULL,'from STAR WARS: A NEW HOPE',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(240,'The Mission Theme',NULL,NULL,NULL,NULL,'from NBC NEWS',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(241,'Olympic Fanfare and Theme',NULL,NULL,NULL,NULL,'Commissioned by the 1984 Los Angeles Olympic Organizing Committee',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(242,'A Prayer for Peace',NULL,NULL,NULL,NULL,'from MUNICH',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(243,'Raiders March',NULL,NULL,NULL,NULL,'from the Paramount Motion Picture RAIDERS OF THE LOST ARK',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(244,'Scherzo for Motorcycle and Orchestra',NULL,NULL,NULL,NULL,'from INDIANA JONES AND THE LAST CRUSADE',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(245,'Rey\'s Theme',NULL,NULL,NULL,NULL,'from STAR WARS: THE FORCE AWAKENS',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(246,'Sayuri\'s Theme and End Credits',NULL,NULL,NULL,NULL,'from MEMOIRS OF A GEISHA',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(247,'Theme From \"Schindler\'s List\"',NULL,NULL,NULL,NULL,'from the Universal Motion Picture SCHINDLER\'S LIST',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(248,'Seven Years in Tibet',NULL,NULL,NULL,NULL,'from the Motion Picture SEVEN YEARS IN TIBET',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(249,'Somewhere in my Memory',NULL,NULL,NULL,NULL,'from the Twentieth Century Fox Motion Picture HOME ALONE',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(250,'Star Wars (Main Theme)',NULL,NULL,NULL,NULL,'from STAR WARS',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(251,'Sophie\'s Theme',NULL,NULL,NULL,NULL,'from THE BFG',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(252,'Theme From \"Superman\"',NULL,NULL,NULL,NULL,'from SUPERMAN',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(253,'The Throne Room',NULL,NULL,NULL,NULL,'from STAR WARS: A NEW HOPE',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(254,'Wide Receiver',NULL,NULL,NULL,NULL,'from NBC NFL FOOTBALL THEMES',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(255,'With Malice Toward None',NULL,NULL,NULL,NULL,'from Motion Picture LINCOLN',47,NULL,7,12,1,'Book Shelf: Piano Anthologies / Alphabetical by Title / \"John Williams Piano Anthology, The\"'),(256,'Carol of the Bells (Pentatonix Version)',NULL,NULL,NULL,NULL,'PTX Carol of the Bells',41,NULL,7,8,4,'File Cabinet: Alphabetical by Title / \"Carol of the Bells\"'),(257,'Angels We Have Heard On High',NULL,NULL,NULL,NULL,'Traditional',48,NULL,7,12,2,'Book Shelf: Piano Anthologies / Christmas / Piano Duets / Alphabetical by Title / \"Christmas Encores for Two\"'),(258,'Still, Still, Still',NULL,NULL,NULL,NULL,'Ancient Welsh Tune',48,NULL,7,12,2,'Book Shelf: Piano Anthologies / Christmas / Piano Duets / Alphabetical by Title / \"Christmas Encores for Two\"'),(259,'Carol of the Bells',NULL,NULL,NULL,NULL,NULL,48,NULL,7,12,2,'Book Shelf: Piano Anthologies / Christmas / Piano Duets / Alphabetical by Title / \"Christmas Encores for Two\"'),(260,'Merry Christmas Medley',NULL,NULL,NULL,NULL,NULL,48,NULL,7,12,2,'Book Shelf: Piano Anthologies / Christmas / Piano Duets / Alphabetical by Title / \"Christmas Encores for Two\"'),(261,'Amazing Grace',NULL,NULL,NULL,NULL,'Traditional',49,NULL,7,12,18,'Book Shelf: Piano Anthologies / Religious / Alphabetical by Title / \"A Call to Prayer\"'),(262,'Be Still My Soul / It is Well with my Soul',NULL,NULL,NULL,NULL,NULL,49,NULL,7,12,1,'Book Shelf: Piano Anthologies / Religious / Alphabetical by Title / \"A Call to Prayer\"'),(263,'Be Thou My Vision',NULL,NULL,NULL,NULL,'Traditional Irish Melody',49,NULL,7,12,1,'Book Shelf: Piano Anthologies / Religious / Alphabetical by Title / \"A Call to Prayer\"'),(264,'He Leadeth Me',NULL,NULL,NULL,NULL,NULL,49,NULL,7,12,1,'Book Shelf: Piano Anthologies / Religious / Alphabetical by Title / \"A Call to Prayer\"'),(265,'I Surrender All',NULL,NULL,NULL,NULL,NULL,49,NULL,7,12,1,'Book Shelf: Piano Anthologies / Religious / Alphabetical by Title / \"A Call for Prayer\"'),(266,'Just a Closer Walk with Thee',NULL,NULL,NULL,NULL,'Traditional',49,NULL,7,12,1,'Book Shelf: Piano Anthologies / Religious/ Alphabetical by Title / \"A Call to Prayer\"'),(267,'Just as I Am',NULL,NULL,NULL,NULL,NULL,49,NULL,7,12,1,'Book Shelf: Piano Anthologies / Religious / Alphabetical by Title / \"A Call to Prayer\"'),(268,'Sweet Hour of Prayer',NULL,NULL,NULL,NULL,NULL,49,NULL,7,12,1,'Book Shelf: Piano Anthologies / Religious / Alphabetical by Title / \"A Call to Prayer\"'),(269,'Turn Your Eyes Upon Jesus',NULL,NULL,NULL,NULL,NULL,49,NULL,7,12,1,'Book Shelf: Piano Anthologies / Religious / Alphabetical by Title / \"A Call to Prayer\"'),(270,'What a Friend we have in Jesus',NULL,NULL,NULL,NULL,NULL,49,NULL,7,12,1,'Book Shelf: Piano Anthologies / Religious / Alphabetical by Title / \"A Call to Prayer\"'),(271,'Spring Song','Opus',62,6,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(272,'March Militaire','Opus',51,1,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(273,'Romance',NULL,NULL,NULL,NULL,'From the Opera, \"The Pearl Fishers\"',50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(274,'A Song of India',NULL,NULL,NULL,NULL,'Chanson Indoue',50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(275,'Norwegian Dance','Opus',35,2,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(276,'Minuet in G',NULL,NULL,NULL,NULL,NULL,50,NULL,3,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(277,'Two Guitars',NULL,NULL,NULL,NULL,NULL,50,NULL,7,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(278,'Berecuse',NULL,NULL,NULL,NULL,'(Jocelyn)',50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(279,'Turkey in the Straw',NULL,NULL,NULL,NULL,'American Folk Dance',50,NULL,7,12,18,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(280,'Traumerei',NULL,NULL,NULL,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(281,'Romanze',NULL,NULL,NULL,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(282,'Funeral March (March Funebre)','Opus',35,NULL,NULL,'From Sonata Op. 35',50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(283,'Country Gardens',NULL,NULL,NULL,NULL,'English Folk Dance',50,NULL,7,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(284,'Sonatina',NULL,NULL,NULL,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(285,'Aragonaise',NULL,NULL,NULL,NULL,'From the Ballet \"Le Cid\"',50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(286,'Polonaise (A Major)','Opus',40,1,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(287,'Anitra\'s Dance','Opus',46,3,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(288,'Theme',NULL,NULL,NULL,NULL,'from Unfinished Symphony',50,NULL,3,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(289,'Waltz (Faust)',NULL,NULL,NULL,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(290,'Orientale','Opus',50,9,NULL,'From \"Kaleidoscope\"',50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(291,'Gavotte',NULL,NULL,NULL,NULL,'*Brahms make this lovely arrangement of this Gavotte from a Gluck Opera.',50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(292,'Minuet (Don Juan)',NULL,NULL,NULL,NULL,NULL,50,NULL,3,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(293,'La Cinquantaine (The Golden Wedding)',NULL,NULL,NULL,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(294,'Turkish March',NULL,NULL,NULL,NULL,'From \"The Ruins of Athens\"',50,NULL,3,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(295,'Humoresque','Opus',101,7,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(296,'Londonderry Air',NULL,NULL,NULL,NULL,'Irish Melody',50,NULL,7,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(297,'Rondo alla Turca',NULL,NULL,NULL,NULL,NULL,50,NULL,3,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(298,'Entr\'acte-Gavotte',NULL,NULL,NULL,NULL,'From \"Mignon\"',50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(299,'Sextette (Lucia di Lammermoor)',NULL,NULL,NULL,NULL,NULL,50,NULL,3,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(300,'Viennese Melody',NULL,NULL,NULL,NULL,NULL,50,NULL,7,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(301,'Serenade',NULL,NULL,NULL,NULL,NULL,50,NULL,3,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(302,'Melody in F',NULL,NULL,NULL,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(303,'Jungarian Dance',NULL,NULL,5,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(304,'Hungarian Dance',NULL,NULL,5,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(305,'Poet and Peasant Overture',NULL,NULL,NULL,NULL,NULL,50,NULL,4,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(306,'Largo',NULL,NULL,NULL,NULL,NULL,50,NULL,2,12,2,'Book Shelf: Piano / General Ensemble / Alphabetical by Title / \"Piano Duets\"'),(307,'Belle',NULL,NULL,NULL,NULL,'From Walt Disney\'s BEAUTY AND THE BEAST',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney'),(308,'A Whole New World',NULL,NULL,NULL,NULL,'From Walt Disney\'s ALADDIN',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney'),(309,'Prince Ali',NULL,NULL,NULL,NULL,'From Walt Disney\'s ALADDIN',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney'),(310,'God Help the Outcasts',NULL,NULL,NULL,NULL,'From Walt Disney\'s THE HUNCHBACK OF NOTRE DAME',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney'),(311,'Hakuna Matata',NULL,NULL,NULL,NULL,'From Walt Disney Pictures\' THE LION KING',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney'),(312,'Beauty and the Beast',NULL,NULL,NULL,NULL,'From Walt Disney\'s BEAUTY AND THE BEAST',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney'),(313,'Cruella De Vil',NULL,NULL,NULL,NULL,'From Walt Disney\'s ONE HUNDRED AND ONE DALMATIONS',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney'),(314,'When She Loved Me',NULL,NULL,NULL,NULL,'From Walt Disney Pictures\' TOY STORY 2 - A Pixar Film',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney'),(315,'Kiss the Girl',NULL,NULL,NULL,NULL,'From Walt Disney\'s THE LITTLE MERMAID',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney'),(316,'If I Didn\'t Have You',NULL,NULL,NULL,NULL,'Walt Disney Pictures Presents A Pixar Animation Studios Film MONSTERS, INC.',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney'),(317,'Go the Distance',NULL,NULL,NULL,NULL,'From Walt Disney Pictures\' HERCULES',51,NULL,7,12,7,'Book Shelf: Violin / Alphabetical by Composer / Disney');
/*!40000 ALTER TABLE `compositions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `difficulties`
--

DROP TABLE IF EXISTS `difficulties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `difficulties` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `org_ID` int(8) unsigned DEFAULT NULL,
  `difficulty_level` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `org_ID` (`org_ID`),
  CONSTRAINT `difficulties_ibfk_1` FOREIGN KEY (`org_ID`) REFERENCES `organizations` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `difficulties`
--

LOCK TABLES `difficulties` WRITE;
/*!40000 ALTER TABLE `difficulties` DISABLE KEYS */;
INSERT INTO `difficulties` VALUES (1,1,'EE'),(2,1,'E'),(3,1,'LE'),(4,1,'EI'),(5,1,'I'),(6,1,'LI'),(7,1,'EA'),(8,1,'A'),(9,1,'LA'),(10,1,'none'),(11,2,'1'),(12,2,'1-2'),(13,2,'2'),(14,2,'2-3'),(15,2,'3'),(16,2,'3-4'),(17,2,'4'),(18,2,'4-5'),(19,2,'5'),(20,2,'5-6'),(21,2,'6'),(22,2,'6-7'),(23,2,'7'),(24,2,'7-8'),(25,2,'8'),(26,2,'8-9'),(27,2,'9'),(28,2,'9-10'),(29,2,'10'),(30,2,'10-11'),(31,2,'11'),(32,2,'11-12'),(33,2,'12'),(34,2,'none');
/*!40000 ALTER TABLE `difficulties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ensembles`
--

DROP TABLE IF EXISTS `ensembles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ensembles` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `ensemble_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ensembles`
--

LOCK TABLES `ensembles` WRITE;
/*!40000 ALTER TABLE `ensembles` DISABLE KEYS */;
INSERT INTO `ensembles` VALUES (1,'Solo'),(2,'Duet'),(3,'Trio'),(4,'Quartet'),(5,'Quintet'),(6,'Ensemble'),(7,'Solo-Accompanied'),(8,'Duet-Accompanied'),(9,'Trio-Accompanied'),(10,'Quartet-Accompanied'),(11,'Quintet-Accompanied'),(12,'Ensemble-Accompanied'),(13,'Band'),(14,'Orchestra'),(15,'Choir'),(16,'Choir-Accompanied'),(17,'Other'),(18,'none');
/*!40000 ALTER TABLE `ensembles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eras`
--

DROP TABLE IF EXISTS `eras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eras` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eras`
--

LOCK TABLES `eras` WRITE;
/*!40000 ALTER TABLE `eras` DISABLE KEYS */;
INSERT INTO `eras` VALUES (1,'Ancient pre-1600'),(2,'Baroque 1600-1750'),(3,'Classical 1750-1820'),(4,'Romantic 1780-1910'),(5,'Modern 1890-1930'),(6,'Contemporary 1930-present'),(7,'none');
/*!40000 ALTER TABLE `eras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genres` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `genre_type` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` VALUES (1,'none'),(2,'Jazz'),(3,'Christmas'),(4,'Halloween'),(5,'Blues'),(6,'Rag'),(7,'Pop'),(8,'Country'),(9,'Madrigal'),(10,'Technique'),(11,'Method Book'),(12,'Classical'),(13,'Broadway Tunes'),(14,'Folk Music'),(15,'Popular Music'),(16,'Instrumental'),(17,'Gospel/Christian'),(18,'Swing'),(19,'Orchestra'),(20,'Band'),(21,'Commercial (Jingles, Movie and TV themes)'),(22,'Disney'),(23,'Easy Listening'),(24,'Latin'),(25,'Opera'),(26,'R&B Soul'),(27,'Rock'),(28,'Easter'),(29,'Birthday'),(30,'Patriotic'),(31,'ThanksGiving'),(32,'Irish'),(33,'Other Alternative'),(34,'Barbershop (male)'),(35,'Barbershop (female)'),(36,'Barbershop (mixed)'),(37,'Vocal a cappella'),(38,'Religious');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `innodb_monitor`
--

DROP TABLE IF EXISTS `innodb_monitor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `innodb_monitor` (
  `a` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `innodb_monitor`
--

LOCK TABLES `innodb_monitor` WRITE;
/*!40000 ALTER TABLE `innodb_monitor` DISABLE KEYS */;
/*!40000 ALTER TABLE `innodb_monitor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instruments`
--

DROP TABLE IF EXISTS `instruments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instruments` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `instr_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruments`
--

LOCK TABLES `instruments` WRITE;
/*!40000 ALTER TABLE `instruments` DISABLE KEYS */;
INSERT INTO `instruments` VALUES (1,'Piano'),(2,'Voice'),(3,'Trumpet'),(4,'Violin'),(5,'Viola'),(6,'Guitar'),(7,'none'),(8,'Cello'),(9,'Bass'),(10,'Harp'),(11,'French Horn'),(12,'Trombone'),(13,'Tuba'),(14,'Cornet'),(15,'Sousaphone'),(16,'Saxaphone'),(17,'Flute'),(18,'Recorder'),(19,'Oboe'),(20,'Clarinet'),(21,'Bassoon'),(22,'Piccolo'),(23,'Timpani'),(24,'Xylophone'),(25,'Marimba'),(26,'Vibraphone'),(27,'Glockenspiel'),(28,'Cymbals'),(29,'Castinets'),(30,'Bass Drum'),(31,'Tambourine'),(32,'Gong'),(33,'Chimes'),(34,'Celesta'),(35,'Triangle'),(36,'Snare Drum'),(37,'Bells hand'),(38,'Bells, resonator'),(39,'Tom, floor'),(40,'Tom Toms'),(41,'Drum Set'),(42,'Bongos'),(43,'Boom Whackers'),(44,'Organ'),(45,'Synthesizer'),(46,'Harpsichord'),(47,'Clavichord'),(48,'Guitar, Acou'),(49,'Guitar, elec'),(50,'Djembe'),(51,'Other Alternative'),(52,'Baritone');
/*!40000 ALTER TABLE `instruments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keysignatures`
--

DROP TABLE IF EXISTS `keysignatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `keysignatures` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `key_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keysignatures`
--

LOCK TABLES `keysignatures` WRITE;
/*!40000 ALTER TABLE `keysignatures` DISABLE KEYS */;
INSERT INTO `keysignatures` VALUES (1,'none'),(2,'CM'),(3,'GM'),(4,'DM'),(5,'AM'),(6,'EM'),(7,'BM'),(8,'GbM'),(9,'DbM'),(10,'AbM'),(11,'EbM'),(12,'BbM'),(13,'FM'),(14,'am'),(15,'em'),(16,'bm'),(17,'f#m'),(18,'c#m'),(19,'g#m'),(20,'ebm'),(21,'bbm'),(22,'fm'),(23,'cm'),(24,'gm'),(25,'dm');
/*!40000 ALTER TABLE `keysignatures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organizations` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `org_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizations`
--

LOCK TABLES `organizations` WRITE;
/*!40000 ALTER TABLE `organizations` DISABLE KEYS */;
INSERT INTO `organizations` VALUES (1,'General',NULL),(2,'ASP',NULL),(46,'Amsco Publications','London / New York / Sydney'),(47,'Hal Leonard','7777 W. Bluemound Rd. P.0. Box 13819 Milwaukee, WI 53213'),(48,'G. Schirmer, Inc.','New York, New York  USA'),(49,'Alfred Publishing Co., Inc.','USA'),(50,'THE FJH MUSIC COMPANY INC.','2525 Davie Road, Suite 360 , Fort Lauderdale, Florida 33317-7424, USA');
/*!40000 ALTER TABLE `organizations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `people` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middlename` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=260 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (119,'Denes',NULL,'Agay',NULL),(120,'Henry',NULL,'Purcell',NULL),(121,'Francois',NULL,'Couperin',NULL),(122,'Domenico',NULL,'Scarlatti',NULL),(123,'Jean','Phillipe','Rameau',NULL),(124,'Johann','Sebastian','Bach',NULL),(125,'Georg','Philipp','Telemann',NULL),(126,'George','Frideric','Handel',NULL),(127,'Carl','Philipp Emanuel','Bach',NULL),(128,'Joseph',NULL,'Haydn',NULL),(129,'Ludwig',NULL,'van Beethoven',NULL),(130,'Wolfgang','Amadeus','Mozart',NULL),(131,'Franz','Peter','Schubert',NULL),(132,'Felix',NULL,'Mendelssohn',NULL),(133,'Robert',NULL,'Schumann',NULL),(134,'Frederic','Francois','Chopin',NULL),(135,'Franz',NULL,'Liszt',NULL),(136,'Johannes',NULL,'Brahms',NULL),(137,'Peter','Illyich','Tchaikovsky',NULL),(138,'Antonin','Leopold','Dvorak',NULL),(139,'Edvard','Hagerup','Grieg',NULL),(140,'Modest','P.','Mussorgsky',NULL),(141,'Max',NULL,'Reger',NULL),(142,'Edward',NULL,'MacDowell',NULL),(143,'Alexander',NULL,'Skriabin',NULL),(144,'Bedrich',NULL,'Smetana',NULL),(145,'Enrique',NULL,'Granados',NULL),(146,'Erno','von','Dohnanyi',NULL),(147,'Claude',NULL,'Debussy',NULL),(148,'Maurice',NULL,'Ravel',NULL),(149,'Sergei',NULL,'Prokofieff',NULL),(150,'Dmitri',NULL,'Shostakovich',NULL),(151,'Dmitri',NULL,'Kabalevsky',NULL),(152,'Aram',NULL,'Khatchaturian',NULL),(153,'Bela',NULL,'Bartok',NULL),(154,'Jill',NULL,'Gallina',NULL),(155,'Michael','Dean','Haynie',NULL),(156,'Stephen','J.','Calgaro',NULL),(157,'Ernie',NULL,'Marasca',NULL),(158,'Dion',NULL,'Di Mucci',NULL),(159,'Roger',NULL,'Emerson',NULL),(160,'Billy',NULL,'Joel',NULL),(161,'Deke',NULL,'Sharon',NULL),(162,'Martin',NULL,'Sandberg',NULL),(163,'Lukasz',NULL,'Gottwald',NULL),(164,'Tor','Erik','Hermansen',NULL),(165,'Frankie',NULL,'Storm',NULL),(166,'Mikkel',NULL,'Eriksen',NULL),(167,'Michael',NULL,'Jackson',NULL),(168,'Ed',NULL,'Boyer',NULL),(169,'Ben',NULL,'Bram',NULL),(170,'Tramar',NULL,'Dillard',NULL),(171,'Philip',NULL,'Lawrence',NULL),(172,'Allan',NULL,'Grigg',NULL),(173,'Bruno',NULL,'Mars',NULL),(174,'Justin',NULL,'Franks',NULL),(175,'Peter',NULL,'Burns',NULL),(176,'Stephan',NULL,'Coy',NULL),(177,'Timothy',NULL,'Lever',NULL),(178,'Michael',NULL,'Percy',NULL),(179,'Fred',NULL,'Fischer',NULL),(180,'Alfred',NULL,'Bryan',NULL),(181,'Randy',NULL,'Newman',NULL),(182,'Simon',NULL,'Carrington',NULL),(183,'John',NULL,'Lennon',NULL),(184,'Paul',NULL,'McCartney',NULL),(185,'Keith',NULL,'Abbs',NULL),(186,'Samuel','A.','Ward',NULL),(187,'Ruth','Elaine','Schram',NULL),(188,'Katherine','Lee','Bates',NULL),(189,'Alan',NULL,'Menken',NULL),(190,'Howard',NULL,'Ashman',NULL),(191,NULL,NULL,NULL,NULL),(192,NULL,NULL,NULL,NULL),(193,'Stephen',NULL,'Schwartz',NULL),(194,'Elton',NULL,'John',NULL),(195,'Tim',NULL,'Rice',NULL),(196,'Howard',NULL,'Ashman',NULL),(197,'Matthew',NULL,'Wilder',NULL),(198,'David',NULL,'Zippel',NULL),(199,'Phil',NULL,'Collins',NULL),(200,'Nancy',NULL,'Faber',NULL),(201,'Randall',NULL,'Faber',NULL),(202,'Christian',NULL,'Petzold',NULL),(203,'Johann',NULL,'Strauss','Jr.'),(204,'Fermo','Dante','Marchetti',NULL),(205,'John','Stafford','Smith',NULL),(206,'Francis','Scott','Key',NULL),(207,'Alfred','Lord','Tennyson',NULL),(208,NULL,NULL,NULL,NULL),(209,'Giovanni','Battista','Bononcini',NULL),(210,'Theodore ',NULL,'Baker',', Dr.'),(211,'Guilio',NULL,'Caccini',NULL),(212,'Antonio',NULL,'Caldara',NULL),(213,'Everett',NULL,'Helm',NULL),(214,'Giacomo',NULL,'Carissimi',NULL),(215,'H.',NULL,'Millard',NULL),(216,'Francesco',NULL,'Durante',NULL),(217,'Giuseppe',NULL,'Giordani',NULL),(218,'Christoph','Willibald Ritter','von Gluck',NULL),(219,'Giovanni',NULL,'Legrenzi',NULL),(220,'Antonio',NULL,'Lotti',NULL),(221,'Benedetto',NULL,'Marcello',NULL),(222,'S.',NULL,'De Luca',NULL),(223,'Claudio',NULL,'Monteverdi',NULL),(224,'Giovanni',NULL,'Paisiello',NULL),(225,NULL,NULL,NULL,NULL),(226,'Giovanni','Battista','Pergolesi',NULL),(227,'Alessandro',NULL,'Scarlatti',NULL),(228,'Alessandro',NULL,'Stradella',NULL),(229,'Giuseppe',NULL,'Torelli',NULL),(230,'John',NULL,'Williams',NULL),(231,'MyKola',NULL,'Leontovych',NULL),(232,'Peter','J.','Wilhousky',NULL),(233,'Melody',NULL,'Bober',NULL),(234,'M.',NULL,'Leontovich',NULL),(235,'Katharina',NULL,'von Schlegel',NULL),(236,'Jean',NULL,'Sibelius',NULL),(237,'William','B.','Bradbury',NULL),(238,'Joseph','H.','Gilmore',NULL),(239,NULL,NULL,NULL,NULL),(240,'Winfield','S.','Weeden',NULL),(241,'Judson','W.','Van DeVenter',NULL),(242,'Charlotte',NULL,'Elliot',NULL),(243,'William','W.','Walford',NULL),(244,'Helen','H.','Lemmel',NULL),(245,'Jospeh','M.','Scriven',NULL),(246,'Charles','C.','Converse',NULL),(247,'Georges',NULL,'Bizet',NULL),(248,'Nikolai',NULL,'Rimsky-Korsakov',NULL),(249,'Benjamin','Louis Paul','Goddard',NULL),(250,'Carl','Maria','von Weber',NULL),(251,'Jules','Emile Frederic','Massenet',NULL),(252,'Charles','Francois','Gounod',NULL),(253,'Cesar','Antonovich','Cui',NULL),(254,'Jean','Prosper','Gabriel-Marie',NULL),(255,'Charles','Louis Ambroise','Thomas',NULL),(256,'Domenico','Geotano Maria','Donizetti',NULL),(257,'Anton','Grigoryevich','Rubinstein',NULL),(258,'Franz (Francesco)','Ezechiele Ermenegildo','von Suppe',NULL),(259,'Mel',NULL,'Leven',NULL);
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Composer'),(2,'Arranger'),(3,'Lyricist'),(4,'Editor'),(5,'Publisher');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `idUsers` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uidUsers` tinytext NOT NULL,
  `emailUsers` tinytext NOT NULL,
  `pwdUsers` longtext NOT NULL,
  PRIMARY KEY (`idUsers`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'Nose','grindstone@nose.com','$2y$10$t0kzhFGPYycaTHHGFKikYO6jKR8R3rB70Ml1tXN98XB34C9RZMyMu');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voicing`
--

DROP TABLE IF EXISTS `voicing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `voicing` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `voicing_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voicing`
--

LOCK TABLES `voicing` WRITE;
/*!40000 ALTER TABLE `voicing` DISABLE KEYS */;
INSERT INTO `voicing` VALUES (1,'SA'),(2,'SSA'),(3,'SSAA'),(4,'ST'),(5,'TTBB'),(6,'SB'),(7,'SAB'),(8,'SATB'),(9,'TTB'),(10,'TBB'),(11,'TB'),(12,'none'),(13,'S'),(14,'A'),(15,'T'),(16,'B'),(17,'SAA'),(18,'STB'),(19,'SAT'),(20,'SAB'),(21,'AT'),(22,'AB'),(23,'ATB'),(24,'TT'),(25,'TTBB'),(26,'BB'),(27,'TTB'),(28,'HighVoice'),(29,'MediumVoice'),(30,'LowVoice'),(31,'2-part'),(32,'3-part mixed');
/*!40000 ALTER TABLE `voicing` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-26  6:22:47
