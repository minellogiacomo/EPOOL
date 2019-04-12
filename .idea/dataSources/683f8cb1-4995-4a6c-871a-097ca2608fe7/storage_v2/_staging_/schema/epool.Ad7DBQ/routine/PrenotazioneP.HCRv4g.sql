create
    definer = root@localhost procedure PrenotazioneP(IN Note varchar(300), IN Auto varchar(10), IN Utente varchar(30),
                                                     IN Partenza varchar(30), IN Arrivo varchar(30),
                                                     OUT result tinyint(1))
BEGIN
    start transaction;
    SET result = (FALSE);
	INSERT INTO PRENOTAZIONE (INIZIO, FINE, NOTE, AUTO, UTENTE, INDIRIZZO_PARTENZA, INDIRIZZO_ARRIVO)
	VALUES (CURRENT_TIMESTAMP, NULL, Note, Auto, Utente, Partenza, Arrivo);
	commit work;
	SET result = (TRUE);
END;

