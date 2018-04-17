
--trtigger ptr inserare unor temperaturi de peste 30 de grade;

CREATE TRIGGER `Temperatura_peste_30` AFTER INSERT ON `valori`
 FOR EACH ROW BEGIN 
	IF( NEW.valoare > 30 ) THEN
    	INSERT INTO alerte (idSenzor, alerta, data_alerta) VALUES (1,'Temperatura peste 30 de grade', now());
       END IF;
END





-- CREATE TRIGGER `Dezactivare_token` BEFORE INSERT ON `parola_recuperata`
-- 	FOR EACH ROW BEGIN;
-- 	SET @alreadyexist := (SELECT idUtilizator FROM parola_recuperata WHERE idUtilizator = NEW.idUtilizator );
	
-- 		IF (NEW.idUtilizator = @alreadyexist) THEN
-- 			UPDATE parola_recuperata SET valid = 0 where idUtilizator = @alreadyexist;
-- 		end IF;
-- 	END




	-- DROP TRIGGER IF EXISTS `Dezactivare_token`;CREATE DEFINER=`root`@`localhost` TRIGGER `Dezactivare_token` BEFORE INSERT ON `parola_recuperata` FOR EACH ROW BEGIN SET @alreadyexist = (SELECT idUtilizator FROM parola_recuperata WHERE idUtilizator = NEW.idUtilizator AND valid = 1 ); IF (NEW.idUtilizator = @alreadyexist) THEN UPDATE parola_recuperata SET valid = 0 where idUtilizator = @alreadyexist; end IF; END