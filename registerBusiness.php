<?php
 
 if(!isset($_SESSION)) 
    { 
        session_start();
        echo "creo sessione register ";
    } 
include_once('user.php');

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

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="../../../../favicon.ico">

    <title>SMC Registrazione</title>


    <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

      <link rel="stylesheet" type="text/css" href="css/register.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>
<body>
  <div id = "Header" align="center">
    <hr><h2 class="ex1"> REGISTRAZIONE UTENTI </h2></hr>
  </div>
  <div id = "content" class="center">
    <form action='register.php' method="post">
    <table align="center">
      <tr>
        <td> <b class="ex1"> Nickname:  </b></td>
        <td><input type='text' name="nickname" id="nickname" placeholder="Nickname" required><td>
      </tr>
      <tr>
        <td> <b class="ex1"> Email:  </b></td>
        <td><input type='text' name="email" id="email" placeholder="example@example.com" required><td>
      </tr>
      <tr>
        <td> <b class="ex1"> Password:  </b></td>
        <td><input type='password' name="password" id="password" placeholder="*********" required><td>
      </tr>
      <tr>
        <td> <b class="ex1"> Data di nascita:  </b></td>
        <td><input type='date' name="datanascita" id="datanascita" onkeydown="return false" required><td>
      </tr>
      <tr>
        <td> <b class="ex1"> Città di residenza:  </b></td>
        <td><input type='text' name="cittaresidenza" id="cittaresidenza" placeholder="Città" required><td>
        
      </tr>
      <tr>
        <td> <b class="ex1"> Regione:  </b></td>
        <td><input type='text' name="regione" id="regione" placeholder="Regione" required><td>
      </tr>
      <tr>
        <td> <b class="ex1"> Stato:  </b></td>
        <td><input type='text' name="stato" id="stato" placeholder="Stato" required><td>
      </tr>
      <tr>
        <td> <b class="ex1"> Tipo:  </b></td>
        <td>  <input type="radio" name="tipo" value="semplice" checked> Web user <br> 
        <input type="radio" name="tipo" value="gestore"> Company <td>
      </tr>
    </table>  
        <input type='submit' name="signup" value='Sign up'></div>
    </form>     
  </div>
  
</body>
</html>