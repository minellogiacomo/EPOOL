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
//"<p>\n\tindented\n</p>\n
  echo '<table style="width:100%">';
  echo '<tr>';


    echo'<th>INIZIO</th>';
    echo'<th>FINE</th>';
    echo'<th>NOTE</th>';
    echo'<th>AUTO</th>';
    echo'<th>UTENTE</th>';
    echo'<th>INDIRIZZO_PARTENZA</th>';
    echo'<th>INDIRIZZO_ARRIVO</th>';
      echo'</tr>';

      //echo '<div>';
echo'<tr>';
      echo '<td>'.$row['INIZIO'].'</td>';
      echo '<td>'.$row['FINE'].'</td>';
      echo '<td>'.$row['NOTE'].'</td>';
      echo '<td>'.$row['AUTO'].'</td>';
      echo '<td>'.$row['UTENTE'].'</td>';
      echo '<td>'.$row['INDIRIZZO_PARTENZA'].'</td>';
      echo '<td>'.$row['INDIRIZZO_ARRIVO'].'</td>';
      //echo '</div>';
echo'</tr>';
echo '</table>';
    }



?>
<?php include('footer.html');?>
