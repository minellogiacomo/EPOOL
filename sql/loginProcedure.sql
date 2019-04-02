DELIMITER |
	
create PROCEDURE Login (IN Email varchar(30), IN pasw varchar(30), OUT result BOOLEAN)
	BEGIN
        IF EXISTS(SELECT *
						  FROM UTENTE
						  WHERE UTENTE.EMAIL = Email AND UTENTE.PW=pasw) THEN
				SET result = (TRUE);
			ELSE
			    SET result = (FALSE);
			END IF;
		
	END;
|
DELIMITER ;