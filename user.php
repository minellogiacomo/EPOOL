<?php

include_once('connection.php');
include_once('connectionMongo.php');
if(!isset($_SESSION)){
    session_start();
}

/**
 * Class User
 */
class User
{
    private $db;

    public function __construct(){
        $this -> db = new Connection();
        $this -> db = $this -> db -> dbConnect();

    }

    /**
     * @param $email
     * @return false|PDOStatement|string
     */
    public function getBookingList($email){
        try{
            $sql = "SELECT *
               FROM PRENOTAZIONE
               WHERE UTENTE = '$email'";
            $res= $this-> db ->query($sql);
            return $res;
        }catch(PDOException $e) {
            return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
        }
    }

    /**
     * @param $email
     * @return string
     */
    public function getInfoUserType($email){

        try {

            $query = $this -> db -> prepare("CALL LoginType('$email',@res)");
            $query -> execute();
            $query2 = $this -> db -> prepare("SELECT @res");
            $query2 -> execute();
            $result = $query2 -> fetch();
            $query2->closeCursor();

            $risultato = $result['@res'];

        } catch (PDOException $e) {
            return "[Errore] LoginType non andato a buon fine ".$e->getMessage();
            // return $e->getMessage();

        }
        return $risultato;
    }

    /**
     * @param $email
     * @return false|PDOStatement|string
     */
    public function visualizzaFoto($email){
        try {
            $sql='SELECT PATHFOTO FROM FOTO WHERE FOTO.EMAIL_UTENTE="'.$email.'";';
            $res=$this -> db ->query($sql);
            return $res;
        }
        catch(PDOException $e) {
            return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
            // exit();
        }
    }

    /**
     * @param $email
     * @param $password
     * @return string
     */
    public function Login($email, $password){

        try {

            $query = $this -> db -> prepare("CALL Login('$email','$password',@res)");
            $query -> execute();
            $query2 = $this -> db -> prepare("SELECT @res");
            $query2 -> execute();
            $result = $query2 -> fetch();
            $query2->closeCursor();

            $risultato = $result['@res'];

        } catch (PDOException $e) {
            return "[Errore] Login non andato a buon fine ".$e->getMessage();
            // return $e->getMessage();

        }
        return $risultato;
    }

    /**
     * @return bool
     */
    public function logoutUser() {
        //session_destroy();
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        return true;
    }

    /**
     * @param $nome
     * @param $cognome
     * @param $email
     * @param $password
     * @param $dataNascita
     * @param $citta
     * @return string
     */
    public function registerUser($nome, $cognome, $email, $password, $dataNascita, $citta){
        try{

            $query_signup = $this -> db -> prepare("CALL RegistrazioneUtente ('$email','$password', '$nome', '$cognome','$dataNascita','$citta')");
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
            return ("[ERRORE] SignUp non riuscito. Errore: ".$e->getMessage());
            // exit();
        }

        //return $risultato;
    }

    /**
     * @param $email
     * @return false|PDOStatement
     */
    public function getInfoUtente($email){

        try {

            $sql='SELECT EMAIL, PW, NOME, COGNOME, DATANASCITA, LUOGO  FROM UTENTE WHERE (UTENTE.EMAIL="'.$email.'")';
            $res=$this -> db ->query($sql);
            return $res;
        }
        catch(PDOException $e) {
            echo("[ERRORE] Query SQL (getInfoUser) non riuscita. Errore: ".$e->getMessage());
            // exit();
        }
    }

    /**
     * @param $email
     * @return false|PDOStatement
     */
    public function getInfoUtenti($email){

        try {
            $sql='SELECT EMAIL, NOME, COGNOME, DATANASCITA, LUOGO  FROM UTENTE WHERE NOT (UTENTE.EMAIL="'.$email.'")';
            $res=$this -> db ->query($sql);
            return $res;
        }
        catch(PDOException $e) {
            echo("[ERRORE] Query SQL (getInfoUser) non riuscita. Errore: ".$e->getMessage());
            // exit();
        }
    }

    /**
     * @param $email
     * @param $path
     * @return string
     */
    public function insertFoto($email, $path){
        try {
            $query = $this -> db -> prepare("CALL InsertFoto('$email','$path',@res)");
            $query -> execute();
            $query2 = $this -> db -> prepare("SELECT @res");
            $query2 -> execute();
            $result = $query2 -> fetch();
            $query2->closeCursor();
            $risultato = $result['@res'];
            $doc=array("Query" => $query, "Risultato" => $risultato);
            mongoLog($doc);
        } catch (PDOException $e) {
            return "[Errore] Login non andato a buon fine ".$e->getMessage();
        }
        return $risultato;
    }



}

?>