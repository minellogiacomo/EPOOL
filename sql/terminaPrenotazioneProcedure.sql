DELIMITER |

CREATE PROCEDURE TerminaPrenotazione (IN Email varchar(30), IN Auto varchar(10),OUT result BOOLEAN)
	
	BEGIN
    DECLARE TEMPO DATETIME DEFAULT NOW();
    start transaction;
    SET result = (FALSE);
		
        IF EXISTS (SELECT *
				   FROM PRENOTAZIONE
				   WHERE Auto = AUTO AND EMAIL = Email)
                   
		THEN UPDATE VEICOLO SET STATO = 'NON IN USO' WHERE TARGA = Auto;
        UPDATE VEICOLO SET AREA_SOSTA = (SELECT INDIRIZZO_ARRIVO FROM PRENOTAZIONE) WHERE TARGA = Auto;
        UPDATE PRENOTAZIONE SET FINE = TEMPO;
        SET result = (TRUE);
        commit work;
        
        ELSE
				CALL printf ('[ERRORE] NON ESISTE UN VEICOLO DA TE PRENOTATO CON QUESTA TARGA');
				rollback;
        	END IF;
END;

|
DELIMITER ;