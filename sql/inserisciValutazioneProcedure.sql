DELIMITER |
CREATE PROCEDURE InserisciValutazione (IN Emailt varchar(30),  IN TestoValutazione VARCHAR(500), IN VotoValutazione SMALLINT, IN UtenteV varchar(30) , OUT result BOOLEAN)
BEGIN
    start transaction;
    SET result = (FALSE);
    INSERT INTO `valutazione` (`EMAIL`, `DATA`, `TESTO`, `VOTO` , `UTENTE`) VALUES (Emailt, CURRENT_DATE, TestoValutazione, VotoValutazione, UtenteV);
    SET result = (TRUE);
    commit work;
END;
|
DELIMITER ;