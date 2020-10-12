-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: SampleCatalogit2
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
-- Current Database: `SampleCatalogit2`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `SampleCatalogit2` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `SampleCatalogit2`;

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
INSERT INTO `b2r2o` VALUES (1,5,3),(2,5,4),(7,5,5),(8,5,8),(8,5,9),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(8,5,8),(14,5,30),(14,5,25),(15,5,21),(15,5,25),(19,5,25),(14,5,25),(14,5,36),(14,5,3),(3,5,5),(26,5,36),(26,5,38),(26,5,39),(27,5,6),(28,5,40),(14,5,28),(34,5,44),(34,5,38),(34,5,43),(35,5,7),(30,5,18),(30,5,45),(34,5,19),(38,5,3);
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
INSERT INTO `b2r2p` VALUES (2,4,7),(8,4,27),(8,4,28),(8,4,27),(15,4,30),(14,4,82),(15,4,13),(15,4,36),(20,4,43),(19,4,13),(3,4,6),(26,4,96),(28,4,97),(34,4,102),(34,4,103),(34,4,104),(35,4,105),(30,4,60),(30,4,55),(38,4,116),(38,4,117),(38,4,118);
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
  `tag1` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag2` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_vol` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_num` int(8) unsigned DEFAULT NULL,
  `physBookLoc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'Scale Book ','10 Innovative Piano Solos using Major and Minor Scales with 3 to 7 Sharps','','',2,NULL),(2,'Czerny Exercises','Practical Method for Beginners on the Piano Forte.','Schirmer/s Library of Musical Classics','Volume 146',NULL,NULL),(3,'Classics to Moderns','Original piano music of three centuries',NULL,NULL,47,'Book: Shelf / Piano Anthologies / Alphabetical by Title / Classics to Moderns'),(6,'Piano Duets','Everybodys Favorite Series','','',7,NULL),(7,'Piano Duets','Everybody\'s Favorite Series','','',7,'Book: Shelf / Ensembles: Piano Duet / Anthologies / Alphabetical By Title / \'Piano Duets\''),(8,'Piano Adventures','The Basic Piano Method','','Lesson Book',1,NULL),(9,'Piano Adventures','The Basic Basic Piano Method','','Lesson Book',1,NULL),(10,'Piano Adventures','The Basic Basic Piano Method','','Lesson Book',1,NULL),(11,'Sample test Book 1','Sample tag1','sample tag 2','',40,NULL),(13,'Happy Days are Here again','Ha! finally working!','Sweet!','',788,NULL),(14,'AppleBees\'s','Isn\'t this somethin\' &quot;Hey Barn&quot;?','Cattchican','twenty-Two',34,'Book Shelf: Piano Anthologies/Alphabetical by Title/&quot;AppleBees\'s&quot;'),(15,'New York, New York','Start Spreading','the news','We\'re coming today',45,NULL),(16,'Fun with Dick and Jane','Sample tag1','sample tag 2','',40,NULL),(17,'Sheet Music Sample Collection','asdasd','asdasd','ONE',56,NULL),(18,'Sheet Music Sample Collection','sdsd','sdfds','ONE',56,NULL),(19,'Sheet Music Sample Collection','Some of our family favorites','','ONE',1,'Various locations: each composition is filed with sheet music'),(20,'Sheet Music Sample Vocal Collection','SATB','','TWO',51,NULL),(23,'Test Book',NULL,NULL,NULL,NULL,NULL),(24,'Scooby Doo',NULL,NULL,NULL,23,NULL),(26,'Shaggy\'s Biography',NULL,NULL,NULL,45,NULL),(27,'Disney Movie Hits','violin','solo arrangements with CD accompaniment',NULL,NULL,'bookshelf/movies'),(28,'The Top 50 of 1982','From Columbia Pictures Publications','Easy Piano Pop',NULL,NULL,'Book Shelf: Vocal Anthologies/Alphabetical by Title/ Top 50 of 1982'),(30,'Patti\'s \"Crazy\" book of \"Quotes\"','Can you count all the \"Quotes\" and \"apostrophe\'s\"?','Doin\' my best to \"test\" all this stuff.','10',250,'Book Shelf: Piano Anthologies/Alphabetical by Title/\"Patti\'s \"CRAZY\" book of \"Quotes\"'),(31,'Just Another','Testing for',NULL,'Thirty three',NULL,'Book Shelf:'),(33,'LyricistsOnly','A book for Lyricists Alone',NULL,'one',1,'All by itself'),(34,'Test101','Isn\'t this somethin\'?','Doin\' my best to \"test\" all this stuff.','four',NULL,'Bella\'s \"Twilight\" Episode'),(35,'Lush Life / What\'s New',NULL,NULL,NULL,NULL,'Shelf: Vocal Anthology / Alphabetical by Artist / Ronstadt, Linda / Lush Life'),(36,'The Basic Book of Scales, Chords, Arpeggios & Cadences','Includes all the Major, Minor (Natural, Harmonic, Melodic) & Chromatic Scales','Alfred\'s Basic Piano Library',NULL,NULL,'Book Shelf: Piano Reference Alphabetically by Title - Scales'),(37,'The Basic Book of Scales, Chords, Arpeggios & Cadences','Includes all the Major, Minor (Natural, Harmonic, Melodic) & Chromatic Scales','Alfred\'s Basic Piano Library',NULL,NULL,'Book Shelf: Piano Reference Alphabetically by Title - Scales'),(38,'The Basic Book of Scales, Chords, Arpeggios & Cadences','Includes all the Major, Minor (Natural, Harmonic, Melodic) & Chromatic Scales','Alfred\'s Basic Piano Library',NULL,NULL,'Book Shelf: Piano Reference -  Alphabetically by Title - Scales');
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
INSERT INTO `c2d` VALUES (1,21),(1,5),(2,23),(2,6),(3,21),(3,5),(4,21),(4,5),(5,17),(5,4),(6,17),(6,4),(7,28),(7,8),(32,6),(32,22),(38,22),(38,6),(42,22),(42,6),(43,24),(43,10),(55,24),(55,10),(57,34),(57,10),(58,34),(58,1),(60,34),(60,10),(62,4),(62,24),(64,10),(64,23),(66,6),(66,23),(67,10),(67,34),(68,10),(68,34),(69,10),(69,34),(70,10),(70,34),(71,10),(71,34),(72,10),(72,34),(61,10),(61,34),(9,9),(9,32),(8,8),(8,28),(74,7),(74,25),(77,10),(77,34),(78,6),(78,20),(76,10),(76,34),(75,3),(75,26),(79,5),(79,19),(80,10),(80,27),(82,10),(82,34),(83,10),(83,34),(84,10),(84,34),(85,3),(85,24),(90,10),(90,34),(91,4),(91,24),(92,1),(92,34),(93,10),(93,34);
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
INSERT INTO `c2g` VALUES (1,10),(2,10),(3,10),(4,10),(5,10),(6,10),(32,12),(38,12),(43,12),(55,12),(58,2),(58,7),(58,8),(60,1),(42,12),(62,12),(63,12),(64,12),(65,12),(66,11),(66,12),(61,1),(9,12),(8,12),(74,12),(77,1),(78,6),(76,1),(75,22),(75,6),(79,22),(80,20),(82,4),(83,3),(84,29),(85,13),(90,1),(91,8),(92,20),(93,35),(93,36),(93,5),(93,3),(93,21);
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
INSERT INTO `c2i` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(32,1),(38,1),(43,1),(55,1),(58,1),(58,2),(58,6),(60,1),(60,2),(42,1),(62,1),(63,1),(64,1),(65,1),(66,1),(66,3),(61,7),(9,1),(8,1),(74,1),(77,7),(78,3),(76,7),(75,16),(75,5),(79,4),(80,43),(80,29),(80,34),(82,38),(83,43),(84,42),(85,2),(90,1),(90,2),(91,14),(92,9),(93,44),(93,22),(93,16),(93,36),(93,31);
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
INSERT INTO `c2k` VALUES (1,14),(2,17),(3,15),(4,18),(6,23),(5,23),(32,5),(38,4),(42,14),(43,3),(55,5),(58,2),(58,4),(58,5),(58,25),(60,2),(62,4),(63,2),(63,13),(64,3),(65,13),(66,9),(66,10),(61,1),(9,23),(8,25),(74,3),(74,24),(77,1),(78,7),(76,1),(75,6),(75,18),(79,4),(79,12),(80,3),(80,15),(82,3),(82,15),(83,9),(84,5),(85,2),(90,2),(91,23),(92,2),(93,10),(93,12),(93,14),(93,16),(93,18);
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
INSERT INTO `c2r2p` VALUES (1,1,1),(2,1,1),(3,1,1),(4,1,1),(5,1,2),(6,1,2),(7,1,3),(42,1,17),(58,1,74),(58,1,54),(58,2,30),(58,3,55),(58,1,75),(58,2,76),(58,3,77),(55,1,26),(60,2,84),(42,1,4),(63,1,85),(65,1,86),(66,1,87),(66,3,26),(66,2,58),(66,2,18),(61,1,93),(9,1,5),(8,1,4),(74,1,94),(75,1,4),(75,2,10),(75,3,17),(78,1,1),(78,2,1),(78,3,1),(76,1,1),(76,1,15),(75,1,14),(75,2,7),(75,3,15),(83,3,98),(83,2,99),(83,1,100),(87,3,101),(88,1,10),(88,3,11),(85,1,55),(75,2,55),(79,3,55),(90,3,74),(93,2,83),(93,2,83);
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
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compositions`
--

LOCK TABLES `compositions` WRITE;
/*!40000 ALTER TABLE `compositions` DISABLE KEYS */;
INSERT INTO `compositions` VALUES (1,'Sailing the Open Sea!','',NULL,NULL,NULL,'',1,'',7,12,12,NULL),(2,'Midnight Forest','',NULL,NULL,NULL,'',1,'',7,12,12,NULL),(3,'Mountain Sunrise','',NULL,NULL,NULL,'',1,'',7,12,12,NULL),(4,'Cry of the Whippoorwill','',NULL,NULL,NULL,'',1,'',7,12,12,NULL),(5,'Czerny','Opus',599,58,NULL,'Exercises for the Attainment of Freedom and Agility',2,'',3,12,12,NULL),(6,'Czerny','Opus',599,36,NULL,'Exercises with Sharps and Flats',2,'',3,12,12,NULL),(7,'Impromptu','Opus',142,2,NULL,'',3,'',7,12,12,NULL),(8,'Fantasie','K.',397,NULL,NULL,'',3,'',7,12,18,'Book Shelf: Piano Anthologies / Alphabetical by Title / \'Classics to Moderns\''),(9,'See-Saw','Opus',9,NULL,NULL,'Seven Sketches',3,'',7,12,18,'Book Shelf: Piano Anthologies / Alphabetical by Title / Classics to Moderns / See-Saw'),(32,'Spring Song','Opus',62,6,NULL,'',7,'',3,12,2,NULL),(38,'Marche Militaire','Opus',51,1,NULL,'',7,'',4,12,2,NULL),(42,'Romance','',0,0,NULL,'From the Opera, &quot;The Pearl Fishers&quot;',7,'',4,12,2,NULL),(43,'A Song of India','',0,0,NULL,'Chanson Indoue',7,'',4,12,2,NULL),(55,'Norwegian Dance','Opus',35,2,NULL,'',7,'',4,12,2,NULL),(57,'','',0,0,NULL,'',14,'',7,12,18,NULL),(58,'New Composition','Opus',45,100,NULL,'New New comp',14,'The Wearin\' o\' the Green',6,4,16,NULL),(60,'The Boatman Dance','',0,0,NULL,'',14,'',7,11,17,NULL),(61,'Minuet in G','',NULL,NULL,NULL,'',7,'',7,12,18,''),(62,'Two Guitars','sdfdf',6,65,NULL,'sdfdsd',7,'sdfdfds',7,12,11,'Book: Shellfzzzzzzzz'),(63,'Berceuse','',NULL,0,NULL,'Jocelyn',7,'',4,12,2,'Book: Shelf / Piano Ensembles / Alphabetical by Title / \'Piano Duets\''),(64,'Turkey in the Straw','',NULL,NULL,NULL,'American Folk Dance',7,'',3,12,2,'Book: Shelf / Piano Ensembles / Alphabetical by Title / \'Piano Duets\''),(65,'Traumerei','',NULL,NULL,NULL,'',7,'',4,12,2,'Book: Shelf / Piano Ensembles / Alphabetical by Title / \'Piano Duets\''),(66,'Funeral march','Sonata,  Opus',35,35,NULL,'Marche Funebre',7,'Movement',4,3,2,'Book: Shelf / Piano Ensembles / Alphabetical by Title / \'Piano Duets\''),(67,'','',NULL,NULL,NULL,'',19,'',7,12,18,''),(68,'','',NULL,NULL,NULL,'',19,'',7,12,18,''),(69,'','',NULL,NULL,NULL,'',19,'',7,12,18,''),(70,'','',NULL,NULL,NULL,'',19,'',7,12,18,''),(71,'','',NULL,NULL,NULL,'',19,'',7,12,18,''),(72,'','',NULL,NULL,NULL,'',19,'',7,12,18,''),(74,'Spanish Dance','opus',5,NULL,NULL,'&quot;Minueto&quot; from &quot;Danzas Espanoles&quot;',3,'',4,12,18,'Book Shelf: Piano Anthologies / Alphabetical by Title / Classics to Moderns / \'Spanish Dance\''),(75,'Testing','testing',100,200,NULL,'testing',23,'testing',2,3,2,'testing'),(76,'Trial',NULL,NULL,NULL,NULL,NULL,23,NULL,7,12,18,NULL),(77,'Try it Again!',NULL,100,100,NULL,NULL,23,NULL,7,12,18,NULL),(78,'Try it Again!','K',45,45,NULL,'testing',23,'testing',3,3,13,'Testing'),(79,'Belle',NULL,NULL,NULL,NULL,'From Walt Disney\'s BEAUTY AND THE BEAST',27,NULL,5,12,7,'bookshelf'),(80,'fakeitfakeit','Opus',33,45,NULL,'Fake book',1,'One fake movement at a time',1,3,18,'BookShelf: BoomWhacker Anthologies: alphabetical by Title: Fakeitfakeit'),(82,'How many',NULL,NULL,NULL,NULL,NULL,30,NULL,7,12,18,NULL),(83,'How can these \"Quotes\" keep stopping my \"Mojo\" guy\'s?',NULL,NULL,NULL,NULL,NULL,30,NULL,7,12,18,NULL),(84,'How many \"Roads\" can a man\'s walk down??',NULL,NULL,NULL,NULL,NULL,30,'Let\'s see if \"rodas\" works here.',7,12,18,NULL),(85,'That\'s Life',NULL,NULL,NULL,NULL,'That\'s what people \"say\"',30,NULL,3,3,9,'Try\'n out my apostrophe and \"quote\" test'),(86,'It\'s a wonderful \"Wonderful\" life!',NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,14,18,'dfgfd'),(87,'Lyricist Lullabye',NULL,NULL,NULL,NULL,NULL,33,NULL,1,2,3,'On the shelf all alone'),(88,'When I Fall in Love',NULL,NULL,NULL,NULL,NULL,35,NULL,6,13,7,'Shelf: Vocal Anthologies / Alphabetical by Artist / Rondstadt, Linda / Lush Life'),(90,'The Boat Man Dance',NULL,NULL,NULL,NULL,'Great male duet',13,NULL,6,11,18,'File box: Alphabetical by title - Boatman Dance, the'),(91,'Runner\'s Sonata',NULL,10,6,NULL,'Fastest mile run',30,NULL,1,5,11,'Near my sneakers'),(92,'Spooky Boo Song',NULL,NULL,NULL,NULL,NULL,30,NULL,1,1,1,'Filing Cabinet: Alphabetical by Title - Spooky Boo Song'),(93,'Run Spider Run','Opus',35,23,NULL,'Faster than Lightning',34,'Prestissimo',7,12,18,NULL);
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
  `genre_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` VALUES (1,'none'),(2,'Jazz'),(3,'Christmas'),(4,'Halloween'),(5,'Blues'),(6,'Rag'),(7,'Pop'),(8,'Country'),(9,'Madrigal'),(10,'Technique'),(11,'Method Book'),(12,'Classical'),(13,'Broadway Tunes'),(14,'Folk Music'),(15,'Popular Music'),(16,'Instrumental'),(17,'Gospel/Christian'),(18,'Swing'),(19,'Orchestra'),(20,'Band'),(21,'Commercial (Jingles, Movie and Tv themes'),(22,'Disney'),(23,'Easy Listening'),(24,'Latin'),(25,'Opera'),(26,'R&B Soul'),(27,'Rock'),(28,'Easter'),(29,'Birthday'),(30,'Patriotic'),(31,'ThanksGiving'),(32,'Irish'),(33,'Other Alternative'),(34,'Barbershop (male)'),(35,'Barbershop (female)'),(36,'Barbershop (mixed)');
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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruments`
--

