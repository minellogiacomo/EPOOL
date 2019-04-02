<?php
 
 if(!isset($_SESSION)) 
    { 
        session_start();
        echo "creo sessione register ";
    } 
include_once('business.php');

if(isset($_POST['signup'])){
  
  $nickname=$_POST['nickname'];
  $email=$_POST['email'];
  $password=$_POST['password'];
  $dataNascita=$_POST['datanascita'];
  $cittaResidenza=addslashes($_POST['cittaresidenza']);
  $regione=addslashes($_POST['regione']);
  $stato=addslashes($_POST['stato']);
  $tipo=$_POST['tipo'];



  if ($tipo == 'gestore') {
    $object = new User();
    $res = $object -> SignupCommercial($nickname, $email, $password, $dataNascita, $cittaResidenza, $regione, $stato, $tipo);
    if ($res == 1) {
      $_SESSION["uname"] = $nickname;
      $_SESSION["psswd"] = $password;
      $_SESSION["citta"] = $cittaResidenza;
      $_SESSION["tipo"] = $tipo;
      $_SESSION["email"] = $email;
      $_SESSION["datan"] = $dataNascita;
      $_SESSION["regione"] = $regione;
      $_SESSION["stato"] = $stato;

      header("Location: http://localhost/Progetto_0.0.2/registerCommercialAttractiveness.php");

    }else{
      echo "Utente già presente nella piattaforma.";
      echo "messaggio dal server : $res";
      // exit();
    }
    
  }else{
    $object = new User();
    $res = $object -> Signup($nickname, $email, $password, $dataNascita, $cittaResidenza, $regione, $stato, $tipo);
    if ($res == 1) {
      $_SESSION["uname"] = $nickname;
      $_SESSION["psswd"] = $password;
      $_SESSION["citta"] = $cittaResidenza;
      $_SESSION["tipo"] = $tipo;
      $_SESSION["email"] = $email;
      $_SESSION["datan"] = $dataNascita;
      $_SESSION["regione"] = $regione;
      $_SESSION["stato"] = $stato;
      // $object = new User();
      $log = $object -> Login($nickname, $password);
      
      if ($log == 1) {
        header("Location: http://localhost:/Progetto_0.0.2/home.php");
        die();
      }else{
        echo "[ERRORE] Credenziali errate : ".$log;
      }
    }else{
      echo "Utente già presente nella piattaforma. => ".$res;
      // exit();
    }
  }

}

?>
<?php include 'registerBusiness.html';?>