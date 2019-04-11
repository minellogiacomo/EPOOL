<?php 
  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ;
	
  if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])){
	  header("location: index.php");
	  }
  
?>
<?php include 'header.html';?>
<?php include 'menu.html';?>
<?php include 'slider.html';?>
<?php include_once('user.php');?>
<?php
$object = new User();
$res = $object ->getBookingList($_SESSION["email"]);
echo'<div class="book-taxi-section">  <div class="container"> 	<div class="section-header section-header-white">
			<h6>Storico Prenotazioni </h6></div> <form class="row" >';
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Inizio</label>
                <input type="datetime"  Value="'.$row['INIZIO'].'" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Fine</label>
                <input type="datetime"  Value="'.$row['FINE'].'" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Note</label>
                <input type="text"  Value="'.$row['NOTE'].'" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Automobile</label>
                <input type="text"  Value="'.$row['AUTO'].'" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Indirizzo di Partenza</label>
                <input type="text"  Value="'.$row['INDIRIZZO_PARTENZA'].'" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Indirizzo di Arrivo</label>
                <input type="text"  Value="'.$row['INDIRIZZO_ARRIVO'].'" readonly class="form-control"/>
     </div>';
}
echo'</form></div></div>';

?>
<?php include('visualizzaPrenotazioni.html');?>
<?php include('footer.html');?>