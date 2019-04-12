<?php

if(!isset($_SESSION))
{
    session_start();

}
include_once('user.php');

if(isset($_POST['signup'])){
    $nome=$_POST['nome'];
    $cognome=$_POST['cognome'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $dataNascita=$_POST['datanascita'];
    $citta=$_POST['citta'];

    $object = new User();
    $res = $object -> registerUser($nome, $cognome, $email,  $password, $dataNascita, $citta);
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
<?php include 'registerUser.html';?>
<?php include 'footer.html';?>
