DROP DATABASE IF exists EPOOL;
CREATE DATABASE EPOOL;
USE EPOOL;

CREATE TABLE UTENTE (

	EMAIL VARCHAR(30) PRIMARY KEY,
    PW VARCHAR(30) NOT NULL,
    NOME VARCHAR(30) NOT NULL,
    COGNOME VARCHAR(30) NOT NULL,
    DATANASCITA DATE NOT NULL,
    LUOGO VARCHAR(50)
    
    ) ENGINE=INNODB;
    
CREATE TABLE UTENTE_SEMPLICE (
	
    EMAILS VARCHAR(30) PRIMARY KEY REFERENCES UTENTE(EMAIL) ON UPDATE CASCADE ON DELETE CASCADE
    
    ) ENGINE=INNODB;
    
CREATE TABLE UTENTE_PREMIUM (
	
    EMAILP VARCHAR(30) PRIMARY KEY REFERENCES UTENTE(EMAIL)
    
    ) ENGINE=INNODB;
    
    
CREATE TABLE AZIENDA (
	
	NOME VARCHAR(30) PRIMARY KEY,
    INDIRIZZO VARCHAR(50) NOT NULL,
    TELEFONO INT NOT NULL,
    RECAPITO INT NOT NULL
    
	) ENGINE=INNODB;
    
CREATE TABLE UTENTE_AZIENDALE (

	EMAILA VARCHAR(30) PRIMARY KEY,
    NOMEAZIENDA VARCHAR(30) REFERENCES AZIENDA(NOME),
    
    FOREIGN KEY (EMAILA) REFERENCES UTENTE(EMAIL)
    
    ) ENGINE=INNODB;
    
CREATE TABLE FOTO (

	IDFOTO SMALLINT AUTO_INCREMENT PRIMARY KEY,
    EMAIL_UTENTE VARCHAR(30),
    
    
    FOREIGN KEY (EMAIL_UTENTE) REFERENCES UTENTE(EMAIL)
    
    ) ENGINE=INNODB;
    
CREATE TABLE SOCIETA (

	NOME VARCHAR(30) PRIMARY KEY,
    URL VARCHAR(30) NOT NULL, 
    TELEFONO INT NOT NULL
    
    ) ENGINE=INNODB;
    
CREATE TABLE PUBBLICA (
	
    NOME VARCHAR(30) PRIMARY KEY REFERENCES SOCIETA(NOME)
    
    ) ENGINE=INNODB;
    
CREATE TABLE PRIVATA (
	
    NOME VARCHAR(30) PRIMARY KEY REFERENCES SOCIETA(NOME)
    /*BROCHURE VARCHAR(30) /*??????? PDF NON SO COME INSERIRLO VEDREMO POI*/
    
    ) ENGINE=INNODB;
    
CREATE TABLE SOSTA (
	
    INDIRIZZO VARCHAR(30) PRIMARY KEY,
    LAT DECIMAL(10,6) NOT NULL,
    LNG DECIMAL(10,6) NOT NULL,
    RICARICA VARCHAR(2)
    
    ) ENGINE=INNODB;
    
CREATE TABLE VEICOLO (

	TARGA VARCHAR(10) PRIMARY KEY,
    MODELLO VARCHAR(20) NOT NULL,
    CAPIENZA SMALLINT NOT NULL,
    DESCRIZIONE VARCHAR(200) NOT NULL,
    FERIALE SMALLINT NOT NULL,
    FESTIVO SMALLINT NOT NULL,
    SOCIETA VARCHAR(30) NOT NULL,
    AREA_SOSTA VARCHAR(30) NOT NULL REFERENCES SOSTA(INDIRIZZO) ON UPDATE CASCADE,
    STATO ENUM('IN USO','NON IN USO') DEFAULT 'NON IN USO',
    
    FOREIGN KEY (SOCIETA) REFERENCES SOCIETA(NOME)
    
    ) ENGINE=INNODB;
    
