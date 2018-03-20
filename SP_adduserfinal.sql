DELIMITER //
CREATE  PROCEDURE `sp_adduser`
(
IN 		n_nume 			varchar(20), 
IN 		n_prenume		varchar(20), 
IN		n_username 		varchar(20), 
IN 		n_email  		varchar(20),
IN 		n_parola 		varchar(20),
IN 		n_data_inreg 	datetime,
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
		 IF EXISTS ( SELECT * FROM utilizatori where Nume = n_nume OR Prenume = n_prenume OR Username = n_username OR Email = n_email )
			THEN 
				 ROLLBACK;
				 SET TREZULTAT = 'Acest user exista deja in baza de date';
				 SELECT TREZULTAT as Mesaj;
			ELSE 
				 INSERT INTO utilizatori (Nume, 		Prenume, 	Username, 	Email, 		Parola,		Data_inreg)
							 VALUES      (n_nume,		n_prenume,	n_username,	n_email,	n_parola, 	now() );
                 COMMIT;  
				 SET TREZULTAT = 'Adaugare cu succes a userului in baza de date'; 
				 SELECT TREZULTAT as Mesaj;  
		 END IF;
END;

//