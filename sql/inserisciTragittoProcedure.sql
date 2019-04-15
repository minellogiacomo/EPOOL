DELIMITER |

CREATE PROCEDURE inserisciTragitto (IN EmailN varchar (30), IN km smallint, IN tipe VARCHAR (30), OUT res smallint)
BEGIN
    IF  EXISTS ( SELECT EMAILP
                 FROM UTENTE_PREMIUM
                 WHERE EMAILP = EmailN )

    THEN INSERT INTO TRAGITTO (EMAILP, KM, TIPO) values (EmailN, km, tipe);
    SET res =  (SELECT LAST_INSERT_ID());
    ELSE
        CALL printf('QUALCOSA PREMIUM è ANDATO STORTO');
    END IF;

    IF EXISTS (SELECT EMAILA
               FROM UTENTE_AZIENDALE
               WHERE EMAILA = EmailN )

    THEN INSERT INTO TRAGITTO (EMAILA, KM, TIPO) values (EmailN, km, tipe);
    CALL printf ('INSERIMENTO AZINEDALE AVVENUTO');
    SET res =  (SELECT LAST_INSERT_ID());
    ELSE
        CALL printf('QUALCOSA AZIENDALE è ANDATO STORTO');

    END IF;
END;
|
DELIMITER ;