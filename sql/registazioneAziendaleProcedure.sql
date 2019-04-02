DELIMITER |

CREATE PROCEDURE RegistrazioneAziendale (IN Email varchar(30), IN pasw varchar(30), IN nome varchar(30), IN cognome varchar (30),
	IN datanascita date, IN luogo varchar (50), IN nomeazienda varchar (30), OUT result BOOLEAN)
	
    BEGIN
    start transaction;
	SET result = (FALSE);
         IF NOT EXISTS ( SELECT EMAIL
			           FROM UTENTE
				       WHERE EMAIL = Email)
			
            THEN IF EXISTS (SELECT *
							FROM AZIENDA
							WHERE NOMEAZIENDA = nomeazienda)
			
            THEN
        
				INSERT INTO UTENTE_AZIENDALE  (EMAILA, PW, NOME, COGNOME, DATANASCITA, LUOGO, NOMEAZIENDA) VALUES (Email, pasw, nome, cognome, datanascita, luogo, nomeazienda);
				SET result = (TRUE);
				commit work;
        
			ELSE
				CALL printf ('[ERRORE] AZIENDA NON PRESENTE NEL SISTEMA');
				rollback;
        	END IF;
    
		ELSE 
			CALL printf ('[ERRORE] UTENTE GIA\' REGISTRATO');
            rollback;
		END IF;
    
END;
	
|
DELIMITER ;