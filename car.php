<?php

include_once('connection.php');

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
	

	public function registerVeicolo(){
		

		try{

			$query_signup = $this -> db -> prepare("CALL RegistrazioneVeicolo ()");
			$query_signup -> execute();
			$query_signup->closeCursor();

			$query_select_signup = $this -> db -> prepare("SELECT @res");
			$query_select_signup -> execute();
			$result = $query_select_signup ->fetch();
			$query_select_signup->closeCursor();
            
			//TO DO: ADD MONGODB LOG query+log
			
			$risultato = $result['@res']; 

		}catch(PDOException $e) {
    		return ("[ERRORE] RegistrazioneVeicolo non riuscito. Errore: ".$e->getMessage());
    		// exit();
  		}

		return $risultato;
	}

	

	public function deleteVeicolo(){
		
		try{
		
		
		}
  		catch(PDOException $e) {
    		echo("[ERRORE] Delete non riuscita. Errore: ".$e->getMessage());
    		
  		}

		if ($risultato == 1){
			header("Location: ");
			die();
		}else{
			echo "error !";
		}
	}


	

}



?>