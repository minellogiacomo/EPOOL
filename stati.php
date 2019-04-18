<?php

include_once('connection.php');

/**
 * Class stati
 */
class stati
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();
    }
    //Visualizzare la classifica degli utenti premium/dipendenti sulla base del voto medio ricevuto da altri utenti

    /**
     * @return false|PDOStatement
     */
    public function getClassificaVoto()
    {

        try {
            $sql = 'SELECT *  FROM media_voto_utente ';
            $res = $this->db->query($sql);
            return $res;
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL non riuscita. Errore: " . $e->getMessage());
            // exit();
        }
    }

    //Visualizzare la classifica degli utenti più attivi, calcolata in base al numero di segnalazioni inserite

    /**
     * @return false|PDOStatement
     */
    public function getClassificaSegnalazioni()
    {

        try {
            $sql = 'SELECT EMAIL, COUNT(*) as NUMERO_SEGNALAZIONI  FROM  segnalazione GROUP BY EMAIL ORDER BY NUMERO_SEGNALAZIONI DESC';
            $res = $this->db->query($sql);
            return $res;
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL non riuscita. Errore: " . $e->getMessage());
            // exit();
        }
    }

    //Visualizzare la classifica dei modelli di veicolo più prenotati all’interno della piattaforma

    /**
     * @return false|PDOStatement
     */
    public function getClassificaVeicoli()
    {

        try {
            $sql = 'SELECT MODELLO, COUNT(*) as NUMERO_PRENOTAZIONI FROM prenotazione, veicolo WHERE (PRENOTAZIONE.AUTO=VEICOLO.TARGA) GROUP BY MODELLO ORDER BY NUMERO_PRENOTAZIONI DESC';
            $res = $this->db->query($sql);
            return $res;
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL non riuscita. Errore: " . $e->getMessage());
            // exit();
        }
    }

}


?>