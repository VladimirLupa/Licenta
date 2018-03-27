DELIMITER //

CREATE PROCEDURE sp_edituser 
( 
    IN n_type 			int			,
    IN n_idUtilizator 	int 		,
    IN n_nume			varchar(45)	,
    IN n_prenume		varchar(45)	,
    IN n_username		varchar(45)	,
    IN n_email			varchar(45)	,
    IN n_parola			varchar(45)	,
    IN n_activ			INT 		,
    IN n_sters			int 		,
    OUT 	TREZULTAT 		varchar(100),
	OUT 	P1				int	       ,
	OUT 	P2				varchar(100)
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
    IF NOT EXISTS (SELECT 1 FROM utilizatori WHERE idUtilizator = n_idUtilizator)
    	THEN
        	ROLLBACK;
			SET TREZULTAT = 'Acest user NU exista in baza de date';
			SELECT TREZULTAT as Mesaj;
     END IF;
     
  /*******************activare user**************************************/  
    
    IF(n_type = 1)
    	THEN
     		UPDATE utilizatori
        	SET Activ = n_activ,
        		Data_modif = now()
         	WHERE
         		idUtilizator = n_idUtilizator;
           	COMMIT;  
			SET TREZULTAT = 'Activare cu succes a userului in baza de date'; 
			SELECT TREZULTAT as Mesaj; 
    END IF;
        
    /**************** schimbare parola *********************************/   
    IF(n_type = 2)
    	THEN
        	UPDATE utilizatori
            SET Parola = n_parola,
            	Data_modif = now()
            WHERE
            	idUtilizator = n_idUtilizator;
           	COMMIT;  
			SET TREZULTAT = 'Schimbarea parolei userului executata cu succes'; 
			SELECT TREZULTAT as Mesaj; 
    END IF;
    
    /***************schimbare nume ***********************************/
    IF(n_type = 3)
    	THEN
        	UPDATE utilizatori
            SET Nume = n_nume,
            	Data_modif = now()
            WHERE
            	idUtilizator = n_idUtilizator;
           	COMMIT;  
			SET TREZULTAT = 'Schimbarea numelui userului executata cu succes'; 
			SELECT TREZULTAT as Mesaj; 
    END IF;
    
     /***************schimbare username ***********************************/
     IF(n_type = 4)
     	THEN
        	UPDATE utilizatori
            SET Username = n_username,
            	Data_modif = now()
            WHERE
            	idUtilizator = n_idUtilizator;
           	COMMIT;  
			SET TREZULTAT = 'Schimbarea usernameului executata cu succes'; 
			SELECT TREZULTAT as Mesaj; 
    END IF;
    
    /***************stergere user ***********************************/
    
     IF(n_type = 5)
     	THEN
        	UPDATE utilizatori
            SET Sters = n_sters,
            	Data_modif = now(),
                Data_sters = now()
            WHERE
            	idUtilizator = n_idUtilizator;
           	COMMIT;  
			SET TREZULTAT = 'Stergerea userului executata cu succes'; 
			SELECT TREZULTAT as Mesaj; 
    END IF;

END;
     
 //   