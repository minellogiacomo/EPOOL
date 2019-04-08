DELIMITER |

CREATE TRIGGER AggiornaLivelloUtente
AFTER INSERT ON PRENOTAZIONE 
FOR EACH ROW
BEGIN    
 
 IF ((SELECT COUNT(*) FROM prenotazione WHERE UTENTE = NEW.UTENTE) = 3)

	THEN
		
       
		DELETE FROM utente_semplice WHERE EMAILS IN (SELECT UTENTE 
												      FROM PRENOTAZIONE
		  											  WHERE PRENOTAZIONE.UTENTE = NEW.UTENTE);
    
   
        INSERT INTO utente_premium (EMAILP)        (SELECT distinct (UTENTE)
                                                    FROM  PRENOTAZIONE
													WHERE PRENOTAZIONE.UTENTE = NEW.UTENTE);
 
END IF;
END;
