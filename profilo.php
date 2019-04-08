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
<?php include('header.html');?>
<?php include('menuUser.html');?>
<?php
$object = new User();
$res = $object -> getInfoUtente($_SESSION["email"]);
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo '<div>';
    echo $row['EMAIL'];
    echo '</div>';
}

?>
<?php include('profilo.html');?>
<?php include('inserisciFoto.php');?>
<?php include('visualizzaFoto.php');?>
<?php include('footer.html');?>