CREATE TABLE PRENOTAZIONE (

	ID SMALLINT PRIMARY KEY AUTO_INCREMENT,
    INIZIO DATETIME DEFAULT NOW(),
    FINE DATETIME,
    NOTE VARCHAR(300),
    AUTO VARCHAR(10) NOT NULL,
    UTENTE VARCHAR(30) NOT NULL,
    INDIRIZZO_PARTENZA VARCHAR(30) NOT NULL,
    INDIRIZZO_ARRIVO VARCHAR(30) NOT NULL,
    
    FOREIGN KEY(INDIRIZZO_PARTENZA) REFERENCES SOSTA(INDIRIZZO),
    FOREIGN KEY(INDIRIZZO_ARRIVO) REFERENCES SOSTA(INDIRIZZO),
    FOREIGN KEY(UTENTE) REFERENCES UTENTE(EMAIL),
    FOREIGN KEY(AUTO) REFERENCES VEICOLO(TARGA)
        
    ) ENGINE=INNODB;
    
CREATE TABLE SEGNALAZIONE (
	
    ID SMALLINT PRIMARY KEY AUTO_INCREMENT,
    EMAIL VARCHAR(30),
    SOCIETA VARCHAR(30),
	DATA DATE NOT NULL,
    TITOLO VARCHAR(20) NOT NULL,	
    TESTO VARCHAR(200) NOT NULL,
    AUTO VARCHAR(10) NOT NULL,
    
    FOREIGN KEY (AUTO) REFERENCES VEICOLO(TARGA),
    FOREIGN KEY (EMAIL) REFERENCES UTENTE(EMAIL),
    FOREIGN KEY (SOCIETA) REFERENCES SOCIETA(NOME)
	
    ) ENGINE=INNODB;

CREATE TABLE TRAGITTO (

	ID SMALLINT PRIMARY KEY AUTO_INCREMENT,	
    EMAILP VARCHAR(30),
    EMAILA VARCHAR(30),
	KM SMALLINT NOT NULL,
    TIPO ENUM ('URBANO', 'EXTRA-URBANO', 'AUTOSTRADALE', 'MISTO'),
    
    FOREIGN KEY (EMAILP) REFERENCES UTENTE_PREMIUM(EMAILP),
    FOREIGN KEY (EMAILA) REFERENCES UTENTE_AZIENDALE(EMAILA)
	
    ) ENGINE=INNODB;
    
CREATE TABLE TAPPA (

	ID_TRAGITTO SMALLINT,
    CITTA VARCHAR(20) NOT NULL,
    VIA VARCHAR(30) NOT NULL,
    LAT FLOAT(10, 6) NOT NULL,
    LNG FLOAT(10, 6) NOT NULL,
    ORARIO_ARRIVO DATETIME NOT NULL,
    
    PRIMARY KEY (ID_TRAGITTO, VIA),
    FOREIGN KEY (ID_TRAGITTO) REFERENCES TRAGITTO(ID)
    
    ) ENGINE=INNODB;
    
CREATE TABLE PASSAGGIO (
	
    ID SMALLINT PRIMARY KEY AUTO_INCREMENT,
	EMAILP VARCHAR(30),
    EMAILA VARCHAR(30),
    INDIRIZZO_PARTENZA VARCHAR(30) NOT NULL,
	INDIRIZZO_ARRIVO VARCHAR(30) NOT NULL,
    
    FOREIGN KEY (INDIRIZZO_PARTENZA) REFERENCES TAPPA(VIA),
    FOREIGN KEY (INDIRIZZO_ARRIVO) REFERENCES TAPPA(VIA)

	) ENGINE=INNODB;
    
    
CREATE TABLE VALUTAZIONE (

	ID SMALLINT PRIMARY KEY AUTO_INCREMENT,
    EMAIL VARCHAR(30) NOT NULL,
    DATA DATE NOT NULL,
    TESTO VARCHAR(500) NOT NULL,
    VOTO SMALLINT NOT NULL CHECK(VOTO>=1 OR VOTO<=10),
    UTENTE VARCHAR(30) NOT NULL,
    
    FOREIGN KEY (EMAIL) REFERENCES UTENTE_PREMIUM(EMAILP),
    FOREIGN KEY (UTENTE) REFERENCES UTENTE (EMAIL)
    
    ) ENGINE=INNODB;
    
    
LOAD DATA INFILE "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/UTENTE.txt" INTO TABLE UTENTE;

LOAD DATA INFILE "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/UTENTESEMPLICE.txt" INTO TABLE UTENTE_SEMPLICE;

