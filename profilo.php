<?php
if (!isset($_SESSION)) {
    session_start();
};

if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])) {
    header("location: index.php");
}

?>
<?php include_once('user.php'); ?>
<?php include 'header.html'; ?>
<?php include 'menu.html'; ?>
<?php include 'slider.html'; ?>
<?php
$object = new User();
$res = $object->getInfoUtente($_SESSION["email"]);
echo '<div class="book-taxi-section">  <div class="container"> 	<div class="section-header section-header-white">
			<h6>Informazioni Utente </h6></div> <form class="row" >';
while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>EMAIL</label>
                <input type="text"  Value="' . $row['EMAIL'] . '" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>NOME</label>
                <input type="text"  Value="' . $row['NOME'] . '" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>COGNOME</label>
                <input type="text"  Value="' . $row['COGNOME'] . '" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Data di Nascita</label>
                <input type="text"  Value="' . $row['DATANASCITA'] . '" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Città</label>
                <input type="text"  Value="' . $row['LUOGO'] . '" readonly class="form-control"/>
     </div>';
    echo '<hr>...</hr>';
}
echo '</form></div></div>';

?>
<?php include('visualizzaFoto.php'); ?>
<?php include('profilo.html'); ?>
<?php include('inserisciFoto.php'); ?>
<?php include('footer.html'); ?>