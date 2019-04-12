<?php ob_start(); ?>
<?php
include_once('business.php');
 if(!isset($_SESSION)) 
    { 
        session_start();
    } 
	
if(isset($_POST['submit'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$object = new Business();
	$risultato = $object ->LoginBusiness($email, $password);
	if ($risultato==true) {
		if(isset($_SESSION))
		{
			session_unset();
		}
		$_SESSION["email"] = $email;
		$_SESSION["password"] = $password;
		$_SESSION["type"]=3;
		header("Location: homeBusiness.php"); 
		die();
	}else{
		echo "<script type='text/javascript'>alert('Credenziali errate');</script>";
		header("Location: index.php");
	}
}
?>

<?php include 'loginAziendale.html';?>
