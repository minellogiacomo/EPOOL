<?php


include_once('connection.php');

if(!isset($_SESSION)){ 
    session_start(); 
}

class Business
{
	private $db;

	public function __construct(){
		$this -> db = new Connection();
		$this -> db = $this -> db -> dbConnect();

	}
	

	public function LoginBusiness($email, $password){
	
		try {
    		
			$query = $this -> db -> prepare("CALL LoginAziendale('$email','$password',@res)");
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

    public function getInfoAziende(){

        try {
            $sql='SELECT *  FROM AZIENDA';
            $res=$this -> db ->query($sql);
            return $res;
        }
        catch(PDOException $e) {
            echo("[ERRORE] Query SQL (getInfoUser) non riuscita. Errore: ".$e->getMessage());
            // exit();
        }
    }
	
	public function RegistrazioneAziendale($nome, $cognome, $email, $password, $dataNascita, $citta, $azienda){
		try{
			$query_signup = $this -> db -> prepare("CALL RegistrazioneAziendale ('$email','$password', '$nome', '$cognome','$dataNascita','$citta', '$azienda',@res)");
			$query_signup -> execute();
			$query_signup->closeCursor();
			$query_select_signup = $this -> db -> prepare("SELECT @res");
			$query_select_signup -> execute();
			$result = $query_select_signup ->fetch();
			$query_select_signup->closeCursor();
			//TO DO: ADD MONGODB LOG query+log
			$risultato = $result['@res'];
		}catch(PDOException $e) {
    		return ("[ERRORE] SignUp non riuscito. Errore: ".$e->getMessage());
    		// exit();
  		}
		return $risultato;
	}

    public function insertValutazione($email,$testo,$voto,$utente){
        try{
            $query= $this -> db -> prepare("CALL InserisciValutazione ('$email','$testo', '$voto', '$utente',@res)");
            $query -> execute();
            $query->closeCursor();
            $query_select= $this -> db -> prepare("SELECT @res");
            $query_select-> execute();
            $result = $query_select ->fetch();
            $query_select->closeCursor();
            //TO DO: ADD MONGODB LOG query+log
            $risultato = $result['@res'];
        }catch(PDOException $e) {
            return ("[ERRORE]  non riuscito. Errore: ".$e->getMessage());
            // exit();
        }
        return $risultato;
    }

	
	}

	



?>