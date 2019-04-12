<?php

if(!isset($_SESSION))
{
    session_start();

}
include_once('business.php');


if(isset($_POST['signup'])){
    $nome=$_POST['nome'];
    $cognome=$_POST['cognome'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $dataNascita=$_POST['datanascita'];
    $citta=$_POST['citta'];
    $azienda=$_POST['nomeazienda'];

    $object = new Business();
    $res = $object -> RegistrazioneAziendale($nome, $cognome, $email, $password,  $dataNascita, $citta, $azienda);
    echo $res;
    if ($res=true) {
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header("Location: index.php");
    }else{
        //echo "Utente già presente nella piattaforma.";
        //echo "messaggio dal server : $res";
        // exit();
    }

}

?>
<?php include 'header.html';?>
<?php include 'menu.html';?>
<?php include 'slider.html';?>
<?php include 'registerBusiness.html';?>
<?php include 'footer.html';?>
