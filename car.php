<?php
include_once('connection.php');
include_once('connectionMongo.php');
if(!isset($_SESSION)){
    session_start();
}
class car
{
    private $db;
    public function __construct(){
        $this -> db = new Connection();
        $this -> db = $this -> db -> dbConnect();

    }

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


    public function insertTragitto($Email){
        try{
            $query = $this -> db -> prepare("CALL InserisciTragitto('$Email',@res)");
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