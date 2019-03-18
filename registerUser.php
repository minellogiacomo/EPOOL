<?php
 
 if(!isset($_SESSION)) 
    { 
        session_start();
        echo "registrazione";
    } 
include_once('user.php');

if(isset($_POST['signup'])){
  $nome=$_POST['nome'];
  $cognome=$_POST['cognome'];
  $email=$_POST['email'];
  $password=$_POST['password'];
  $dataNascita=$_POST['datanascita'];
  $citta=addslashes($_POST['citta']);

  $object = new User();
  $res = $object -> Signup($nome, $cognome, $email,  $password, $dataNascita);
    if ($res == 1) {
      $_SESSION["uname"] = $nickname;
      $_SESSION["psswd"] = $password;
      $_SESSION["citta"] = $cittaResidenza;
      $_SESSION["tipo"] = $tipo;
      $_SESSION["email"] = $email;
      $_SESSION["datan"] = $dataNascita;
      $_SESSION["regione"] = $regione;
      $_SESSION["stato"] = $stato;

    }else{
      echo "Utente già presente nella piattaforma.";
      echo "messaggio dal server : $res";
      // exit();
    }
    
  

}

?>
<?php include 'registerUser.html';?>

