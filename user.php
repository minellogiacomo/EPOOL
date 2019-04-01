<?php


include_once('connection.php');

if(!isset($_SESSION)){ 
    session_start(); 
}


/**
* 
*/
class User
{
	private $db;

	public function __construct(){
		$this -> db = new Connection();
		$this -> db = $this -> db -> dbConnect();

	}
	

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


	public function SignupCommercial($nickname, $email, $password, $nascita, $cittaResidenza, $regione, $stato, $tipo){
		
		try{
			$cittaResidenza = addslashes($cittaResidenza);
			$regione = addslashes($regione);
			$stato = addslashes($stato);
			$sql = "SELECT * FROM Utente WHERE Nickname = '$nickname'";
			$res=$this -> db ->query($sql);

		}catch(PDOException $e) {
    		return ("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
        	$arr[$i][] = $row['Nickname'];
        	$arr[$i][] = $row['Email'];
        	$arr[$i][] = $row['Password'];
        	$arr[$i][] = $row['dataNascita'];
        	$arr[$i][] = $row['CittaResidenza'];
        	$arr[$i][] = $row['Tipo'];
        	$i++;
  		}

  		if (count($arr) == 0) {
  			return 1;
  		}else{
  			return 0;
  		}
	}

	public function registerUser($nome, $cognome, $email, $password, $dataNascita, $citta){
		

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

	public function getInfoUser($nickname,$password){
		
		try {
     		
     		$sql='SELECT Nickname,Password,CittaResidenza,Tipo,Email,dataNascita,Regione,Citta.Stato FROM Utente,Citta  WHERE (Utente.CittaResidenza = Citta.Nome ) AND (Nickname="'.$nickname.'") AND (Password="'.$password.'")';
     		$res=$this -> db ->query($sql);
     		$row=$res->fetch();
     		$res->closeCursor();
		}
  		catch(PDOException $e) {
    		echo("[ERRORE] Query SQL (getInfoUser) non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
		
   		
   		
   		$_SESSION["uname"] = $row["Nickname"];
   		$_SESSION["psswd"] = $row["Password"];
   		$_SESSION["citta"] = $row["CittaResidenza"];
   		$_SESSION["tipo"] = $row["Tipo"];
   		$_SESSION["email"] = $row["Email"];
   		$_SESSION["datan"] = $row["dataNascita"];
   		$_SESSION["regione"] = $row["Regione"];
   		$_SESSION["stato"] = $row["Stato"];



   		// echo (	" NOME : ".$_SESSION["uname"]." = ".$row["Nickname"]." <br>".
   		// 		" PSSWD : ".$_SESSION["psswd"]." = ".$row["Password"]." <br>".
   		// 		" CITTA : ".$_SESSION["citta"]." = ".$row["CittaResidenza"]." <br>".
   		// 		" TIPO : ".$_SESSION["tipo"]." = ".$row["Tipo"]." <br>".
   		// 		" EMAIL : ".$_SESSION["email"]." = ".$row["Email"]." <br>");
    	
    	// print_r($_SESSION);
	}

	public function deleteUtente($nicknameUtente, $password){
		
		try{
		
		$query = $this -> db -> prepare("CALL DeleteUtente('$nicknameUtente','$password',@res)");
		$query->execute();
		$query->closeCursor();

		$query2 = $this -> db -> prepare("SELECT @res");
		$query2 -> execute();
		$result = $query2 -> fetch();
		$query2->closeCursor();

		$risultato = $result['@res'];

		}
  		catch(PDOException $e) {
    		echo("[ERRORE] Delete User non riuscita. Errore: ".$e->getMessage());
    		
  		}

		if ($risultato == 1){
			header("Location: http://localhost/Progetto_0.0.2/index.php"); //per max
			//header("Location: http://localhost:8888/Progetto_0.0.2/index.php");
			die();
		}else{
			echo "Password errata !";
		}
	}

	public function sendMessage($titolo, $descrizione, $nicknameMittente, $nicknameDestinatario){
		try{
			$titolo = addslashes($titolo);
			$descrizione = addslashes($descrizione);
			$query = $this -> db -> prepare("CALL SendMessage('$titolo','$descrizione','$nicknameMittente','$nicknameDestinatario',@res)");
		
			$query->execute();
			$query->closeCursor();

			$query2 = $this -> db ->prepare("SELECT @res");
			$query2->execute();
			$result = $query2->fetch();
			$query2->closeCursor();

			$risultato = $result['@res'];
		

		}
  		catch(PDOException $e) {
    		echo("[ERRORE] SendMessage non riuscita. Errore: ".$e->getMessage());
    		
  		}

		if ($risultato != 1){
			echo "[ERRORE] SendMessage non è stata eseguita con successo ";
		}
		
	}

	public function insertCommercialAttractiveness($nomeAttrattiva,$nomeCitta,$Indirizzo,$lng,$lat,$nickname,$password,$foto,$telefono,$sitoweb){
		


		try{
			$nomeAttrattiva = addslashes($nomeAttrattiva);
			$nomeCitta = addslashes($nomeCitta);
			//si potrebbe mettere count(*) e ritorna il numero e ti eviti il ciclo for
			$sql = "SELECT * FROM Attrattiva WHERE Nome = '".$nomeAttrattiva."' AND NomeCitta = '".$nomeCitta."'";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		return ("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
        	$arr[$i][] = $row['Nome'];
        	$arr[$i][] = $row['NomeCitta'];
        	$i++;
  		}
  		
  		//se non ho trovato attrattive con lo stesso nome della stessa città
  		if (count($arr) == 0) {

  			$cittaInsert = $_SESSION["citta"];
  			$regioneInsert = $_SESSION["regione"];
  			$statoInsert = $_SESSION["stato"];
  			
  			try{
	  			$query_insertCitta = $this -> db -> prepare("CALL InsertCitta('$cittaInsert','$regioneInsert','$statoInsert',@res)");
				$query_insertCitta -> execute();
				$query_insertCitta->closeCursor();

				$query_select_insertCitta = $this -> db -> prepare("SELECT @res");
				$query_select_insertCitta -> execute();
				$result = $query_select_insertCitta -> fetch();
				$query_select_insertCitta->closeCursor();

				$risultato = $result['@res'];

				// echo($risultato);
			}
  			catch(PDOException $e) {
    			return("[ERRORE] InsertCitta non riuscita. Errore: ".$e->getMessage());
    			// exit();
  			}

  			
  				$nicknameSign = $_SESSION["uname"];
				$emailSign = $_SESSION["email"];
				$passwordSign = $_SESSION["psswd"];
				$dataSign = $_SESSION["datan"];
				$tipoSign = $_SESSION["tipo"];



				try{
				$query_signup = $this -> db -> prepare("CALL SignUp('$nickname','$emailSign','$password','$dataSign','$cittaInsert','$tipoSign',@res)");
				$query_signup -> execute();
				$query_signup ->closeCursor();

				$query_select_signup = $this -> db -> prepare("SELECT @res");
				$query_select_signup -> execute();
				$result = $query_select_signup -> fetch();
				$query_select_signup->closeCursor();

				$risultato = $result['@res'];
				
				}catch(PDOException $e) {
	    			return("[ERRORE] Signup non riuscita. Errore: ".$e->getMessage());
	    			// exit();
	  			}
  			
			
			//Se signup è andato a buon fine
			if($risultato == 1){
				//Inserisco l'attività commerciale
	  			try{
	  			$query = $this -> db -> prepare("CALL InsertAttivitaCommerciale('$nomeAttrattiva','$nomeCitta','$Indirizzo','$lng','$lat','$nickname','$foto','$telefono','$sitoweb',@res)" );
				$query -> execute();
				$query->closeCursor();

				$query2 = $this -> db -> prepare("SELECT @res");
				$query2 -> execute();
				$result = $query2 -> fetch();
				$query2->closeCursor();
				$risultato = $result['@res'];
				
				}catch(PDOException $e) {
	    			return("[ERRORE] InsertAttivitaCommerciale non riuscita. Errore: ".$e->getMessage());
	    			// exit();
	  			}
	  		}//chiude se sign up è andato a buon fine
  		}else{
  			$risultato = 0;
  		}

  		return $risultato;
	}

	public function displayListaUtentiIndex(){
		try{
			$sql = "SELECT * FROM Utente WHERE Stato = 1";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
        	$arr[$i][] = $row['Nickname'];
        	$arr[$i][] = $row['Email'];
        	//$arr[$i][] = $row['Password'];
        	$arr[$i][] = $row['dataNascita'];
        	$arr[$i][] = $row['CittaResidenza'];
        	$arr[$i][] = $row['Tipo'];
        	$i++;
  		}

  		return $arr;
	}

	public function getListaMessaggiPubblici(){
		
		try{
			$sql = "SELECT * FROM Messaggio WHERE Tipo = 'Pubblico'";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		// $arr = array();
  		// $i = 0;
  		// foreach ($res as $row) {
  

  		return $res;
	}

	public function getListaMessaggi($nickname,$receiver){
		
		try{
			$sql = ("SELECT Titolo,Descrizione,NicknameMittente from Messaggio where (NicknameMittente = '".$nickname."' AND NicknameDestinatario = '".$receiver."') OR (NicknameMittente ='".$receiver."' AND NicknameDestinatario = '".$nickname."')");
			$res = $this -> db ->query($sql);
		}catch(PDOException $e) {
    		return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
  		}

  		return $res;
	}

}



?>