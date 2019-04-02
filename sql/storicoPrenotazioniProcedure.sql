DELIMITER |

CREATE PROCEDURE StoricoPr (IN Email varchar(30),OUT result BOOLEAN)

	BEGIN
    start transaction;
    SET result = (FALSE);
		IF EXISTS (SELECT *
				   FROM UTENTE
				   WHERE EMAIL = Email)
                   
		THEN (SELECT * 
             FROM STORICO_PRENOTAZIONI
             WHERE UTENTE = Email);
        SET result = (TRUE);     
		commit work;
        
        ELSE
				CALL printf ('[ERRORE] UTENTE NON ESISTE');
				rollback;
        	END IF;
        END;
|
DELIMITER ;