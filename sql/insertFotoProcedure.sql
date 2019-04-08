DROP PROCEDURE IF EXISTS InsertFoto;
DELIMITER
|
CREATE PROCEDURE InsertFoto(IN Emailt varchar(30),
                            IN Path varchar(100),
                            OUT result BOOLEAN)
BEGIN

            START TRANSACTION;
            SET result = (FALSE);
            INSERT INTO Foto (`EMAIL_UTENTE`,`PATHFOTO`)  VALUES(Emailt, Path);
            COMMIT WORK;
            SET result = (TRUE);

END;
|
DELIMITER ;
