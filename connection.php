<?php
class Connection
{
	
	public function dbConnect(){
		try {
      		$pdo=new PDO('mysql:host=localhost;dbname=EPOOL','root','');
      		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   		}
   		catch(PDOException $e) {
      		echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
            // if(isset($_SESSION)){
            //    session_destroy();
            // }
      		exit();
   		}
		return $pdo;
	}
}
?>