<?php 
  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ;
	
  if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])){
	  header("location: login.php");
	  }
  
?>
<?php include('header.html');?>
<?php include('menuUser.html');?>
<?php include('homeUser.html');?>
<?php include('footer.html');?>