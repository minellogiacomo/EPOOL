<?php 
  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ;
	
  if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])){
	  header("location: login.php");
	  }
  
?>
<?php include_once('car.php');?>
<?php include('header.html');?>
<?php include('menuUser.html');?>
<?php
$object = new Car();
$res = $object -> getVeicoliDisponibili();
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo '<div>';
    echo $row['TARGA'];
    echo '</div>';
}

?>
<?php include('visualizzaVeicoliDisponibili.html');?>
<?php include('footer.html');?>
