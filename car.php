<?php
include_once('connection.php');
include_once('connectionMongo.php');
if(!isset($_SESSION)){
    session_start();
}

/**
 * Class car
 */
class car
{
    private $db;

    /**
     * car constructor.
     */
    public function __construct(){
        $this -> db = new Connection();
        $this -> db = $this -> db -> dbConnect();

    }

    /**
     * @param $Email
     * @param $SocietaAutomobile
     * @param $DataSegnalazione
     * @param $TitoloSegnalazione
     * @param $TestoSegnalazione
     * @param $Automobile
     * @return string
     */
    public function insertSegnalazione($Email, $SocietaAutomobile, $DataSegnalazione,$TitoloSegnalazione, $TestoSegnalazione,$Automobile){
        try{
            $query = $this -> db -> prepare("CALL InserisciSegnalazione('$Email', '$SocietaAutomobile', '$DataSegnalazione', '$TitoloSegnalazione', '$TestoSegnalazione', '$Automobile',@res)");
            $query -> execute();
            $query -> closeCursor();
            $query_select = $this -> db -> prepare("SELECT @res");
            $query_select -> execute();
            $result = $query_select ->fetch();
            $query_select->closeCursor();
            $risultato = $result['@res'];
            $doc=array("Query" => $query, "Risultato" => $risultato);
            mongoLog($doc);
        }catch(PDOException $e) {
            return ("[ERRORE] op non riuscito. Errore: ".$e->getMessage());
            // exit();
        }
        return $risultato;
    }

    /**
     * @param $Note
     * @param $Automobile
     * @param $Email
     * @param $IndirizzoPartenza
     * @param $IndirizzoArrivo
     * @return string
     */
    public function insertPrenotazione( $Note,  $Automobile, $Email, $IndirizzoPartenza, $IndirizzoArrivo){
        try{
            $query = $this -> db -> prepare("CALL InserisciPrenotazione( '$Note', '$Automobile','$Email', '$IndirizzoPartenza', '$IndirizzoArrivo',@res)");
            $query -> execute();
            $query -> closeCursor();
            $query_select = $this -> db -> prepare("SELECT @res");
            $query_select -> execute();
            $result = $query_select ->fetch();
            $query_select->closeCursor();
            $risultato = $result['@res'];
            $doc=array("Query" => $query, "Risultato" => $risultato);
            mongoLog($doc);
        }catch(PDOException $e) {
            return ("[ERRORE] op non riuscito. Errore: ".$e->getMessage());
            // exit();
        }
        return $risultato;
    }

    /**
     * @return string
     */
    public function registerVeicolo(){
        try{
            $query_signup = $this -> db -> prepare("CALL RegistrazioneVeicolo ()");
            $query_signup -> execute();
            $query_signup->closeCursor();
            $query_select_signup = $this -> db -> prepare("SELECT @res");
            $query_select_signup -> execute();
            $result = $query_select_signup ->fetch();
            $query_select_signup->closeCursor();
            $risultato = $result['@res'];
            $doc=array("Query" => $query_signup, "Risultato" => $risultato);
            mongoLog($doc);
        }catch(PDOException $e) {
            return ("[ERRORE] RegistrazioneVeicolo non riuscito. Errore: ".$e->getMessage());
            // exit();
        }
        return $risultato;
    }

    /**
     * @return false|PDOStatement
     */
    public function getVeicoliDisponibili(){
        try {
            $sql='SELECT *  FROM VEICOLI_DISPONIBILI';
            $res=$this -> db ->query($sql);
            return $res;
        }
        catch(PDOException $e) {
            echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
            // exit();
        }
    }

    /**
     * @param $area
     * @return false|PDOStatement
     */
    public function getLocation($area){
        try {
            $sql='SELECT *  FROM SOSTA WHERE SOSTA.INDIRIZZO="'.$area.'";';
            $res=$this -> db ->query($sql);
            return $res;
        }
        catch(PDOException $e) {
            echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
            // exit();
        }
    }

    /**
     * @return false|PDOStatement
     */
    public function getVeicoli(){
        try {
            $sql='SELECT *  FROM VEICOLO';
            $res=$this -> db ->query($sql);
            return $res;
        }
        catch(PDOException $e) {
            echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
            // exit();
        }
    }


    /**
     * @param $Email
     * @return string
     */
    public function insertTragitto($Email,$km,$tipo){
        try{
            $query = $this -> db -> prepare("CALL InserisciTragitto('$Email','$km','$tipo',@res)");
            $query -> execute();
            $query -> closeCursor();
            $query_select = $this -> db -> prepare("SELECT @res");
            $query_select -> execute();
            $result = $query_select ->fetch();
            $query_select->closeCursor();
            $risultato = $result['@res'];
            $doc=array("Query" => $query, "Risultato" => $risultato);
            mongoLog($doc);
        }catch(PDOException $e) {
            return ("[ERRORE] op non riuscito. Errore: ".$e->getMessage());
            // exit();
        }
        return $risultato;
    }

    /**
     * @param $id
     * @param $citta
     * @param $via
     * @param $orario
     * @return string
     */
    public function insertTappa($id,$citta,$via,$orario){
        try{
            $query = $this -> db -> prepare("CALL InserisciTappa('$id','$citta','$via','$orario')");
            $query -> execute();
            $query -> closeCursor();
            $query_select = $this -> db -> prepare("SELECT @res");
            $query_select -> execute();
            $result = $query_select ->fetch();
            $query_select->closeCursor();
            $risultato = $result['@res'];
            $doc=array("Query" => $query, "Risultato" => $risultato);
            mongoLog($doc);
        }catch(PDOException $e) {
            return ("[ERRORE] op non riuscito. Errore: ".$e->getMessage());
            // exit();
        }
        return $risultato;
    }

    /**
     * @param $Note
     * @param $Automobile
     * @param $Email
     * @param $IndirizzoPartenza
     * @param $IndirizzoArrivo
     * @return string
     */
    public function insertPrenotazioneAziendale($Tragitto, $Note,  $Automobile, $Email, $IndirizzoPartenza, $IndirizzoArrivo){
        try{
            $query = $this -> db -> prepare("CALL InserisciPrenotazioneAziendale('$Tragitto','$Note', '$Automobile','$Email', '$IndirizzoPartenza', '$IndirizzoArrivo',@res)");
            $query -> execute();
            $query -> closeCursor();
            $query_select = $this -> db -> prepare("SELECT @res");
            $query_select -> execute();
            $result = $query_select ->fetch();
            $query_select->closeCursor();
            $risultato = $result['@res'];
            $doc=array("Query" => $query, "Risultato" => $risultato);
            mongoLog($doc);
        }catch(PDOException $e) {
            return ("[ERRORE] op non riuscito. Errore: ".$e->getMessage());
            // exit();
        }
        return $risultato;
    }

}

?>