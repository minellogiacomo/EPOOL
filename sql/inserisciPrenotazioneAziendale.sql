DELIMITER |
CREATE PROCEDURE InserisciPrenotazioneAziendale (IN Tragitto smallint, IN Notet VARCHAR(300), IN Automobile VARCHAR(10), IN Emailt VARCHAR(30), IN IndirizzoPartenzat VARCHAR(30),IN IndirizzoArrivot VARCHAR(30), OUT result BOOLEAN)
BEGIN
    start transaction;
    SET result = (FALSE);
    INSERT INTO `prenotazione` ( `NOTE`, `AUTO`, `UTENTE`, `INDIRIZZO_PARTENZA`, `INDIRIZZO_ARRIVO`) VALUES ( Notet, Automobile, Emailt, IndirizzoPartenzat, IndirizzoArrivot);
    SET result =  (SELECT LAST_INSERT_ID());
    INSERT INTO `tragitto_prenotazione` ( `ID_TRAG`, `ID_PREN`) VALUES ( Tragitto, result);
    SET result = (TRUE);
    commit work;
END;
|
DELIMITER ;