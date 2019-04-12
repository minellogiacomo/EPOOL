CREATE TABLE PDF (

                      IDPDF SMALLINT AUTO_INCREMENT PRIMARY KEY,
                      NOME_SOCIETA VARCHAR(30) NOT NULL,
                      PATH varchar(100) NOT NULL,

                      FOREIGN KEY (NOME_SOCIETA) REFERENCES pubblica(NOME)

) ENGINE=INNODB;