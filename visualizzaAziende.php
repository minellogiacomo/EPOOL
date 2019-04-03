<?php
if(!isset($_SESSION))
{
    session_start();
} ;

if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])){
    header("location: login.php");
}

?>
<?php include_once('business.php');?>
<?php include('header.html');?>
<?php include('menuUser.html');?>
<?php
$object = new Business();
$res = $object -> getInfoAziende();
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo '<div>';
    echo $row['NOME'];
    echo '</div>';
}

?>
<?php include('visualizzaAziende.html');?>
<?php include('footer.html');?>