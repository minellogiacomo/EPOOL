
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
<?php include_once('user.php');?>
<?php include 'header.html';?>
<?php include 'menu.html';?>
<?php include 'slider.html';?>
<?php


if(isset($_POST['submit1'])){
    $TitoloSegnalazione=$_POST['TitoloSegnalazione'];
    $TestoSegnalazione=$_POST['TestoSegnalazione'];
    $Automobile=$_POST['automenu'];
    $object = new Car();
    $res = $object -> insertSegnalazione($_SESSION["email"], $TitoloSegnalazione, $TestoSegnalazione,$Automobile);
    if ($res==true) {
        echo "<script type='text/javascript'>alert('Operazione eseguita');</script>";

    }else{

        echo "<script type='text/javascript'>alert('Errorrrate');</script>";

    }
}
?>
<?php include('inserisciSegnalazione1.php');?>
<?php include('footer.html');?>
