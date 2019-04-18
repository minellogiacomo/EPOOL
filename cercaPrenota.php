<?php
if (!isset($_SESSION)) {
    session_start();
};
if (!isset($_SESSION["email"]) or !isset($_SESSION["password"]) or $_SESSION["type"] == 1) {
    header("location: index.php");
}
?>
<?php include_once('business.php'); ?>
<?php include 'header.html'; ?>
<?php include 'menu.html'; ?>
<?php include 'slider.html'; ?>
<?php


if (isset($_POST['submit'])) {
    $Tragitto = $_POST['Tragitto'];
    $IndirizzoPartenza = $_POST['IndirizzoPartenza'];
    $IndirizzoArrivo = $_POST['IndirizzoArrivo'];
    $Email = $_SESSION["email"];
    $object = new Business();
    $res = $object->insertPassaggio($Tragitto, $Email, $IndirizzoPartenza, $IndirizzoArrivo);
    if ($res !== false) {
        echo "<script type='text/javascript'>alert('Operazione eseguita');</script>";
        echo "<script type='text/javascript'>document.location.href='homeBusiness.php';</script>";
        // echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Errorrrate');</script>";
        //echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo "<script type='text/javascript'>document.location.href='homeBusiness.php';</script>";
    }
}
?>
<?php include('cercaPrenota.html'); ?>
<?php include('footer.html'); ?>