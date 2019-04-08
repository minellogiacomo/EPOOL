
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
    $Note=$_POST['Note'];
    $Automobile=$_POST['Auto'];
    $IndirizzoPartenza=$_POST['IndirizzoPartenza'];
    $IndirizzoArrivo=$_POST['IndirizzoArrivo'];

    $objectc = new Car();
    $res = $objectc -> insertPrenotazione( $Note,  $Automobile, $_SESSION['email'], $IndirizzoPartenza, $IndirizzoArrivo);
    if ($res==true) {
        echo "<script type='text/javascript'>alert('Operazione eseguita');</script>";
        header("Location: homeUser.php");
        // echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    }else{
        echo "<script type='text/javascript'>alert('Error');</script>";
        //echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        header("Location: homeUser.php");
    }
}
?>
<?php include('inserisciPrenotazione.html');?>
<?php include('footer.html');?>