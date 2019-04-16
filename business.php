<?php
include_once('connection.php');
include_once('connectionMongo.php');
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Class Business
 */
class Business
{
    private $db;

    /**
     * Business constructor.
     */
    public function __construct()
    {
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();

    }


    /**
     * @param $email
     * @param $password
     * @return string
     */
    public function LoginBusiness($email, $password)
    {
        try {
            $query = $this->db->prepare("CALL LoginAziendale('$email','$password',@res)");
            $query->execute();
            $query2 = $this->db->prepare("SELECT @res");
            $query2->execute();
            $result = $query2->fetch();
            $query2->closeCursor();
            $risultato = $result['@res'];
        } catch (PDOException $e) {
            return "[Errore] Login non andato a buon fine " . $e->getMessage();
            // return $e->getMessage();
        }
        return $risultato;
    }

    /**
     * @param $nome
     * @return false|PDOStatement|string
     */
    public function visualizzaPdf($nome)
    {
        try {
            $sql = 'SELECT PDF.PATH FROM PDF WHERE PDF.NOME_SOCIETA="' . $nome . '";';
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            return ("[ERRORE] Query SQL non riuscita. Errore: " . $e->getMessage());
            // exit();
        }
    }

    /**
     * @return false|PDOStatement
     */
    public function getInfoAziende()
    {
        try {
            $sql = 'SELECT *  FROM AZIENDA';
            $res = $this->db->query($sql);
            return $res;
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL (getInfo) non riuscita. Errore: " . $e->getMessage());
            // exit();
        }
    }

    /**
     * @return false|PDOStatement
     */
    public function getInfoSocieta()
    {

        try {
            $sql = 'SELECT *  FROM SOCIETA';
            $res = $this->db->query($sql);
            return $res;
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL (getInfo) non riuscita. Errore: " . $e->getMessage());
            // exit();
        }
    }

    /**
     * @param $nome
     * @param $cognome
     * @param $email
     * @param $password
     * @param $dataNascita
     * @param $citta
     * @param $azienda
     * @return string
     */
    public function RegistrazioneAziendale($nome, $cognome, $email, $password, $dataNascita, $citta, $azienda)
    {
        try {
            $query_signup = $this->db->prepare("CALL RegistrazioneAziendale ('$email','$password', '$nome', '$cognome','$dataNascita','$citta', '$azienda',@res)");
            $query_signup->execute();
            $query_signup->closeCursor();
            $query_select_signup = $this->db->prepare("SELECT @res");
            $query_select_signup->execute();
            $result = $query_select_signup->fetch();
            $query_select_signup->closeCursor();
            $risultato = $result['@res'];
            $doc = array("Query" => $query_signup, "Risultato" => $risultato);
            mongoLog($doc);
        } catch (PDOException $e) {
            return ("[ERRORE] SignUp non riuscito. Errore: " . $e->getMessage());
            // exit();
        }
        return $risultato;
    }

    /**
     * @param $email
     * @param $testo
     * @param $voto
     * @param $utente
     * @return string
     */
    public function insertValutazione($email, $testo, $voto, $utente)
    {
        try {
            $query = $this->db->prepare("CALL InserisciValutazione ('$email','$testo', '$voto', '$utente',@res)");
            $query->execute();
            $query->closeCursor();
            $query_select = $this->db->prepare("SELECT @res");
            $query_select->execute();
            $result = $query_select->fetch();
            $query_select->closeCursor();
            $risultato = $result['@res'];
            $doc = array("Query" => $query, "Risultato" => $risultato);
            mongoLog($doc);
        } catch (PDOException $e) {
            return ("[ERRORE]  non riuscito. Errore: " . $e->getMessage());
            // exit();
        }
        return $risultato;
    }



}

?>