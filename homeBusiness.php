<?php 
  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ;
if (!isset($_SESSION["email"]) or !isset($_SESSION["password"]) or $_SESSION["type"]==1){
    header("location: index.php");
}
?>
<?php include 'header.html';?>
<?php include 'menu.html';?>
<?php include 'slider.html';?>
<?php include('homeUser.html');?>
<?php include('homeBusiness.html');?>
<?php include('footer.html');?>


