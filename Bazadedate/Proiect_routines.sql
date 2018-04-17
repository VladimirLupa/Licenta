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
-- Dumping routines for database 'Proiect'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_adduser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`vladimir`@`192.168.12.111` PROCEDURE `sp_adduser`(IN `n_nume` VARCHAR(45), IN `n_prenume` VARCHAR(45), IN `n_username` VARCHAR(45), IN `n_email` VARCHAR(100), IN `n_parola` VARCHAR(255), OUT `TREZULTAT` VARCHAR(100), OUT `P1` INT)
BEGIN
	DECLARE exit handler for sqlexception
		BEGIN
			GET DIAGNOSTICS CONDITION 1
			P1 = RETURNED_SQLSTATE, TREZULTAT = MESSAGE_TEXT;
			SELECT P1 as RETURNED_SQLSTATE  , TREZULTAT as MESSAGE_TEXT;
			ROLLBACK;
		END;
	START TRANSACTION;
		 IF EXISTS ( SELECT * FROM Utilizatori where BINARY Nume = n_nume  OR NumeUtilizator = n_username OR Email = n_email )
			THEN 
				 ROLLBACK;
				 SET TREZULTAT = 'Acest user exista deja in baza de date';
                 SELECT TREZULTAT AS Mesaj;
			ELSE 
				 INSERT INTO Utilizatori (Nume, 		Prenume, 	NumeUtilizator, 	Email, 		Parola,		DataInscrierii)
							 VALUES      (n_nume,		n_prenume,	n_username,	n_email,	n_parola, 	now() );
                 COMMIT;  
				 SET TREZULTAT = 'Adaugare cu succes a userului in baza de date'; 
                 SELECT TREZULTAT AS Mesaj;
		 END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_dezactivare_token` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`vladimir`@`%` PROCEDURE `sp_dezactivare_token`(IN `n_idUtilizator` INT)
BEGIN
	
   
        	
			UPDATE RecuperareParola SET valid = 0 where IdUtilizator = n_idUtilizator;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-17 14:49:22
