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


	
	public function registerBusiness($nome, $cognome, $email, $password, $dataNascita, $citta){
		

		try{

			$query_signup = $this -> db -> prepare("CALL RegistrazioneUtente ('$email','$password', '$nome', '$cognome','$dataNascita','$citta')");
			$query_signup -> execute();
			$query_signup->closeCursor();

			$query_select_signup = $this -> db -> prepare("SELECT @res");
			$query_select_signup -> execute();
			$result = $query_select_signup ->fetch();
			$query_select_signup->closeCursor();
			// $this -> db ->closeCursor();
            
			//TO DO: ADD MONGODB LOG query+log
			
			//$risultato = $result['@res']; 

		}catch(PDOException $e) {
    		return ("[ERRORE] SignUp non riuscito. Errore: ".$e->getMessage());
    		// exit();
  		}

		//return $risultato;
	}

	
	}

	





}



?>