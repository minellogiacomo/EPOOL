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
$res = $object -> getVeicoli();
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo '<div>';
    echo $row['TARGA'];
    echo '</div>';
}

if(isset($_POST['submit1'])){
    $SocietaAutomobile=$_POST['SocietaAutomobile'];
    $DataSegnalazione=$_POST['DataSegnalazione'];
    $TitoloSegnalazione=$_POST['TitoloSegnalazione'];
    $TestoSegnalazione=$_POST['TestoSegnalazione'];
    $Automobile=$_POST['Automobile'];
    $res = $object -> insertSegnalazione($_SESSION["email"], $SocietaAutomobile, $DataSegnalazione,$TitoloSegnalazione, $TestoSegnalazione,$Automobile);
    if ($res==true) {
        echo "<script type='text/javascript'>alert('Operazione eseguita');</script>";
        header("Location: homeUser.php");
    }else{
        echo "<script type='text/javascript'>alert('Errorrrate');</script>";
        header("Location: homeUser.php");
    }
}
?>
<?php include('inserisciSegnalazione.html');?>
<?php include('footer.html');?>