LOAD DATA INFILE "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/azienda.txt" INTO TABLE AZIENDA;

LOAD DATA INFILE "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/UTENTEAZIENDALE.txt" INTO TABLE UTENTE_AZIENDALE;

LOAD DATA INFILE "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/UTENTEPREMIUM.txt" INTO TABLE UTENTE_PREMIUM;

LOAD DATA INFILE "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/sosta.txt" INTO TABLE SOSTA (INDIRIZZO, LAT, LNG, RICARICA);

LOAD DATA INFILE "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/societa.txt" INTO TABLE SOCIETA;

LOAD DATA INFILE "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/pubblica.txt" INTO TABLE PUBBLICA;

LOAD DATA INFILE "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/privata.txt" INTO TABLE PRIVATA;

LOAD DATA INFILE "C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/veicolo.txt" INTO TABLE VEICOLO (TARGA, MODELLO, CAPIENZA, DESCRIZIONE,FERIALE, FESTIVO, SOCIETA, AREA_SOSTA);

UPDATE VEICOLO set AREA_SOSTA = REPLACE(AREA_SOSTA,"\r","");

/*PROCEDURES
 REGISTRARSI SU UNA PIATTAFORMA*/
 
/*inizio procedures */
/* REGISTRAZIONE*/

/*procedure di stampa */
DELIMITER |

CREATE PROCEDURE printf(mytext TEXT)
BEGIN

  select mytext as ``;

END;
|
DELIMITER ;

DELIMITER |

CREATE PROCEDURE RegistrazioneSemplice (IN EmailN varchar(30), IN pasw varchar(30), IN nome varchar(30), IN cognome varchar (30),
	IN datanascita date, IN luogo varchar (50))
	
    BEGIN
    start transaction;
         IF NOT EXISTS ( SELECT EMAIL
			           FROM UTENTE
				       WHERE EMAIL = EmailN)
		THEN 
        
        
        INSERT INTO UTENTE_SEMPLICE  (EMAILS, PW, NOME, COGNOME, DATANASCITA, LUOGO) VALUES (EmailN, pasw, nome, cognome, datanascita, luogo);
		commit work;
        
     ELSE
		CALL printf ('[ERRORE] UTENTE GIA\' REGISTRATO');
        rollback;
	END IF;
    
END;
	
|
DELIMITER ;

DELIMITER |

CREATE PROCEDURE RegistrazioneAziendale (IN Email varchar(30), IN pasw varchar(30), IN nome varchar(30), IN cognome varchar (30),
	IN datanascita date, IN luogo varchar (50), IN nomeazienda varchar (30))
	
    BEGIN
    start transaction;
         IF NOT EXISTS ( SELECT EMAIL
			           FROM UTENTE
				       WHERE EMAIL = Email)
			
            THEN IF EXISTS (SELECT *
							FROM AZIENDA
							WHERE NOMEAZIENDA = nomeazienda)
			
            THEN
        
				INSERT INTO UTENTE_AZIENDALE  (EMAILA, PW, NOME, COGNOME, DATANASCITA, LUOGO, NOMEAZIENDA) VALUES (Email, pasw, nome, cognome, datanascita, luogo, nomeazienda);
				commit work;
        
			ELSE
				CALL printf ('[ERRORE] AZIENDA NON PRESENTE NEL SISTEMA');
				rollback;
        	END IF;
    
		ELSE 
			CALL printf ('[ERRORE] UTENTE GIA\' REGISTRATO');
            rollback;
		END IF;
    
END;
	
|
DELIMITER ;

DELIMITER |

