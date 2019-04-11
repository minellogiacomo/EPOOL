-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 11, 2019 alle 14:24
-- Versione del server: 10.1.38-MariaDB
-- Versione PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epool`
--

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getFoto` (IN `Emailt` VARCHAR(30))  BEGIN
    SELECT * FROM FOTO WHERE Emailt=FOTO.EMAIL_UTENTE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InserisciSegnalazione` (IN `Emailt` VARCHAR(30), IN `SocietaAutomobile` VARCHAR(30), IN `DataSegnalazione` DATE, IN `TitoloSegnalazione` VARCHAR(20), IN `TestoSegnalazione` VARCHAR(200), IN `Automobile` VARCHAR(10), OUT `result` BOOLEAN)  BEGIN
    start transaction;
    SET result = (FALSE);
    INSERT INTO `segnalazione` (`EMAIL`, `SOCIETA`, `DATA`, `TITOLO`, `TESTO`, `AUTO`) VALUES (Emailt, SocietaAutomobile, DataSegnalazione, TitoloSegnalazione, TestoSegnalazione, Automobile);
    SET result = (TRUE);
    commit work;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InserisciValutazione` (IN `Emailt` VARCHAR(30), IN `TestoValutazione` VARCHAR(500), IN `VotoValutazione` SMALLINT, IN `UtenteV` VARCHAR(30), OUT `result` BOOLEAN)  BEGIN
    start transaction;
    SET result = (FALSE);
    INSERT INTO `valutazione` (`EMAIL`, `DATA`, `TESTO`, `VOTO` , `UTENTE`) VALUES (Emailt, CURRENT_DATE, TestoValutazione, VotoValutazione, UtenteV);
    SET result = (TRUE);
    commit work;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertFoto` (IN `Emailt` VARCHAR(30), IN `Path` VARCHAR(100), OUT `result` BOOLEAN)  BEGIN

            START TRANSACTION;
            SET result = (FALSE);
            INSERT INTO Foto (`EMAIL_UTENTE`,`PATHFOTO`)  VALUES(Emailt, Path);
            COMMIT WORK;
            SET result = (TRUE);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Login` (IN `Email` VARCHAR(30), IN `pasw` VARCHAR(30), OUT `result` BOOLEAN)  BEGIN DECLARE statoUtente int;IF EXISTS(
  SELECT
    *
  FROM
    UTENTE
  WHERE
    UTENTE.EMAIL = Email
    AND UTENTE.PW = pasw
) THEN
SET
  result = (TRUE);
  ELSE
SET
  result = (FALSE);END IF;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PrenotazioneP` (IN `Note` VARCHAR(300), IN `Auto` VARCHAR(10), IN `Utente` VARCHAR(30), IN `Partenza` VARCHAR(30), IN `Arrivo` VARCHAR(30), OUT `result` BOOLEAN)  BEGIN
    start transaction;
    SET result = (FALSE);
		
				INSERT INTO PRENOTAZIONE (INIZIO, FINE, NOTE, AUTO, UTENTE, INDIRIZZO_PARTENZA, INDIRIZZO_ARRIVO)
				VALUES (CURRENT_TIMESTAMP, NULL, Note, Auto, Utente, Partenza, Arrivo);

			commit work;
				SET result = (TRUE);
       
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `printf` (`mytext` TEXT)  BEGIN

  select mytext as ``;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrazioneAziendale` (IN `Emailt` VARCHAR(30), IN `pasw` VARCHAR(30), IN `nome` VARCHAR(30), IN `cognome` VARCHAR(30), IN `datanascita` DATE, IN `luogo` VARCHAR(50), IN `nomeazienda` VARCHAR(30), OUT `result` BOOLEAN)  BEGIN
    start transaction;
	SET result = (FALSE);
         IF NOT EXISTS ( SELECT EMAIL
			           FROM UTENTE
				       WHERE EMAIL = Emailt)
			
            THEN IF EXISTS (SELECT *
							FROM AZIENDA
							WHERE NOMEAZIENDA = nomeazienda)
			
            THEN
                INSERT INTO UTENTE  (EMAIL, PW, NOME, COGNOME, DATANASCITA, LUOGO) VALUES (Emailt, pasw, nome, cognome, datanascita, luogo);
				INSERT INTO UTENTE_AZIENDALE  (EMAILA,NOMEAZIENDA) VALUES (Emailt, nomeazienda);
				SET result = (TRUE);
				commit work;
        
			ELSE
				CALL printf ('[ERRORE] AZIENDA NON PRESENTE NEL SISTEMA');
				rollback;
        	END IF;
    
		ELSE 
			CALL printf ('[ERRORE] UTENTE GIA\' REGISTRATO');
            rollback;
		END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrazioneUtente` (IN `EmailN` VARCHAR(30), IN `pasw` VARCHAR(30), IN `nome` VARCHAR(30), IN `cognome` VARCHAR(30), IN `datanascita` DATE, IN `luogo` VARCHAR(50))  BEGIN
    start transaction;
         IF NOT EXISTS ( SELECT EMAIL
			           FROM UTENTE
				       WHERE EMAIL = EmailN)
		THEN 
        
        
        INSERT INTO UTENTE (EMAIL, PW, NOME, COGNOME, DATANASCITA, LUOGO) VALUES (EmailN, pasw, nome, cognome, datanascita, luogo);
		commit work;
        
     ELSE
		CALL printf ('[ERRORE] UTENTE GIA\' REGISTRATO');
        rollback;
	END IF;
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `azienda`
--

CREATE TABLE `azienda` (
  `NOME` varchar(30) NOT NULL,
  `INDIRIZZO` varchar(50) NOT NULL,
  `TELEFONO` int(11) NOT NULL,
  `RECAPITO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `azienda`
