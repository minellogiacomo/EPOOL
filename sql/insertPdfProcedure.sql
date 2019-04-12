DROP PROCEDURE IF EXISTS InsertPdf;
DELIMITER
|
CREATE PROCEDURE InsertPdf(IN Nome varchar(30),
                            IN Pathpdf varchar(100),
                            OUT result BOOLEAN)
BEGIN

    START TRANSACTION;
    SET result = (FALSE);
    INSERT INTO PDF (`NOME_SOCIETA`,`PATH`)  VALUES(Nome, Pathpdf);
    COMMIT WORK;
    SET result = (TRUE);

END;
|
DELIMITER ;
