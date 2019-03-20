<?php 

include_once('user.php');
 if(!isset($_SESSION)) 
    { 
        session_start();
        echo "creo sessione index ";
    } 
if(isset($_POST['submit'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$object = new User();
	$risultato = $object ->Login($email, $password);
	if ($risultato == 1) {
		//$object -> getInfoUser($nickname, $password);
		header("Location: http://localhost:/Progetto_0.0.2/home.php"); 
		die();
	}else{
		echo "<script type='text/javascript'>alert('Credenziali errate');</script>";
		//echo "Credenziali errate";
		echo " msgdb : $risultato";
	}
}
?>
<?php include 'login.html';?>
