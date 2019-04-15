 DELIMITER |
    drop procedure if exists InserisciTappa;
    CREATE PROCEDURE InserisciTappa (IN idN smallint, IN cittaN varchar (20), IN viaN varchar (30), IN orarioN datetime) 
    BEGIN
    IF  EXISTS (SELECT ID
					FROM TRAGITTO 
                    WHERE ID = idN)
    THEN INSERT INTO TAPPA (ID_TRAGITTO, CITTA, VIA, ORARIO_ARRIVO) 
		   VALUES (idN, cittaN, viaN, orarioN);
	ELSE  
		CALL printf ('[ERRORE], NON ESISTE NESSUN TRAGITTO CON  QUESTO ID');
	END IF;
    END;
    |
    DELIMITER ;