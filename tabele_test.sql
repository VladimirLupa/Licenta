create table valori(
    idValoare int PRIMARY KEY auto_increment NOT NULL,
    idSenzor int not null,
    valoare float,
    data_achizitie DATETIME
);




CREATE TABLE senzori(
    idSenzor int PRIMARY KEY auto_increment NOT NULL,
    tip_senzor VARCHAR(45),
    model_senzor VARCHAR(45),
);



create TABLE alerte(
    idAlerta int PRIMARY KEY auto_increment NOT NULL,
    idSenzor int not null,
    alerta VARCHAR(100),
    data_alerta DATETIME
);



----------------------- procedura test adaugare de temperaturi -----------------------------------


--------- call sp_addtemperature(1,15.3,@TREZULTAT,@P1,@P2)-----------
DELIMITER //
CREATE  PROCEDURE `sp_addtemperature`
(
IN 		n_idSenzor 		    int             , 
IN 		n_valoare		    float           , 
OUT 	TREZULTAT 		    varchar (100)   ,
OUT 	P1				    int	            ,    
OUT 	P2				    varchar(100)
)
BEGIN
	DECLARE exit handler for sqlexception
		BEGIN
			GET DIAGNOSTICS CONDITION 1
			P1 = RETURNED_SQLSTATE, P2 = MESSAGE_TEXT;
			SELECT P1 as RETURNED_SQLSTATE  , P2 as MESSAGE_TEXT;
			ROLLBACK;
		END;
	START TRANSACTION;
		 IF EXISTS ( SELECT 1 FROM senzori where idSenzor = n_idSenzor)
			THEN 
				 ROLLBACK;
				 SET TREZULTAT = 'Acest senzor nu exista in baza de date';
				 SELECT TREZULTAT as Mesaj;
			ELSE 
				 INSERT INTO valori      (idSenzor, 		valoare, 	data_achizitie)
							 VALUES      (n_idSenzor,		n_valoare,	now());
                 COMMIT;  
				 SET TREZULTAT = 'Adaugare cu succes a valorii in baza de date'; 
				 SELECT TREZULTAT as Mesaj;  
		 END IF;
END;

//