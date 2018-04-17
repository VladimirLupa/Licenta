-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 192.168.12.111    Database: Proiect
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.23-MariaDB-9+deb9u1

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
-- Table structure for table `Utilizatori`
--

DROP TABLE IF EXISTS `Utilizatori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Utilizatori` (
  `IdUtilizator` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nume` varchar(45) NOT NULL,
  `Prenume` varchar(45) NOT NULL,
  `NumeUtilizator` varchar(45) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Parola` varchar(255) NOT NULL,
  `Activ` int(11) NOT NULL,
  `Sters` int(11) NOT NULL,
  `DataInscrierii` datetime NOT NULL,
  `DataModificarii` datetime NOT NULL,
  `DataStergerii` datetime NOT NULL,
  `DataUltimaLogare` datetime NOT NULL,
  PRIMARY KEY (`IdUtilizator`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Utilizatori`
--

LOCK TABLES `Utilizatori` WRITE;
/*!40000 ALTER TABLE `Utilizatori` DISABLE KEYS */;
INSERT INTO `Utilizatori` VALUES (1,'Timisica','Gabriel','Gabi','gabi','asdfg',0,0,'2018-04-16 13:35:56','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'Lupa','Vladimir','Vlad','neamarin96@gmail.com','$2y$10$kzbs/9I4yyiPJKHyOfzX9OPgHfbBiE..3T3jZkXXZUXBn3nweSEgG',0,0,'2018-04-16 13:37:28','2018-04-17 11:45:25','0000-00-00 00:00:00','2018-04-16 16:43:07');
/*!40000 ALTER TABLE `Utilizatori` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-17 14:49:21
