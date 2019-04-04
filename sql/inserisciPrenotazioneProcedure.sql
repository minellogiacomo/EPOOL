DELIMITER |
CREATE PROCEDURE InserisciPrenotazione (IN  DataInizio DATE , IN DataFine DATE, IN Notet VARCHAR(300), IN Automobile VARCHAR(10), IN Emailt VARCHAR(30), IN IndirizzoPartenza VARCHAR(30),IN IndirizzoArrivo VARCHAR(30), OUT result BOOLEAN)
BEGIN
    start transaction;
    SET result = (FALSE);
    INSERT INTO `prenotazione` ( `INIZIO`, `FINE`, `NOTE`, `AUTO`, `UTENTE`, `INDIRIZZO_PARTENZA`, `INDIRIZZO_ARRIVO`) VALUES (DataInizio, DataFine, Notet, Automobile, Emailt, IndirizzoPartenza, IndirizzoArrivo);
    SET result = (TRUE);
    commit work;
END;
|
DELIMITER ;