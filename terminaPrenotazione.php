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
<?php include 'header.html';?>
<?php include 'menu.html';?>
<?php include 'slider.html';?>
<?php
$object = new Car();
$res = $object -> getVeicoloPrenotato($_SESSION["email"]);

$Automobile=0;

while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
  $Automobile = $row['AUTO'];

}

if ($Automobile==null) {

  header("Location: homeUser.php");
  die();
}
if(isset($_POST['termina'])) {
$objectC = new Car();
$res1 = $objectC -> endBooking($_SESSION["email"], $Automobile);
    echo "<script type='text/javascript'>document.location.href='inserisciPrenotazione.php';</script>";
}




?>
<?php include('terminaPrenotazione.html');?>
<?php include('footer.html');?>
