|
    DELIMITER
    CREATE PROCEDURE VALUTA_UTENTI (emailSogg varchar (30),dataN date, testoN varchar (500), votoN smallint,emailOgg varchar (30))
	BEGIN
        IF EXISTS (SELECT ID_TAPPA
				  FROM PASSAGGIO 
                  WHERE  EMAILP =emailSogg and (PASSAGGIO.ID_TAPPA = (SELECT PASSAGGIO.ID_TAPPA  
																	 FROM PASSAGGIO
                                                                     WHERE EMAILP = emailOgg)) and 
		
        THEN INSERT INTO VALUTAZIONE (EMAIL, DATA, TESTO, VOTO, UTENTE) 
					VALUES (emailSogg, dataN, testoN, votoN, emailOgg);
		CALL printf ("HAI VALUTATO UN UTENTE CON CUI HAI CONDIVISO UN PASSAGGIO");
		ELSE IF
         CALL printf ("VALUTAZIONE NON INSERITA");
         END IF;
END;
    DELIMITER ;
|
