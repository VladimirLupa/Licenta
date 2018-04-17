DELIMITER //
CREATE PROCEDURE sp_dezactivare_token 
( 
    IN      n_idUtilizator 	    int 		,
	OUT 	P1				    int	        ,
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
       IF  EXISTS (SELECT 1 FROM parola_recuperata WHERE idUtilizator = n_idUtilizator)
    	THEN
        	
			UPDATE parola_recuperata SET valid = 0 where idUtilizator = n_idUtilizator;
        END IF;
END;   
 // 