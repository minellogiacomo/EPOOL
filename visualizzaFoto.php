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
<?php
$objectFoto = new User();
$res = $objectFoto -> visualizzaFoto($_SESSION['email']);
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo $row['PATHFOTO'];
}
?>