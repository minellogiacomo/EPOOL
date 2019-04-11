DELIMITER |
    
    CREATE PROCEDURE inserisciTragitto (IN EmailN varchar (30), IN km smallint, IN tipe VARCHAR (30))  
    BEGIN  
		IF  EXISTS ( SELECT EMAILP
					FROM UTENTE_PREMIUM
                    WHERE EMAILP = EmailN )
                    
		THEN INSERT INTO TRAGITTO (EMAILP, KM, TIPO) values (EmailN, km, tipe);
		CALL printf ('INSERIMENTO PREMIUM AVVENUTO');	
        ELSE
        CALL printf('QUALCOSA PREMIUM è ANDATO STORTO');
        END IF;
        
		IF EXISTS (SELECT EMAILA
					FROM UTENTE_AZIENDALE
					WHERE EMAILA = EmailN )
		
        THEN INSERT INTO TRAGITTO (EMAILA, KM, TIPO) values (EmailN, km, tipe);
        CALL printf ('INSERIMENTO AZINEDALE AVVENUTO');
		ELSE
        CALL printf('QUALCOSA AZIENDALE è ANDATO STORTO');
	    
        END IF;
    END;
    |
    DELIMITER ;
