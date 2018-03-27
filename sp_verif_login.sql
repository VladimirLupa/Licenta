
DELIMITER //
CREATE PROCEDURE sp_verificare_login
( 
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
    IF NOT EXISTS (SELECT 1 FROM utilizatori WHERE username = n_username)
    	THEN
        	ROLLBACK;
			SET TREZULTAT = 'Acest user NU exista in baza de date';
			SELECT TREZULTAT as Mesaj;
     END IF;
      IF NOT EXISTS (SELECT 1 FROM utilizatori WHERE username = n_username AND parola = n_parola )
    	THEN
        	ROLLBACK;
			SET TREZULTAT = 'Parola introdusa gresit pentru acest utilizator';
			SELECT TREZULTAT as Mesaj;
     END IF;
      IF NOT EXISTS (SELECT 1 FROM utilizatori WHERE username = n_username)
    	THEN
        	ROLLBACK;
			SET TREZULTAT = 'Acest user NU exista in baza de date';
			SELECT TREZULTAT as Mesaj;
     END IF;


