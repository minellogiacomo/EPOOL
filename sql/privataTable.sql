CREATE TABLE PRIVATA (
	
    NOME VARCHAR(30) PRIMARY KEY REFERENCES SOCIETA(NOME)
    /*BROCHURE VARCHAR(30) /*TO DO: save pdf on server and save the pdf path in sql*/
    
    ) ENGINE=INNODB;