CREATE PROCEDURE Prenotazione ( IN Note varchar(300), IN Auto varchar(10),
                                IN Utente varchar(30), IN Partenza varchar(30), IN Arrivo varchar(30))
                                
	BEGIN
    start transaction;
    
		IF EXISTS (SELECT *
				   FROM VEICOLI_DISP	 	
				   WHERE TARGA = Auto)
                   
		    THEN IF EXISTS (SELECT *
						    FROM UTENTE
                            WHERE EMAIL = Utente)
		
			THEN IF EXISTS (SELECT TARGA, AREA_SOSTA
								FROM VEICOLO
								WHERE (TARGA = Auto) AND (AREA_SOSTA = Partenza))
                                
			THEN IF EXISTS (SELECT *
							FROM SOSTA
                            WHERE (Partenza != Arrivo))
                            
			THEN IF EXISTS (SELECT *
							FROM SOSTA
                            WHERE (INDIRIZZO = Arrivo))
			    THEN
        
				INSERT INTO PRENOTAZIONE (NOTE, AUTO, UTENTE, INDIRIZZO_PARTENZA, INDIRIZZO_ARRIVO)
				VALUES (Note, Auto, Utente, Partenza, Arrivo); 
			
			commit work;
        
        ELSE
				CALL printf ('[ERRORE] LA DESTINAZIONE NON ESISTE');
				rollback;
        	END IF;
            
		ELSE
				CALL printf ('[ERRORE] LA DESTINAZIONE DEVE ESSERE DIVERSA DALL\' INDIRIZZO DI PARTENZA');
				rollback;
        	END IF;
            
		ELSE
				CALL printf ('[ERRORE] VEICOLO NON PRESENTE IN QUELL\'AREA DI SOSTA');
				rollback;
        	END IF;
    
		ELSE 
			CALL printf ('[ERRORE] UTENTE NON PRESENTE NEL SISTEMA');
            rollback;
		END IF;
        
        ELSE 
			CALL printf ('[ERRORE] VEICOLO NON DISPONIBILE');
            rollback;
		END IF;
        
END;
|
DELIMITER ;

DELIMITER |

CREATE PROCEDURE TerminaPrenotazione (IN Email varchar(30), IN Auto varchar(10))
	
	BEGIN
    DECLARE TEMPO DATETIME DEFAULT NOW();
    start transaction;
    
		
        IF EXISTS (SELECT *
				   FROM PRENOTAZIONE
				   WHERE Auto = AUTO AND EMAIL = Email)
                   
		THEN UPDATE VEICOLO SET STATO = 'NON IN USO' WHERE TARGA = Auto;
        UPDATE VEICOLO SET AREA_SOSTA = (SELECT INDIRIZZO_ARRIVO FROM PRENOTAZIONE) WHERE TARGA = Auto;
        UPDATE PRENOTAZIONE SET FINE = TEMPO;
        
        commit work;
        
        ELSE
				CALL printf ('[ERRORE] NON ESISTE UN VEICOLO DA TE PRENOTATO CON QUESTA TARGA');
				rollback;
        	END IF;
END;

|
DELIMITER ;

DELIMITER |

CREATE PROCEDURE StoricoPr (IN Email varchar(30))

	BEGIN
    start transaction;
    
		IF EXISTS (SELECT *
				   FROM UTENTE
				   WHERE EMAIL = Email)
                   
		THEN (SELECT * 
             FROM STORICO_PRENOTAZIONI
             WHERE UTENTE = Email);
             
		commit work;
        
        ELSE
				CALL printf ('[ERRORE] UTENTE NON ESISTE');
				rollback;
        	END IF;
        END;
|
DELIMITER ;


/*TRIGGER BESTIALI*/
DELIMITER |

CREATE TRIGGER BloccaVeicolo
AFTER INSERT ON PRENOTAZIONE
FOR EACH ROW
	
    BEGIN
    UPDATE VEICOLO SET STATO = 'IN USO' WHERE TARGA=NEW.AUTO;
	
    END;
|
DELIMITER ;

/* LISTA VISTE */


CREATE VIEW STORICO_PRENOTAZIONI(ID, INIZIO, FINE, NOTE, AUTO, UTENTE, INDIRIZZO_PARTENZA, INDIRIZZO_ARRIVO) as
		
	SELECT ID, INIZIO, FINE, NOTE, AUTO, UTENTE, INDIRIZZO_PARTENZA, INDIRIZZO_ARRIVO
	FROM PRENOTAZIONE;
    
CREATE VIEW VEICOLI_DISP(TARGA, MODELLO, CAPIENZA, DESCRIZIONE, FERIALE, FESTIVO, SOCIETA, AREA_SOSTA) as

	SELECT TARGA, MODELLO, CAPIENZA, DESCRIZIONE, FERIALE, FESTIVO, SOCIETA, AREA_SOSTA
    FROM VEICOLO
    WHERE STATO = 'NON IN USO'