LOCK TABLES `instruments` WRITE;
/*!40000 ALTER TABLE `instruments` DISABLE KEYS */;
INSERT INTO `instruments` VALUES (1,'Piano'),(2,'Voice'),(3,'Trumpet'),(4,'Violin'),(5,'Viola'),(6,'Guitar'),(7,'none'),(8,'Cello'),(9,'Bass'),(10,'Harp'),(11,'French Horn'),(12,'Trombone'),(13,'Tuba'),(14,'Cornet'),(15,'Sousaphone'),(16,'Saxaphone'),(17,'Flute'),(18,'Recorder'),(19,'Oboe'),(20,'Clarinet'),(21,'Bassoon'),(22,'Piccolo'),(23,'Timpani'),(24,'Xylophone'),(25,'Marimba'),(26,'Vibraphone'),(27,'Glockenspiel'),(28,'Cymbals'),(29,'Castinets'),(30,'Bass Drum'),(31,'Tambourine'),(32,'Gong'),(33,'Chimes'),(34,'Celesta'),(35,'Triangle'),(36,'Snare Drum'),(37,'Bells hand'),(38,'Bells, resonator'),(39,'Tom, floor'),(40,'Tom Toms'),(41,'Drum Set'),(42,'Bongos'),(43,'Boom Whackers'),(44,'Organ'),(45,'Synthesizer'),(46,'Harpsichord'),(47,'Clavichord'),(48,'Guitar, Acou'),(49,'Guitar, elec'),(50,'Djembe'),(51,'Other Alternative');
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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizations`
--

LOCK TABLES `organizations` WRITE;
/*!40000 ALTER TABLE `organizations` DISABLE KEYS */;
INSERT INTO `organizations` VALUES (1,'General',NULL),(2,'ASP',NULL),(3,'Alfred Publishing Co., Inc.','New York, USA'),(4,'G. Schirmer, Inc.',''),(5,'Amsco Publications','London / New York / Sydney'),(6,'Hal Leonard Corporation','7777 W.Bluemound rd. p.o. Box 13819 Milwaukee, WI 53213'),(7,'Warner Bros. Publications Inc.',''),(8,'Hal Leonard','USA'),(9,'Hal Leonard','USA'),(10,'PublisherBuilding','PublisherPlace'),(11,'Pubabubiddy','Pubabub USA'),(12,'Peanut Bbutter Publishing Co.','PBJ USA'),(13,'WubbyWubby Publisher Inc','Wubby USA'),(14,'TryAgain Publisher','TryAgain USA'),(15,'SamalamaDingDong Publishing','Sammy USA'),(16,'Replacement Publisher','Replacement USA'),(17,'Salamazoo Publishing','Salamazoo Seuss'),(18,'Cartoon Publishing','Cartoon USA'),(19,'Cartoon Publishing','Cartoon USA'),(20,'Pumpkin Publishing','Pumpkin Arizona, USA'),(21,'Pancake House Publishing','Pancake Washington, USA'),(22,'Final Straw Publishing and Editing','Armpit Oklahoma, USA'),(23,'Final Straw Publishing and Editing','Armpit Oklahoma, USA'),(24,'End of the Line Publishing','BrownsVille TX, USA'),(25,'PaintCan Publishing','Canvas, USA'),(26,'PaintCan Publishing','Canvas, USA'),(27,'St. Haynie Publishing Co.','Mama\'s City, NewZealand'),(28,'Donald Duck Publishers','Anaheim, CA'),(29,'Mickey Mouse Productions','Anaheim CA, USA'),(30,'Think Positive Publishing Co.','Cheery Indiana, USA'),(31,'Sunny Day Publishing','SunnyDee CA, USA'),(32,'Lightyear Productions','Hollywood CA, USA'),(33,'Finicky Finnigan Printing and Publishing','Blumburg City, Ireland'),(34,'Spirit Publishing Co.','Gary Indiana USA'),(35,'Confederate Publishing Organization','Georgia USA'),(36,'Sweetrock Pebble Publishing','Sweetwater Colorado USA'),(37,'Yosemite National Park','Alaska, USA'),(38,'Elemental Publishing Co.','Paris Idaho, USA'),(39,'Fire Cracker Publishing','Hot Springs CA, USA'),(40,'Columbia Pictures Publications','16333 N.W.54th Ave., Hialeah, Florida 33014'),(41,'{fn_encode()}franny','{fn_encode()}'),(42,'Sunny Day Publishing','Tampa bay Florida, USA'),(43,'Equate Publishing Co.','Wiltbank Missouri, USA'),(44,'Kentucky Gold Pubco','Roundup Kentucky, USA'),(45,'RunRun Pub','New York, New York  USA');
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
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,'Mike','Bike','Springer','Singer'),(2,'Carl','','Czerny',''),(3,'Franz','Peter','Schubert',''),(4,'Wolfgang','Amadeus','Mozart',''),(5,'Bela','','Bartok',''),(6,'Denes','','Agay',''),(7,'Giuseppe','','Buonamici',''),(8,'','','Pentatonix',''),(9,'','','Pentatonix',''),(10,'Victor','','Young',''),(11,'Edward','','Heyman',''),(12,'Richard','','Rodgers',''),(13,'Lorenz','','Hart',''),(14,'Hoagy','','Carmichael',''),(15,'Johnny','','Mercer',''),(16,'Roy','','Turk',''),(17,'Georges','','Bizet',''),(18,'Georges','','Bizet',''),(19,'Nicholai','Andreyevich','Rimsky-Korsakov',''),(20,'Nicholai','Andreyevich','Rimsky-Korsakov',''),(21,'Nicholai','Andreyevich','Rimsky-Korsakov',''),(22,'Nicholai','Andreyevich','Rimsky-Korsakov',''),(23,'Nicholai','Andreyevich','Rimsky-Korsakov',''),(24,'Nicholai','Andreyevich','Rimsky-Korsakov',''),(25,'Nicholai','Andreyevich','Rimsky-Korsakov',''),(26,'Edvard','Hagerup','Grieg',''),(27,'Nancy/Randall','','Faber',''),(28,'Nancy/Randall','','Faber',''),(29,'Eddie','','EditorGuy',''),(30,'Benjamin','Button','Broadway','Jr.'),(31,'Benjamin','Button','Broadwayway','Jr.'),(32,'Pear','Banana','Orange','Squish'),(33,'Agay','','Agay',''),(34,'Fred','','Flintstone',''),(35,'Barbara','Lungs','Streissand',''),(36,'Chunky','funky','Monkey',''),(37,'Bananna','Fanna','Ramma',''),(38,'Apple','','Jack',''),(39,'Mrs.','','Butterworth',''),(40,'Replace','Replace','Replace','Replace'),(41,'Replace','Existing','Editor','fortheloveofMike!'),(42,'Someday','MyPrincess','William','Come'),(43,'French','Fried','Onions','MMMM!'),(44,'','','',''),(45,'','','',''),(46,'','','',''),(47,'','','',''),(48,'Caann','Dee','Followman','III'),(49,'Chunky','LickenChicken','Soup',''),(50,'Boston','Phil','Harmonic',''),(51,'William','BillyBoy','CartWright','II'),(52,'Little','Bo','Peep',''),(53,'Fred','Freakin','Astaireatyeollday','the GREAT!'),(54,'Louis','LillyPut','Pasteur','ccc'),(55,'Larry','photo','Lurie','ccc'),(56,'Larry','photo','Lurie','ccc'),(57,'Larry','photo','Lurie','ccc'),(58,'Larry','photo','Lurie','ccc'),(59,'Tinsley','Carter','Freimann','jr.'),(60,'Tinsley','Carter','Presley','jr.'),(61,'Tinsley','Carter','Presley','jr.'),(62,'Tinsley','Carter','Sandman','jr.'),(63,'Scarlett','Sink Me!','Pimpernell',''),(64,'Tinsley','Carter','Finch','jr.'),(65,'Trader','Cateror','Joe',''),(66,'Trader','Caterer','Joe','jr.'),(67,'Happy','Fred','Carter','jr.'),(68,'Altoid','WinterBlue','Largess',''),(69,'Larry','Lurie','Lyricist','HaHa'),(70,'At','Last','Finally',''),(71,'Sampson','and','Deliela',''),(72,'Sissy','Missy','Spacek',''),(73,'Tracy','','FumBlatt',''),(74,'John','Angel','Travolta','Mamma'),(75,'Jack','Black','Sparrow','Flack'),(76,'Jane','','Austen',''),(77,'Heathcliffe','','Huxtable',''),(78,'Bruce','RockStar','Springsteen',''),(79,'Hugo','Yo','Growler',''),(80,'Hugo','Fitz','Growler',''),(81,'Hugo','Yo','Fitch',''),(82,'Barney','Trouble','Rubble',''),(83,'Winslow','Puffington','Quackenbush',''),(84,'Jill','','Gallina',''),(85,'Benjamin','','Godard',''),(86,'Robert','','Schumann',''),(87,'Francoise','Frederic','Chopin',''),(88,'Marc','Gold','Spitz','USA'),(89,'Kristin','Lynn','Chenowith','Her Majesty'),(90,'Iron','Tony','Man','Stark'),(91,'Loosey','Goosey','Zeusy','the Moosey'),(92,'Shaquille','Rashaun (who knew?)','O\'Neil','\'Shaq\''),(93,'Ludwig','von','Beethoven',''),(94,'Enrique','','Granados',''),(95,'Johnny','moneypenny','Cash','III'),(96,'Johnny','moneypenny','Cash','III'),(97,'Carol',NULL,'Cuellor',NULL),(98,'Louis',NULL,'L\'mour',NULL),(99,'Pepe',NULL,'L\'peu',NULL),(100,'Laurence',NULL,'B\'ceau',NULL),(101,'Philippe','Dartanagan','Lawrence',': Muskateer'),(102,'Frank\'s','\"Frank\"','Sinatra\'s','\"Millionaire\"'),(103,'Frank\'s','\"Frankie Boy\"','Sinatra\'s','\"Millionaire\'sBoy\"'),(104,'Another','Trial','Editor','\"The Third\"'),(105,'EddyEdymyman','Englemannnn','Editor',NULL),(106,'Galinda','the','Good','\"Heh-Heh\"'),(107,'TheWicked','WitchOfThe','West','\"My Little Pretty!\"'),(108,'Luna',NULL,'Lovegood',NULL),(109,'Bellatrix',NULL,'Lestrange',NULL),(110,'Samantha',NULL,'Stevens',NULL),(111,'Ginny',NULL,'Weasley',NULL),(112,'Ron',NULL,'Weasley',NULL),(113,'Mary',NULL,'Poppins',NULL),(114,'Sybill',NULL,'Trelawney',NULL),(115,'Endora','Endora','Endora','Endora'),(116,'Willard','A.','Palmer',NULL),(117,'Morton',NULL,'Manus',NULL),(118,'Amanda','Vick','Lethco',NULL);
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
INSERT INTO `users` VALUES (1,'SamIAm','samiam@sammy.com','$2y$10$KYlH7ygyIz0vCZtRw87wMO0pX0wUEDGC/Xk/q8ogphUsudexQql2u'),(2,'fido','fido@fido.com','$2y$10$sWp9ToGtPNr5gKR78pVj8e0npQORzByMwfi2/3h7HV8fShdy4Nsf2'),(3,'NewMe','newme@newme.com','$2y$10$oaE2lHMi0ueLvuqxX2RVvemVVJKcR2aYs/4rh.RVgNTur0n2X5KBS'),(4,'Nose','grindstone@nose.com','$2y$10$t0kzhFGPYycaTHHGFKikYO6jKR8R3rB70Ml1tXN98XB34C9RZMyMu'),(5,'curlicue','curlicue@curlicue.com','$2y$10$lepP45zhAZvJ0.mE2NipLeHl1Mpe28uiSAsAOx5oLb7FBGWLVDUqS');
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voicing`
--

LOCK TABLES `voicing` WRITE;
/*!40000 ALTER TABLE `voicing` DISABLE KEYS */;
INSERT INTO `voicing` VALUES (1,'SA'),(2,'SSA'),(3,'SSAA'),(4,'ST'),(5,'TTBB'),(6,'SB'),(7,'SAB'),(8,'SATB'),(9,'TTB'),(10,'TBB'),(11,'TB'),(12,'none'),(13,'S'),(14,'A'),(15,'T'),(16,'B'),(17,'SAA'),(18,'STB'),(19,'SAT'),(20,'SAB'),(21,'AT'),(22,'AB'),(23,'ATB'),(24,'TT'),(25,'TTBB'),(26,'BB'),(27,'TTB'),(28,'HighVoice'),(29,'MediumVoice'),(30,'LowVoice');
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

-- Dump completed on 2020-10-10 10:38:50
