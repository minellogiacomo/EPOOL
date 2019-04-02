DELIMITER |

CREATE PROCEDURE Prenotazione ( IN Note varchar(300), IN Auto varchar(10),
                                IN Utente varchar(30), IN Partenza varchar(30), IN Arrivo varchar(30),OUT result BOOLEAN)
                                
	BEGIN
    start transaction;
    SET result = (FALSE);
		IF EXISTS (SELECT *
				   FROM VEICOLI_DISP	 	
				   WHERE TARGA = Auto)
                   
		    THEN IF EXISTS (SELECT *
						    FROM UTENTE
                            WHERE EMAIL = Utente)
		
			THEN IF EXISTS (SELECT TARGA, AREA_SOSTA
								FROM VEICOLO
								WHERE (TARGA = Auto) AND (AREA_SOSTA = Partenza))
                                
			THEN IF EXISTS (SELECT *
							FROM SOSTA
                            WHERE (Partenza != Arrivo))
                            
			THEN IF EXISTS (SELECT *
							FROM SOSTA
                            WHERE (INDIRIZZO = Arrivo))
			    THEN
        
				INSERT INTO PRENOTAZIONE (NOTE, AUTO, UTENTE, INDIRIZZO_PARTENZA, INDIRIZZO_ARRIVO)
				VALUES (Note, Auto, Utente, Partenza, Arrivo); 
			    SET result = (TRUE);
			commit work;
        
        ELSE
				CALL printf ('[ERRORE] LA DESTINAZIONE NON ESISTE');
				rollback;
        	END IF;
            
		ELSE
				CALL printf ('[ERRORE] LA DESTINAZIONE DEVE ESSERE DIVERSA DALL\' INDIRIZZO DI PARTENZA');
				rollback;
        	END IF;
            
		ELSE
				CALL printf ('[ERRORE] VEICOLO NON PRESENTE IN QUELL\'AREA DI SOSTA');
				rollback;
        	END IF;
    
		ELSE 
			CALL printf ('[ERRORE] UTENTE NON PRESENTE NEL SISTEMA');
            rollback;
		END IF;
        
        ELSE 
			CALL printf ('[ERRORE] VEICOLO NON DISPONIBILE');
            rollback;
		END IF;
        
END;
|
DELIMITER ;