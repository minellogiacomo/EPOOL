<?php
if (!isset($_SESSION)) {
    session_start();
};

if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])) {
    header("location: index.php");
}

?>
<?php include_once('business.php'); ?>
<?php include 'header.html'; ?>
<?php include 'menu.html'; ?>
<?php include 'slider.html'; ?>
<?php
$object = new Business();
$res = $object->getInfoSocieta();
echo '<div class="book-taxi-section">  <div class="container"> 	<div class="section-header section-header-white">
    <h6>Informazioni Società </h6></div> <form class="row" >';
while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    echo ' <div class="form-group col-lg-4 col-md-6">
        <label>Nome Azienda</label>
        <input type="text"  Value="' . $row['NOME'] . '" readonly class="form-control"/>
    </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
        <label>Indirizzo</label>
        <input type="text"  Value="' . $row['URL'] . '" readonly class="form-control"/>
    </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
        <label>Telefono</label>
        <input type="text"  Value="' . $row['TELEFONO'] . '" readonly class="form-control"/>
    </div>';
    $objectPdf = new Business();
    $resp = $objectPdf->visualizzaPdf($row['NOME']);
    while ($rowl = $resp->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($rowl['PATH'])) {
            echo ' <div class="form-group col-lg-4 col-md-6">
        <embed src="' . $rowl['PATH'] . '"  type="application/pdf" />
    </div>';
        }
    }
    echo '<hr>...</hr>';
}
echo '</form></div></div>';

?>
<?php //include('visualizza.html');?>
<?php include('footer.html'); ?>