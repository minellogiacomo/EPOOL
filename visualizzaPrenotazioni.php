<?php include('header.html');?>
<?php

include_once('user.php');


  if(!isset($_SESSION))
    {
        session_start();
    } ;

  if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])){
	  header("location: login.php");
	  }

    $object = new User();
  	$res = $object ->getBookingList($_SESSION["email"]);
    while ($row=$res->fetch(PDO::FETCH_ASSOC)) {

      echo '<div>';
      echo $row['INIZIO'];
      echo $row['FINE'];
      echo $row['NOTE'];
      echo $row['AUTO'];
      echo $row['UTENTE'];
      echo $row['INDIRIZZO_PARTENZA'];
      echo $row['INDIRIZZO_ARRIVO'];
      echo '</div>';

    }



?>
<?php include('footer.html');?>
