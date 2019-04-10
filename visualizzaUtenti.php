<?php 
  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ;
	
  if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])){
	  header("location: index.php");
	  }
  
?>
<?php include_once('user.php');?>
<?php include 'header.html';?>
<?php include 'menu.html';?>
<?php include 'slider.html';?>
<?php
$object = new User();
$res = $object -> getInfoUtenti($_SESSION["email"]);
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo '<div>';
    echo $row['EMAIL'];
    echo '</div>';
}

?>
<?php include('visualizzaUtenti.html');?>
<?php include('footer.html');?>