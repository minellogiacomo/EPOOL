DELIMITER |

create PROCEDURE LoginAziendale (IN Email varchar(30), IN pasw varchar(30), OUT result BOOLEAN)
BEGIN
    IF EXISTS(SELECT *
              FROM UTENTE
              WHERE UTENTE.EMAIL = Email AND UTENTE.PW=pasw) THEN
        IF EXISTS(SELECT *
                  FROM UTENTE_AZIENDALE
                  WHERE UTENTE_AZIENDALE.EMAILa = Email) THEN
        SET result = (TRUE);
        ELSE
        SET result = (FALSE);
        END IF;
    ELSE
        SET result = (FALSE);
    END IF;
END;
|
DELIMITER ;