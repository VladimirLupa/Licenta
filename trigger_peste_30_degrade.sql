
--trtigger ptr inserare unor temperaturi de peste 30 de grade;

CREATE TRIGGER `Temperatura_peste_30` AFTER INSERT ON `valori`
 FOR EACH ROW BEGIN 
	IF( NEW.valoare > 30 ) THEN
    	INSERT INTO alerte (idSenzor, alerta, data_alerta) VALUES (1,'Temperatura peste 30 de grade', now());
       END IF;
END