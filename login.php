<?php 
include_once('user.php');
 if(!isset($_SESSION)) 
    { 
        session_start();
    } 
	
if(isset($_POST['submit'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$object = new User();
	$risultato = $object ->Login($email, $password);
	if ($risultato==true) {
		$_SESSION["email"] = $email;
		$_SESSION["password"] = $password;
		//$object -> getInfoUser($nickname, $password);
		header("Location: homeUser.php"); 
		die();
	}else{
		echo "<script type='text/javascript'>alert('Credenziali errate');</script>";
		//echo "Credenziali errate";
		echo " msgdb : $risultato";
	}
}
?>

<?php include 'login.html';?>
