-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: imdb_database
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.24.04.1

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
-- Table structure for table `Brian_rating`
--

DROP TABLE IF EXISTS `Brian_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Brian_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Brian_rating`
--

LOCK TABLES `Brian_rating` WRITE;
/*!40000 ALTER TABLE `Brian_rating` DISABLE KEYS */;
INSERT INTO `Brian_rating` VALUES ('Up','4'),('Venom','4');
/*!40000 ALTER TABLE `Brian_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Brian_watchlist`
--

DROP TABLE IF EXISTS `Brian_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Brian_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Brian_watchlist`
--

LOCK TABLES `Brian_watchlist` WRITE;
/*!40000 ALTER TABLE `Brian_watchlist` DISABLE KEYS */;
INSERT INTO `Brian_watchlist` VALUES ('Up'),('Time Cut'),('Venom');
/*!40000 ALTER TABLE `Brian_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `IT1200_rating`
--

DROP TABLE IF EXISTS `IT1200_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `IT1200_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IT1200_rating`
--

LOCK TABLES `IT1200_rating` WRITE;
/*!40000 ALTER TABLE `IT1200_rating` DISABLE KEYS */;
INSERT INTO `IT1200_rating` VALUES ('Up','5');
/*!40000 ALTER TABLE `IT1200_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `IT1200_watchlist`
--

DROP TABLE IF EXISTS `IT1200_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `IT1200_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IT1200_watchlist`
--

LOCK TABLES `IT1200_watchlist` WRITE;
/*!40000 ALTER TABLE `IT1200_watchlist` DISABLE KEYS */;
INSERT INTO `IT1200_watchlist` VALUES ('Up');
/*!40000 ALTER TABLE `IT1200_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `IT490_rating`
--

DROP TABLE IF EXISTS `IT490_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `IT490_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IT490_rating`
--

LOCK TABLES `IT490_rating` WRITE;
/*!40000 ALTER TABLE `IT490_rating` DISABLE KEYS */;
INSERT INTO `IT490_rating` VALUES ('Batman','3');
/*!40000 ALTER TABLE `IT490_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `IT490_watchlist`
--

DROP TABLE IF EXISTS `IT490_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `IT490_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IT490_watchlist`
--

LOCK TABLES `IT490_watchlist` WRITE;
/*!40000 ALTER TABLE `IT490_watchlist` DISABLE KEYS */;
INSERT INTO `IT490_watchlist` VALUES ('Batman');
/*!40000 ALTER TABLE `IT490_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `IT700_rating`
--

DROP TABLE IF EXISTS `IT700_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `IT700_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IT700_rating`
--

LOCK TABLES `IT700_rating` WRITE;
/*!40000 ALTER TABLE `IT700_rating` DISABLE KEYS */;
INSERT INTO `IT700_rating` VALUES ('Superman','4');
/*!40000 ALTER TABLE `IT700_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `IT700_watchlist`
--

DROP TABLE IF EXISTS `IT700_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `IT700_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IT700_watchlist`
--

LOCK TABLES `IT700_watchlist` WRITE;
/*!40000 ALTER TABLE `IT700_watchlist` DISABLE KEYS */;
INSERT INTO `IT700_watchlist` VALUES ('Up'),('Superman');
/*!40000 ALTER TABLE `IT700_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Mark_rating`
--

DROP TABLE IF EXISTS `Mark_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Mark_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Mark_rating`
--

LOCK TABLES `Mark_rating` WRITE;
/*!40000 ALTER TABLE `Mark_rating` DISABLE KEYS */;
INSERT INTO `Mark_rating` VALUES ('Up','5');
/*!40000 ALTER TABLE `Mark_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Mark_watchlist`
--

DROP TABLE IF EXISTS `Mark_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Mark_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Mark_watchlist`
--

LOCK TABLES `Mark_watchlist` WRITE;
/*!40000 ALTER TABLE `Mark_watchlist` DISABLE KEYS */;
INSERT INTO `Mark_watchlist` VALUES ('Ten Days'),('Up');
/*!40000 ALTER TABLE `Mark_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matt_rating`
--

DROP TABLE IF EXISTS `Matt_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Matt_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matt_rating`
--

LOCK TABLES `Matt_rating` WRITE;
/*!40000 ALTER TABLE `Matt_rating` DISABLE KEYS */;
INSERT INTO `Matt_rating` VALUES ('Up','5'),('Matrix','5');
/*!40000 ALTER TABLE `Matt_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matt_watchlist`
--

DROP TABLE IF EXISTS `Matt_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Matt_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matt_watchlist`
--

LOCK TABLES `Matt_watchlist` WRITE;
/*!40000 ALTER TABLE `Matt_watchlist` DISABLE KEYS */;
INSERT INTO `Matt_watchlist` VALUES ('Up'),('Here'),('Matrix');
/*!40000 ALTER TABLE `Matt_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `movie_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (54,'Batman','IT490','hello','2024-10-23 21:50:32'),(55,'Up','IT490','Nice','2024-10-27 02:05:41'),(56,'Up','IT700','Cool!','2024-10-27 03:39:20'),(57,'Up','IT490','Cool again','2024-10-28 15:31:10'),(58,'Up','Mark','Cool','2024-10-28 17:41:37'),(59,'Up','Mark','We are trying!','2024-10-29 18:17:57'),(60,'Up','Brian','I am Brian','2024-10-29 18:21:42'),(61,'Venom','Brian','This is Brian!','2024-10-29 18:44:08'),(62,'Up','qadeer','This is Qadeer!','2024-10-29 18:55:46'),(63,'Batman','qadeer','I like This Movie!','2024-10-29 18:57:53'),(64,'Up','Matt','This is Matt!','2024-10-30 15:43:59'),(65,'Batman','healer','This is Healer!','2024-10-30 15:47:46'),(66,'Here','healer','This is Healer!','2024-10-30 15:49:30'),(67,'Matrix','Matt','I am Matt!','2024-10-30 15:57:30'),(68,'Up','IT1200','hello this is IT1200!','2024-11-13 16:40:34'),(69,'Interstellar','qadeer1','Hello this qadeer!','2024-11-26 00:06:32'),(70,'Undying','qadeer1','Hello this is movie undying!!!','2024-11-26 00:16:23'),(71,'Batman','qadeer3','This is Qadeer3!','2024-12-08 19:30:53');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `healer_rating`
--

DROP TABLE IF EXISTS `healer_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `healer_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `healer_rating`
--

LOCK TABLES `healer_rating` WRITE;
/*!40000 ALTER TABLE `healer_rating` DISABLE KEYS */;
INSERT INTO `healer_rating` VALUES ('Batman','5'),('Here','5');
/*!40000 ALTER TABLE `healer_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `healer_watchlist`
--

DROP TABLE IF EXISTS `healer_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `healer_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `healer_watchlist`
--

LOCK TABLES `healer_watchlist` WRITE;
/*!40000 ALTER TABLE `healer_watchlist` DISABLE KEYS */;
INSERT INTO `healer_watchlist` VALUES ('Batman'),('Here');
/*!40000 ALTER TABLE `healer_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markcgv2_rating`
--

DROP TABLE IF EXISTS `markcgv2_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `markcgv2_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markcgv2_rating`
--

LOCK TABLES `markcgv2_rating` WRITE;
/*!40000 ALTER TABLE `markcgv2_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `markcgv2_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markcgv2_watchlist`
--

DROP TABLE IF EXISTS `markcgv2_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `markcgv2_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markcgv2_watchlist`
--

LOCK TABLES `markcgv2_watchlist` WRITE;
/*!40000 ALTER TABLE `markcgv2_watchlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `markcgv2_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markcgv3_rating`
--

DROP TABLE IF EXISTS `markcgv3_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `markcgv3_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markcgv3_rating`
--

LOCK TABLES `markcgv3_rating` WRITE;
/*!40000 ALTER TABLE `markcgv3_rating` DISABLE KEYS */;
INSERT INTO `markcgv3_rating` VALUES ('The Mom','4');
/*!40000 ALTER TABLE `markcgv3_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markcgv3_watchlist`
--

DROP TABLE IF EXISTS `markcgv3_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `markcgv3_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markcgv3_watchlist`
--

LOCK TABLES `markcgv3_watchlist` WRITE;
/*!40000 ALTER TABLE `markcgv3_watchlist` DISABLE KEYS */;
INSERT INTO `markcgv3_watchlist` VALUES ('The Best Friend'),('Little God'),('The Mom');
/*!40000 ALTER TABLE `markcgv3_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markcgv_rating`
--

DROP TABLE IF EXISTS `markcgv_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `markcgv_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markcgv_rating`
--

LOCK TABLES `markcgv_rating` WRITE;
/*!40000 ALTER TABLE `markcgv_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `markcgv_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markcgv_watchlist`
--

DROP TABLE IF EXISTS `markcgv_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `markcgv_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markcgv_watchlist`
--

LOCK TABLES `markcgv_watchlist` WRITE;
/*!40000 ALTER TABLE `markcgv_watchlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `markcgv_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movies` (
  `name` varchar(255) DEFAULT NULL,
  `overview` text,
  `poster_path` varchar(255) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` VALUES ('Up','Carl Fredricksen spent his entire life dreaming of exploring the globe and experiencing life to its fullest. But at age 78, life seems to have passed him by, until a twist of fate (and a persistent 8-year old Wilderness Explorer named Russell) gives him a new lease on life.','/mFvoEwSfLqbcWwFsDjQebn9bzFe.jpg','Tagline Not Available','Up'),('Batman','Batman must face his most ruthless nemesis when a deformed madman calling himself \"The Joker\" seizes control of Gotham\'s criminal underworld.','/cij4dd21v2Rk2YtUQbV5kW69WB2.jpg','Tagline Not Available','Batman'),(NULL,'Mild-mannered Clark Kent works as a reporter at the Daily Planet alongside his crush, Lois Lane. Clark must summon his superhero alter-ego when the nefarious Lex Luthor launches a plan to take over the world.','/d7px1FQxW4tngdACVRsCSaZq0Xl.jpg','Tagline Not Available','Superman'),('Do You See What I See','Mawar is lonely a lot of the time, especially after losing both parents. She often vents to Vey, her housemate and closest friend about how she feels. During her birthday, Mawar wishes for a boyfriend to brighten up her days. Her wish is finally granted when she eventually meets Restu. Vey is equally excited whenever Mawar tells stories about him. However, uncanny events have started happening ever since. The whole house experiences a lot of mystical and horrific events until one day Vey finds a clue that these incidents are related to Mawar\'s new boyfriend, who is not a human.','/ctAlfcNNHlHR1Ct70WDrinOCIfG.jpg','Tagline Not Available','I See'),('Do You See What I See','Mawar is lonely a lot of the time, especially after losing both parents. She often vents to Vey, her housemate and closest friend about how she feels. During her birthday, Mawar wishes for a boyfriend to brighten up her days. Her wish is finally granted when she eventually meets Restu. Vey is equally excited whenever Mawar tells stories about him. However, uncanny events have started happening ever since. The whole house experiences a lot of mystical and horrific events until one day Vey finds a clue that these incidents are related to Mawar\'s new boyfriend, who is not a human.','/ctAlfcNNHlHR1Ct70WDrinOCIfG.jpg','Tagline Not Available','Do You See What I See'),('The Lego Ninjago Movie','Six young ninjas are tasked with defending their island home of Ninjago. By night, they’re gifted warriors using their skill and awesome fleet of vehicles to fight villains and monsters. By day, they’re ordinary teens struggling against their greatest enemy....high school.','/vUo0pNXGhp2ffTJxiStWt6fHL7F.jpg','Tagline Not Available','Lego Movie'),('The Lego Movie','An ordinary Lego mini-figure, mistakenly thought to be the extraordinary MasterBuilder, is recruited to join a quest to stop an evil Lego tyrant from conquering the universe.','/lbctonEnewCYZ4FYoTZhs8cidAl.jpg','Tagline Not Available','The Lego Movie'),('Alien: Covenant - Prologue: Meet Walter','Introducing Walter, the latest synthetic by Weyland-Yutani. Created to serve. Intelligence powered by AMD, Ryzen and Radeon.','/mArTrTN1YAFnPwGZFNaoe4Dfdaj.jpg','Tagline Not Available','Alien Covenent'),('Alien: Covenant','The crew of the colony ship Covenant, bound for a remote planet on the far side of the galaxy, discovers what they think is an uncharted paradise but is actually a dark, dangerous world.','/zecMELPbU5YMQpC81Z8ImaaXuf9.jpg','Tagline Not Available','Alien: Covenant'),('Ten Days','As the Russian-Ukrainian war breaks out, Lena\'s family kitchen becomes a battleground. Struggling to prove her pacifist views to the family Lena takes a step she knows won\'t be approved.','/qE7gl2TjTCtB6XQN4XUmPuizXRv.jpg','Tagline Not Available','Ten Days'),('Time Cut','A teen in 2024 accidentally time-travels to 2003, days before a masked killer murders her sister. Now torn between solving the mystery that has undone her parents and her hometown, saving the sister that she never knew, and irreparably altering the future — and her own existence — she must decide how to stop the slasher, save her family, and blend into 2003.','/gzMFMmpJHOmOFKsAhSDac62Dyg2.jpg','Tagline Not Available','Time Cut'),('Venom','Investigative journalist Eddie Brock attempts a comeback following a scandal, but accidentally becomes the host of Venom, a violent, super powerful alien symbiote. Soon, he must rely on his newfound powers to protect the world from a shadowy organization looking for a symbiote of their own.','/2uNW4WbgBXL25BAbXGLnLqX71Sw.jpg','Tagline Not Available','Venom'),('Here','An odyssey through time and memory, centered around a place in New England where—from wilderness, and then, later, from a home—love, loss, struggle, hope and legacy play out between couples and families over generations.','/hsdGxzs8aYIOBYXa8vUvsTjN9RE.jpg','Tagline Not Available','Here'),('Matrix','The film is composed of receding planes in a landscape: a back garden and the houses beyond. The wooden lattice fence, visible in the image, marks the border between enclosed and open, private and public space, and forms both a fulcrum for the work and a formal grid by which the shots are framed and organised.','/AfFD10ZqEx2vkxM2yvRZkybsGB7.jpg','Tagline Not Available','Matrix'),('The Best Friend','Two great friends meet again after five years. Among so many things that have changed, the resumption of the bond awakens an old feeling for which they remain unprepared.','/zYdOpTf7S590aLKEsFYaz1QAR8Y.jpg','Tagline Not Available','The Best Friend'),('The Mom','','/2qSjP08q03F3XXuJtsEq1iCyRKg.jpg','Tagline Not Available','The Mom'),('Aliens','Ripley, the sole survivor of the Nostromo\'s deadly encounter with the monstrous Alien, returns to Earth after drifting through space in hypersleep for 57 years. Although her story is initially met with skepticism, she agrees to accompany a team of Colonial Marines back to LV-426.','/r1x5JGpyqZU8PYhbs4UcrO1Xb6x.jpg','Tagline Not Available','Aliens'),('Interstellar','The adventures of a group of explorers who make use of a newly discovered wormhole to surpass the limitations on human space travel and conquer the vast distances involved in an interstellar voyage.','/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg','Tagline Not Available','Interstellar'),('Undying','A tragic car accident puts a woman in a two year coma. She wakes up to find her fiance\' is dead and her friends have abandoned her. So she calls on an evil spirit to raise her fiance\' from the dead and exact revenge. But revenge always comes with a price.','/wFm6cJJ9mhGj1NAnoPpt1Xu8mE9.jpg','Tagline Not Available','Undying'),('Games','A mysterious woman in black moves in with married Manhattan thrill-seekers and helps one trick the other.','/ys05Ew8HJysXzBftjyDODrtcVRi.jpg','Tagline Not Available','Games'),('Fanon','Frantz Fanon, a French psychiatrist from Martinique, has just been appointed head of department at the psychiatric hospital in Blida, Algeria. His methods contrast with those of the other doctors in a context of colonization. A biopic in the heart of the Algerian war where a fight is waged in the name of Humanity.','/ym6hsJtZRnOjagGsCqI5JYmbOFk.jpg','Tagline Not Available','Fanon'),('The Avengers','When an unexpected enemy emerges and threatens global safety and security, Nick Fury, director of the international peacekeeping agency known as S.H.I.E.L.D., finds himself in need of a team to pull the world back from the brink of disaster. Spanning the globe, a daring recruitment effort begins!','/RYMX2wcKCBAr24UyPD7xwmjaTn.jpg','Tagline Not Available','The Avengers');
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qadeer2_rating`
--

DROP TABLE IF EXISTS `qadeer2_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qadeer2_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qadeer2_rating`
--

LOCK TABLES `qadeer2_rating` WRITE;
/*!40000 ALTER TABLE `qadeer2_rating` DISABLE KEYS */;
INSERT INTO `qadeer2_rating` VALUES ('Hen','4');
/*!40000 ALTER TABLE `qadeer2_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qadeer2_watchlist`
--

DROP TABLE IF EXISTS `qadeer2_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qadeer2_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qadeer2_watchlist`
--

LOCK TABLES `qadeer2_watchlist` WRITE;
/*!40000 ALTER TABLE `qadeer2_watchlist` DISABLE KEYS */;
INSERT INTO `qadeer2_watchlist` VALUES ('Little God'),('Hen');
/*!40000 ALTER TABLE `qadeer2_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qadeer3_rating`
--

DROP TABLE IF EXISTS `qadeer3_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qadeer3_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qadeer3_rating`
--

LOCK TABLES `qadeer3_rating` WRITE;
/*!40000 ALTER TABLE `qadeer3_rating` DISABLE KEYS */;
INSERT INTO `qadeer3_rating` VALUES ('Hen','5'),('Fanon','5');
/*!40000 ALTER TABLE `qadeer3_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qadeer3_watchlist`
--

DROP TABLE IF EXISTS `qadeer3_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qadeer3_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qadeer3_watchlist`
--

LOCK TABLES `qadeer3_watchlist` WRITE;
/*!40000 ALTER TABLE `qadeer3_watchlist` DISABLE KEYS */;
INSERT INTO `qadeer3_watchlist` VALUES ('Hen'),('Fanon');
/*!40000 ALTER TABLE `qadeer3_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qadeer4_rating`
--

DROP TABLE IF EXISTS `qadeer4_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qadeer4_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qadeer4_rating`
--

LOCK TABLES `qadeer4_rating` WRITE;
/*!40000 ALTER TABLE `qadeer4_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `qadeer4_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qadeer4_watchlist`
--

DROP TABLE IF EXISTS `qadeer4_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qadeer4_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qadeer4_watchlist`
--

LOCK TABLES `qadeer4_watchlist` WRITE;
/*!40000 ALTER TABLE `qadeer4_watchlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `qadeer4_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qadeer5_rating`
--

DROP TABLE IF EXISTS `qadeer5_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qadeer5_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qadeer5_rating`
--

LOCK TABLES `qadeer5_rating` WRITE;
/*!40000 ALTER TABLE `qadeer5_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `qadeer5_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qadeer5_watchlist`
--

DROP TABLE IF EXISTS `qadeer5_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qadeer5_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qadeer5_watchlist`
--

LOCK TABLES `qadeer5_watchlist` WRITE;
/*!40000 ALTER TABLE `qadeer5_watchlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `qadeer5_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qadeer_rating`
--

DROP TABLE IF EXISTS `qadeer_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qadeer_rating` (
  `Movies` varchar(255) DEFAULT NULL,
  `Rating` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qadeer_rating`
--

LOCK TABLES `qadeer_rating` WRITE;
/*!40000 ALTER TABLE `qadeer_rating` DISABLE KEYS */;
INSERT INTO `qadeer_rating` VALUES ('Up','5'),('Batman','5'),('Here','5');
/*!40000 ALTER TABLE `qadeer_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qadeer_watchlist`
--

DROP TABLE IF EXISTS `qadeer_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qadeer_watchlist` (
  `Movies` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qadeer_watchlist`
--

LOCK TABLES `qadeer_watchlist` WRITE;
/*!40000 ALTER TABLE `qadeer_watchlist` DISABLE KEYS */;
INSERT INTO `qadeer_watchlist` VALUES ('Batman'),('Time Cut'),('Here');
/*!40000 ALTER TABLE `qadeer_watchlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sessionId` varchar(255) DEFAULT NULL,
  `time` varchar(15) DEFAULT NULL,
  `userEmail` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('Brian','Brian','eebd166c91eab3ca9c4cdb1cb789cc58','1730227360','baf28@njit.edu',NULL),('healer','healer','2ef8fa4b1f1adaa98733d708a493c671','1730303233','healer2669011@gmail.com',NULL),('IT1200','$2y$10$.ZSlvVjcIQEL8/sjUKMPkufdgeTOhzCjy3I5smKxOXrkcuzk4yn7y','d700c8059b424b6a0fd5954c69a9501b','1731516000','qa9@njit.edu',NULL),('IT490','IT490','a2cd060d9d243e6e40d6584ad9f402ac','1730129449','qa9@njit.edu',NULL),('IT700','IT700','110fde75fcfd4823c2bc88ea4708d8c8','1730000305','mgv26@njit.edu',NULL),('Mark','Mark','2c65af1a1d892c5a7d933dcdf8ed93c8','1730225842','markcg.villanueva@gmail.com',NULL),('markcgv','$2y$10$kO9uFW8piMEdGuCHNBmI8uvXIW7GSOp6hJUwO.P594uQQsVqYru36','fb7fa9adc378ace4c38569381d96a1b8','1731470760','mgv26@njit.edu',NULL),('markcgv2','$2y$10$1syFQxPk2EUbqvnFMb14VeKT8ZjHCrdfp6nG2ByPvgeDwTkn3a/eq','27864c156b034cd4648a21f923f6a8c4','1731470773','mgv26@njit.edu',NULL),('markcgv3','$2y$10$7U3s0QnEDH4yRuPenr769.WJ6jGgEPPxvgANeDzLt6OF72t7pgyoC','ecad77c0302ff7f9cbf151dc8072f335','1731954027','cedrick.villanueva@gmail.com','7322211865'),('Matt','Matt','3fb7ffb639079d06c1f5fcb1a9b655d4','1730303657','mws36@njit.edu',NULL),('qadeer','qadeer','f1206d0c5d6398cf900021472882a8bd','1730304255','qa9@njit.edu',NULL),('qadeer2','$2y$10$q.HKvHq.BhC27nMZ68bxVuqdYOG090hmC9a208WvTc2G5dPTerNBW','ab1a430a8e627c4a265b194e5552c863','1733350193','qa9@njit.edu','+19733934674'),('qadeer3','$2y$10$xjB6rtF4d.Y6pRjPCiAFSegf.oyNr96oh2XdzZlKGCVv1j4bKlG.W','393d134c8cae78e63593809211973992','1733685812','qa9@njit.edu','+19733934674'),('qadeer4','$2y$10$55SMNr5uIITyVAcYrl/vNOI3p2N3jbGRBNy806JaSC.LWP3w2eR/K',NULL,NULL,'qa9@njit.edu','+113243412421'),('qadeer5','$2y$10$TrM8iCdhrXicNYjeCRwAC.gropeivVFyhZthB2XgCCrrVfQq19rH2',NULL,NULL,'qa9@njit.edu','+19733934674');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-16 12:09:22
