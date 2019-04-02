DELIMITER |

CREATE PROCEDURE RegistrazioneUtente (IN EmailN varchar(30), IN pasw varchar(30), IN nome varchar(30), IN cognome varchar (30),
	IN datanascita date, IN luogo varchar (50), OUT result BOOLEAN)
	
    BEGIN
    start transaction;
	SET result = (FALSE);
         IF NOT EXISTS ( SELECT EMAIL
			           FROM UTENTE
				       WHERE EMAIL = EmailN)
		THEN 
        
        
        INSERT INTO UTENTE (EMAIL, PW, NOME, COGNOME, DATANASCITA, LUOGO) VALUES (EmailN, pasw, nome, cognome, datanascita, luogo);
		SET result = (TRUE);
		commit work;
        
     ELSE
		CALL printf ('[ERRORE] UTENTE GIA\' REGISTRATO');
        rollback;
	END IF;
    
END;
	
|
DELIMITER ;