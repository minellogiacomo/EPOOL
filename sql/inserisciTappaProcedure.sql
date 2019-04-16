 DELIMITER |
    drop procedure if exists InserisciTappa;
    CREATE PROCEDURE InserisciTappa (IN idN smallint, IN cittaN varchar (20), IN viaN varchar (30), IN orarioN datetime) 
    BEGIN
        DECLARE x SMALLINT;
        SET x = (SELECT CAPIENZA FROM veicolo,tragitto_prenotazione, prenotazione
        WHERE tragitto_prenotazione.ID_TRAG=idN AND
                tragitto_prenotazione.ID_PREN=prenotazione.ID AND
                veicolo.TARGA=prenotazione.AUTO
        limit 1);
        IF  EXISTS (SELECT ID
					FROM TRAGITTO 
                    WHERE ID = idN)
    THEN INSERT INTO TAPPA (ID_TRAGITTO, CITTA, VIA, ORARIO_ARRIVO, POSTI)
		   VALUES (idN, cittaN, viaN, orarioN, X-1 );
	ELSE  
		CALL printf ('[ERRORE], NON ESISTE NESSUN TRAGITTO CON  QUESTO ID');
	END IF;
    END;
    |
    DELIMITER ;