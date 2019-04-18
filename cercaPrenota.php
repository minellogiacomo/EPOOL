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

$objectt = new Business();
$res = $objectt->getInfoTappe();
echo '<div class="book-taxi-section">  <div class="container"> 	<div class="section-header section-header-white">
			<h6>Tappe Disponibili </h6></div> <form class="row" >';
while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Id Tragitto</label>
                <input type="text"  Value="' . $row['ID_TRAGITTO'] . '" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Città</label>
                <input type="text"  Value="' . $row['CITTA'] . '" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Via</label>
                <input type="text"  Value="' . $row['VIA'] . '" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Posti</label>
                <input type="text"  Value="' . $row['POSTI'] . '" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Orario</label>
                <input type="datetime"  Value="' . $row['ORARIO_ARRIVO'] . '" readonly class="form-control"/>
     </div>';
    echo '<hr>...</hr>';
}
echo '</form></div></div>';

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