<?php ob_start(); ?>
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
    $Testo = $_POST['Testo'];
    $Voto = $_POST['Voto'];
    $Utente = $_POST['Utente'];
    $object = new Business();
    $res = $object->insertValutazione($_SESSION['email'], $Testo, $Voto, $Utente);

    if ($res == true) {
        echo "<script type='text/javascript'>alert('Operazione eseguita');</script>";
        header("Location: homeBusiness.php");
        // echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Errorrrate');</script>";
        //echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        header("Location: homeBusiness.php");
    }
}
?>
<?php include('inserireValutazione.html'); ?>
<?php include('footer.html'); ?>