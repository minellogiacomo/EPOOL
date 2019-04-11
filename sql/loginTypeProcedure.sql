DELIMITER |

create PROCEDURE LoginType (IN Email varchar(30), OUT result BOOLEAN)
BEGIN
    IF EXISTS(SELECT *
              FROM UTENTE_PREMIUM
              WHERE UTENTE_PREMIUM.EMAILP = Email) THEN
        SET result = 2;
    ELSE
        SET result = 1;
    END IF;
END;
|
DELIMITER ;