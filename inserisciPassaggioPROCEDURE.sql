DELIMITER |
drop procedure if exists inserisciPassaggio;
CREATE PROCEDURE inserisciPassaggio (IN idN smallint, IN EmailzN varchar (30), IN partenzaN varchar(30), 
									IN arrivoN varchar (30))
	BEGIN
		IF  EXISTS ( SELECT EMAILP
					FROM UTENTE_PREMIUM
					WHERE EMAILP = EmailzN ) 
                    
		THEN INSERT INTO PASSAGGIO (ID_TAPPA, EMAILP, INDIRIZZO_PARTENZA, INDIRIZZO_ARRIVO) 
							values (idN, EmailzN, partenzaN, arrivoN);
		CALL printf ('INSERIMENTO PREMIUM AVVENUTO');	
        else
        call printf('Cazzo vuoi 1');
        END IF;
        
		IF EXISTS (SELECT EMAILA
					FROM UTENTE_AZIENDALE
					WHERE EMAILA = EmailzN )

					
        THEN INSERT INTO PASSAGGIO (ID_TAPPA, EMAILA, INDIRIZZO_PARTENZA, INDIRIZZO_ARRIVO) 
							values (idN, EmailzN, partenzaN, arrivoN);
        CALL printf ('INSERIMENTO AZINEDALE AVVENUTO');
		 else
          call printf('Cazzo vuoi 2');
        END IF;
	END;
|
DELIMITER ;
