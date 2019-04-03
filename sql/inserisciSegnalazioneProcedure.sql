DELIMITER |
CREATE PROCEDURE InserisciSegnalazione (IN Emailt varchar(30), IN SocietaAutomobile VARCHAR(30), IN DataSegnalazione DATE , IN TitoloSegnalazione VARCHAR(20), IN TestoSegnalazione VARCHAR(200), IN Automobile VARCHAR(10),  OUT result BOOLEAN)
BEGIN
    start transaction;
    SET result = (FALSE);
    INSERT INTO `segnalazione` (`EMAIL`, `SOCIETA`, `DATA`, `TITOLO`, `TESTO`, `AUTO`) VALUES (Emailt, SocietaAutomobile, DataSegnalazione, TitoloSegnalazione, TestoSegnalazione, Automobile);
    SET result = (TRUE);
    commit work;
END;
|
DELIMITER ;