--

INSERT INTO `azienda` (`NOME`, `INDIRIZZO`, `TELEFONO`, `RECAPITO`) VALUES
('a', 'a', 1, 1),
('intesa', 'ViaBerlusconi9', 657894321, 5555555),
('mediolanum', 'ViaTutankamon17', 789123456, 4444444),
('montepaschi', 'ViaBonaparte13', 987654321, 2222222),
('suissebank', 'ViaNerone15', 456789123, 3333333),
('unicredit', 'ViaNapoleone1', 123456789, 1111111);

-- --------------------------------------------------------

--
-- Struttura della tabella `foto`
--

CREATE TABLE `foto` (
  `IDFOTO` smallint(6) NOT NULL,
  `EMAIL_UTENTE` varchar(30) NOT NULL,
  `PATHFOTO` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `foto`
--

INSERT INTO `foto` (`IDFOTO`, `EMAIL_UTENTE`, `PATHFOTO`) VALUES
(4, 'test', 'uploads/5ca72f6020b386.39792214.jpg'),
(5, 'test', 'uploads/5ca72f9f0f35e4.52734418.jpg'),
(6, 'test', 'uploads/5ca730fd7cb611.04110162.jpg'),
(8, 'test', 'uploads/5ca731400101a8.22222430.jpg'),
(9, 'test', 'uploads/5caafe8e3dbb44.00776729.jpg'),
(10, 'test', 'uploads/5cadde15a05993.99286335.jpg'),
(11, 'test', 'uploads/5cadde39934224.36496069.jpg'),
(12, 'test', 'uploads/5cadfde9312755.45271406.jpg'),
(13, 'test', 'uploads/5cadfed6b27242.00978945.jpg'),
(14, 'test', 'uploads/5cadff39e6a819.92321001.png'),
(15, 'test', 'uploads/5cadff5a62b7b0.71830222.png'),
(16, 'test', 'uploads/5caf2f1ad0fa12.19710556.png'),
(17, 'test', 'uploads/5caf2f2c532d87.44064305.png');

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `media_voto_utente`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `media_voto_utente` (
`UTENTE` varchar(30)
,`MEDIA_VOTO` decimal(9,4)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE `prenotazione` (
  `ID` smallint(6) NOT NULL,
  `INIZIO` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FINE` datetime DEFAULT NULL,
  `NOTE` varchar(300) DEFAULT NULL,
  `AUTO` varchar(10) NOT NULL,
  `UTENTE` varchar(30) NOT NULL,
  `INDIRIZZO_PARTENZA` varchar(30) NOT NULL,
  `INDIRIZZO_ARRIVO` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prenotazione`
--

INSERT INTO `prenotazione` (`ID`, `INIZIO`, `FINE`, `NOTE`, `AUTO`, `UTENTE`, `INDIRIZZO_PARTENZA`, `INDIRIZZO_ARRIVO`) VALUES
(46, '2019-04-08 13:01:01', NULL, 'ew', 'FN1000', 'test', 'via pinocchio', 'via tarzan'),
(48, '2019-04-10 11:04:26', NULL, '53h4w5', 'FN1000', 'test', 'via pinocchio', 'via tarzan');

-- --------------------------------------------------------

--
-- Struttura della tabella `privata`
--

CREATE TABLE `privata` (
  `NOME` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `privata`
--

INSERT INTO `privata` (`NOME`) VALUES
('enjoy'),
('share&go\r');

-- --------------------------------------------------------

--
-- Struttura della tabella `pubblica`
--

CREATE TABLE `pubblica` (
  `NOME` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `pubblica`
--

INSERT INTO `pubblica` (`NOME`) VALUES
('corrente');

-- --------------------------------------------------------

--
-- Struttura della tabella `segnalazione`
--

CREATE TABLE `segnalazione` (
  `ID` smallint(6) NOT NULL,
  `EMAIL` varchar(30) DEFAULT NULL,
  `SOCIETA` varchar(30) DEFAULT NULL,
  `DATA` date NOT NULL,
  `TITOLO` varchar(20) NOT NULL,
  `TESTO` varchar(200) NOT NULL,
  `AUTO` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `segnalazione`
--

INSERT INTO `segnalazione` (`ID`, `EMAIL`, `SOCIETA`, `DATA`, `TITOLO`, `TESTO`, `AUTO`) VALUES
(1, 'oooo@g.ik', 'qqqqqqq', '2019-04-16', 'd', 'd', '1'),
(10, 'test', 'qqqqqqq', '2019-04-10', 'qwerty ', 'qwerty ', '1'),
(11, 'test', 'qqqqqqq', '2019-04-12', 'qwerty ', 'qaz ', '1'),
(12, 'test', 'qqqqqqq', '2019-04-12', 'qwerty ', 'qaz ', '1'),
(13, 'test', 'qqqqqqq', '2019-04-12', 'testo ', 'hvdebsvuibweuivfbfueibv ', '1'),
(15, 'test', 'qqqqqqq', '2019-04-14', 'x ', 'c ', '1'),
(16, 'test', 'qqqqqqq', '2019-04-20', 'ora ', 'ora ', '1'),
(17, 'test', 'qqqqqqq', '2019-04-26', 'asx ', 'q ', '1'),
(18, 'test', 'qqqqqqq', '2019-04-20', 'eewv ', 'f3f2 ', '1'),
(19, 'test', 'qqqqqqq', '2019-04-12', '1 ', '1 ', '1');

-- --------------------------------------------------------

--
-- Struttura della tabella `societa`
--

CREATE TABLE `societa` (
  `NOME` varchar(30) NOT NULL,
  `URL` varchar(30) NOT NULL,
  `TELEFONO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `societa`
--

INSERT INTO `societa` (`NOME`, `URL`, `TELEFONO`) VALUES
('corrente', 'www.corrente.it', 57225657),
('enjoy', 'www.enjoy.it', 45646153),
('qqqqqqq', 'qqq', 2),
('share&go', 'www.share&go.it', 15643213);

-- --------------------------------------------------------

--
-- Struttura della tabella `sosta`
--

CREATE TABLE `sosta` (
  `INDIRIZZO` varchar(30) NOT NULL,
  `LAT` decimal(10,6) NOT NULL,
  `LNG` decimal(10,6) NOT NULL,
  `RICARICA` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `sosta`
--

INSERT INTO `sosta` (`INDIRIZZO`, `LAT`, `LNG`, `RICARICA`) VALUES
('via aladin', '44.589572', '11.055191', 'NO'),
('via aristogatti', '41.901666', '12.496978', 'SI'),
('via cenerentola', '44.490385', '11.330260', 'SI'),
('via pinocchio', '44.499419', '11.326775', 'SI'),
('via pokahontas', '45.462946', '9.192363', 'SI'),
('via tarzan', '40.421824', '15.000394', 'NO');

-- --------------------------------------------------------

--
-- Struttura della tabella `tappa`
--

CREATE TABLE `tappa` (
  `ID_TRAGITTO` smallint(6) NOT NULL,
  `CITTA` varchar(20) NOT NULL,
  `VIA` varchar(30) NOT NULL,
  `LAT` float(10,6) NOT NULL,
  `LNG` float(10,6) NOT NULL,
  `ORARIO_ARRIVO` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `tragitto`
--

CREATE TABLE `tragitto` (
  `ID` smallint(6) NOT NULL,
  `EMAILP` varchar(30) DEFAULT NULL,
  `EMAILA` varchar(30) DEFAULT NULL,
  `KM` smallint(6) NOT NULL,
  `TIPO` enum('URBANO','EXTRA-URBANO','AUTOSTRADALE','MISTO') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `EMAIL` varchar(30) NOT NULL,
  `PW` varchar(30) NOT NULL,
  `NOME` varchar(30) NOT NULL,
  `COGNOME` varchar(30) NOT NULL,
  `DATANASCITA` date NOT NULL,
  `LUOGO` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`EMAIL`, `PW`, `NOME`, `COGNOME`, `DATANASCITA`, `LUOGO`) VALUES
('amedeo.einstein@fake.com', 'slizbur99', 'alberto', 'einstein', '1997-11-18', 'palermo\r'),
('asdfghjkl', 'vf', 'A', 'ASC', '2019-04-27', 'QC'),
('avwegfbwqeioufhbwqoivb', 'weqioufbuiewbviu', 'iebfiweb', 'efbuwe', '2019-04-25', 'ewfg'),
('carlo.dickens@fake.com', 'calcutta33', 'carlo', 'dickens', '1995-08-21', 'bologna\r'),
('dsbs@brfin.isd', 'fevf', 'efw', 'fa', '2019-04-17', 'CW'),
('ewdsafe@f.t', 'vWV', 'va', 'ASVC', '2019-04-10', 'S'),
('guido.lavespa@fake.com', 'ziopio123', 'guido', 'lavespa', '1990-04-26', 'bologna\r'),
('lucia.nanni@fake.com', 'nulla13', 'lucia', 'nanni', '2000-02-21', 'bologna\r'),
('mario.balotelli@fake.com', 'liga208', 'mario', 'balotelli', '1994-01-30', 'ascoli '),
('mario.rossi@fake.com', 'ciaociao', 'mario', 'rossi', '1997-12-12', 'anzio\r'),
('michele.buonaroti@fake.com', 'verza66', 'michelangelo', 'buonarroti', '1996-03-12', 'roma\r'),
('minellogiacefefomo@gmail.com', 'ewvwegv', 'Giacomo', 'Minello', '2019-04-17', 'Carbonera'),
('minellogiacomo+12345@gmail.com', 'qwerty', 'Giacomo', 'Minello', '2019-04-19', 'Treviso'),
('minellogiacomofeubwij@gmail.co', 'edwv wekjV J', 'Giacomo', 'Minello', '2019-04-25', 'Carbonera'),
('minellogiSAVFacomo@gmail.com', 'SAVAV', 'cd', 'sd', '2019-04-03', 'Treviso'),
('oooo@g.ik', 'd', 'wed', 'ewf', '2019-04-10', 'ew'),
('prova', 'prova', 'proca', 'efc', '2019-04-18', 'prova'),
('q@gmail.com', 'q', 'Giacomo', 'Minello', '2019-04-09', 'Treviso'),
('rrrrr@r.com', 'r', 'r', 'ref', '2019-04-02', 'r'),
('rwb@rfvb.it', 'wefa', 'sdva', 'fa', '2019-04-30', 'WEf'),
('saverio.staffelli@fake.com', 'beobeo', 'saverio', 'staffeli', '1979-01-01', 'milano\r'),
('silvio.capitini@fake.com', 'commesto', 'silvio', 'capitini', '1950-06-06', 'firenze\r'),
('test', 'test', 'test', 'test', '2019-03-12', 'bologna'),
('test1', 'wevwevW', 'we', 'sv', '2019-04-16', 'vbrreb'),
('test@test.test', 'vdvad', 'sdwd', 'sdcws', '2019-04-12', 's');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente_aziendale`
--

CREATE TABLE `utente_aziendale` (
  `EMAILA` varchar(30) NOT NULL,
  `NOMEAZIENDA` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utente_aziendale`
--

INSERT INTO `utente_aziendale` (`EMAILA`, `NOMEAZIENDA`) VALUES
('asdfghjkl', 'a'),
('avwegfbwqeioufhbwqoivb', 'a'),
('guido.lavespa@fake.com', 'montepaschi\r'),
('mario.balotelli@fake.com', 'unicredit'),
('minellogiacomofeubwij@gmail.co', 'enjoy'),
('q@gmail.com', 'a'),
('test1', 'a');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente_premium`
--

CREATE TABLE `utente_premium` (
  `EMAILP` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utente_premium`
--

INSERT INTO `utente_premium` (`EMAILP`) VALUES
('amedeo.einstein@fake.com\r'),
('carlo.dickens@fake.com'),
('michele.buonaroti@fake.com\r'),
('silvio.capitini@fake.com\r'),
('test');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente_semplice`
--

CREATE TABLE `utente_semplice` (
  `EMAILS` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utente_semplice`
--

INSERT INTO `utente_semplice` (`EMAILS`) VALUES
('lucia.nanni@fake.com'),
('mario.rossi@fake.com\r'),
('saverio.staffeli@fake.com\r');

-- --------------------------------------------------------

--
-- Struttura della tabella `valutazione`
--

CREATE TABLE `valutazione` (
  `ID` smallint(6) NOT NULL,
  `EMAIL` varchar(30) NOT NULL,
  `DATA` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TESTO` varchar(500) NOT NULL,
  `VOTO` smallint(6) NOT NULL,
  `UTENTE` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `valutazione`
--

INSERT INTO `valutazione` (`ID`, `EMAIL`, `DATA`, `TESTO`, `VOTO`, `UTENTE`) VALUES
(1, 'carlo.dickens@fake.com', '2019-04-08 11:31:04', 'wrg', 9, 'mario.balotelli@fake.com'),
(2, 'carlo.dickens@fake.com', '2019-04-08 11:35:32', 'testo', 2, 'test'),
(3, 'carlo.dickens@fake.com', '2019-04-08 00:00:00', 'dsv', 10, 'test'),
(4, 'test', '2019-04-08 00:00:00', 'ew', 2, 'carlo.dickens@fake.com'),
(5, 'test', '2019-04-10 00:00:00', 'sdc', 1, 'carlo.dickens@fake.com');

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `veicoli_disponibili`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `veicoli_disponibili` (
`TARGA` varchar(10)
,`MODELLO` varchar(20)
,`CAPIENZA` smallint(6)
,`DESCRIZIONE` varchar(200)
,`FERIALE` smallint(6)
,`FESTIVO` smallint(6)
,`SOCIETA` varchar(30)
,`AREA_SOSTA` varchar(30)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `veicolo`
--

CREATE TABLE `veicolo` (
  `TARGA` varchar(10) NOT NULL,
  `MODELLO` varchar(20) NOT NULL,
  `CAPIENZA` smallint(6) NOT NULL,
  `DESCRIZIONE` varchar(200) NOT NULL,
  `FERIALE` smallint(6) NOT NULL,
  `FESTIVO` smallint(6) NOT NULL,
  `SOCIETA` varchar(30) NOT NULL,
  `AREA_SOSTA` varchar(30) NOT NULL,
  `STATO` enum('IN USO','NON IN USO') DEFAULT 'NON IN USO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `veicolo`
--

INSERT INTO `veicolo` (`TARGA`, `MODELLO`, `CAPIENZA`, `DESCRIZIONE`, `FERIALE`, `FESTIVO`, `SOCIETA`, `AREA_SOSTA`, `STATO`) VALUES
('1', '1', 1, '1', 1, 1, 'qqqqqqq', 'qw', 'NON IN USO'),
('1111', 'panda', 4, 'economica', 10, 20, 'corrente', 'via tarzan', 'NON IN USO'),
('FN1000', 'portofino', 2, 'veloce', 100, 200, 'enjoy', 'via pinocchio', 'NON IN USO'),
('IT5555', 'velar', 5, 'spaziosa', 50, 100, 'share&go', 'via tarzan', 'NON IN USO'),
('JH3333', 'modelX', 6, 'elegante', 70, 140, 'share&go', 'via aladin', 'NON IN USO'),
('KL2222', 'aventador', 2, 'velocissima', 200, 400, 'enjoy', 'via cenerentola', 'NON IN USO'),
('MN9999', 'panda', 4, 'economica', 10, 20, 'corrente', 'via tarzan', 'NON IN USO'),
('QR6666', 'phantom', 4, 'prestigiosa', 180, 360, 'corrente', 'via aristogatti', 'NON IN USO'),
('TP8888', 'dodge', 4, 'sportiva', 60, 120, 'corrente', 'via cenerentola', 'NON IN USO'),
('UY4444', 'urus', 5, 'aggressiva', 90, 180, 'share&go', 'via pokahontas', 'NON IN USO'),
('XZ7777', 'batmobile', 4, 'eccentrica', 400, 800, 'corrente', 'via pinocchio', 'NON IN USO');

-- --------------------------------------------------------

--
-- Struttura per vista `media_voto_utente`
--
DROP TABLE IF EXISTS `media_voto_utente`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `media_voto_utente`  AS  select `valutazione`.`UTENTE` AS `UTENTE`,avg(`valutazione`.`VOTO`) AS `MEDIA_VOTO` from `valutazione` group by `valutazione`.`UTENTE` order by avg(`valutazione`.`VOTO`) desc ;

-- --------------------------------------------------------

--
-- Struttura per vista `veicoli_disponibili`
--
DROP TABLE IF EXISTS `veicoli_disponibili`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `veicoli_disponibili`  AS  select `veicolo`.`TARGA` AS `TARGA`,`veicolo`.`MODELLO` AS `MODELLO`,`veicolo`.`CAPIENZA` AS `CAPIENZA`,`veicolo`.`DESCRIZIONE` AS `DESCRIZIONE`,`veicolo`.`FERIALE` AS `FERIALE`,`veicolo`.`FESTIVO` AS `FESTIVO`,`veicolo`.`SOCIETA` AS `SOCIETA`,`veicolo`.`AREA_SOSTA` AS `AREA_SOSTA` from `veicolo` where (`veicolo`.`STATO` = 'NON IN USO') ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `azienda`
--
ALTER TABLE `azienda`
  ADD PRIMARY KEY (`NOME`);

--
-- Indici per le tabelle `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`IDFOTO`),
  ADD KEY `EMAIL_UTENTE` (`EMAIL_UTENTE`);

--
-- Indici per le tabelle `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `INDIRIZZO_PARTENZA` (`INDIRIZZO_PARTENZA`),
  ADD KEY `INDIRIZZO_ARRIVO` (`INDIRIZZO_ARRIVO`),
  ADD KEY `UTENTE` (`UTENTE`),
  ADD KEY `AUTO` (`AUTO`);

--
-- Indici per le tabelle `privata`
--
ALTER TABLE `privata`
  ADD PRIMARY KEY (`NOME`);

--
-- Indici per le tabelle `pubblica`
--
ALTER TABLE `pubblica`
  ADD PRIMARY KEY (`NOME`);

--
-- Indici per le tabelle `segnalazione`
--
ALTER TABLE `segnalazione`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AUTO` (`AUTO`),
  ADD KEY `EMAIL` (`EMAIL`),
  ADD KEY `SOCIETA` (`SOCIETA`);

--
-- Indici per le tabelle `societa`
--
ALTER TABLE `societa`
  ADD PRIMARY KEY (`NOME`);

--
-- Indici per le tabelle `sosta`
--
ALTER TABLE `sosta`
  ADD PRIMARY KEY (`INDIRIZZO`);

--
-- Indici per le tabelle `tappa`
--
ALTER TABLE `tappa`
  ADD PRIMARY KEY (`ID_TRAGITTO`,`VIA`);

--
-- Indici per le tabelle `tragitto`
--
ALTER TABLE `tragitto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `EMAILP` (`EMAILP`),
  ADD KEY `EMAILA` (`EMAILA`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`EMAIL`);

--
-- Indici per le tabelle `utente_aziendale`
--
ALTER TABLE `utente_aziendale`
  ADD PRIMARY KEY (`EMAILA`);

--
-- Indici per le tabelle `utente_premium`
--
ALTER TABLE `utente_premium`
  ADD PRIMARY KEY (`EMAILP`);

--
-- Indici per le tabelle `utente_semplice`
--
ALTER TABLE `utente_semplice`
  ADD PRIMARY KEY (`EMAILS`);

--
-- Indici per le tabelle `valutazione`
--
ALTER TABLE `valutazione`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `EMAIL` (`EMAIL`),
  ADD KEY `UTENTE` (`UTENTE`);

--
-- Indici per le tabelle `veicolo`
--
ALTER TABLE `veicolo`
  ADD PRIMARY KEY (`TARGA`),
  ADD KEY `SOCIETA` (`SOCIETA`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `foto`
--
ALTER TABLE `foto`
  MODIFY `IDFOTO` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `tragitto`
--
ALTER TABLE `tragitto`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `valutazione`
--
ALTER TABLE `valutazione`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`EMAIL_UTENTE`) REFERENCES `utente` (`EMAIL`);

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD CONSTRAINT `prenotazione_ibfk_1` FOREIGN KEY (`INDIRIZZO_PARTENZA`) REFERENCES `sosta` (`INDIRIZZO`),
  ADD CONSTRAINT `prenotazione_ibfk_2` FOREIGN KEY (`INDIRIZZO_ARRIVO`) REFERENCES `sosta` (`INDIRIZZO`),
  ADD CONSTRAINT `prenotazione_ibfk_3` FOREIGN KEY (`UTENTE`) REFERENCES `utente` (`EMAIL`),
  ADD CONSTRAINT `prenotazione_ibfk_4` FOREIGN KEY (`AUTO`) REFERENCES `veicolo` (`TARGA`);

--
-- Limiti per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  ADD CONSTRAINT `segnalazione_ibfk_1` FOREIGN KEY (`AUTO`) REFERENCES `veicolo` (`TARGA`),
  ADD CONSTRAINT `segnalazione_ibfk_2` FOREIGN KEY (`EMAIL`) REFERENCES `utente` (`EMAIL`),
  ADD CONSTRAINT `segnalazione_ibfk_3` FOREIGN KEY (`SOCIETA`) REFERENCES `societa` (`NOME`);

--
-- Limiti per la tabella `tappa`
--
ALTER TABLE `tappa`
  ADD CONSTRAINT `tappa_ibfk_1` FOREIGN KEY (`ID_TRAGITTO`) REFERENCES `tragitto` (`ID`);

--
-- Limiti per la tabella `tragitto`
--
ALTER TABLE `tragitto`
  ADD CONSTRAINT `tragitto_ibfk_1` FOREIGN KEY (`EMAILP`) REFERENCES `utente_premium` (`EMAILP`),
  ADD CONSTRAINT `tragitto_ibfk_2` FOREIGN KEY (`EMAILA`) REFERENCES `utente_aziendale` (`EMAILA`);

--
-- Limiti per la tabella `utente_aziendale`
--
ALTER TABLE `utente_aziendale`
  ADD CONSTRAINT `utente_aziendale_ibfk_1` FOREIGN KEY (`EMAILA`) REFERENCES `utente` (`EMAIL`);

--
-- Limiti per la tabella `valutazione`
--
ALTER TABLE `valutazione`
  ADD CONSTRAINT `valutazione_ibfk_1` FOREIGN KEY (`EMAIL`) REFERENCES `utente_premium` (`EMAILP`),
  ADD CONSTRAINT `valutazione_ibfk_2` FOREIGN KEY (`UTENTE`) REFERENCES `utente` (`EMAIL`);

--
-- Limiti per la tabella `veicolo`
--
ALTER TABLE `veicolo`
  ADD CONSTRAINT `veicolo_ibfk_1` FOREIGN KEY (`SOCIETA`) REFERENCES `societa` (`NOME`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
