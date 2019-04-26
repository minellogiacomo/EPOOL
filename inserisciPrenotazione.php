
<?php
if(!isset($_SESSION))
{
    session_start();
} ;
if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])){
    header("location: index.php");
}
?>
<?php include_once('car.php');?>
<?php include 'header.html';?>
<?php include 'menu.html';?>
<?php include 'slider.html';?>
<?php
$object = new Car();
$res = $object -> getVeicoli();


if(isset($_POST['submit1'])){
    $Note=$_POST['Note'];
    $Automobile=$_POST['automenu'];
    $IndirizzoArrivo=$_POST['sostamenu'];


    $res = $object -> insertPrenotazione($Note,  $Automobile, $_SESSION["email"], $IndirizzoArrivo);
    if ($res==true) {
        echo "<script type='text/javascript'>document.location.href='terminaPrenotazione.php';</script>";
        // echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    }else{
        echo "<script type='text/javascript'>alert('Errorrrate');</script>";
        //echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        header("Location: homeUser.php");
    }
}
?>
<?php include('inserisciPrenotazione1.php');?>
<?php include('visualizzaPrenotazioni.html');?>
<?php include('footer.html');?>
