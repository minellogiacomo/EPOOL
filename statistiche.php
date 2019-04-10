<?php include 'header.html';?>
<?php include 'menu.html';?>
<?php include 'slider.html';?>
<?php include('stati.php');?>
<?php
$object = new Stati();
$res = $object -> getClassificaSegnalazioni();
echo'<div class="book-taxi-section">  <div class="container"> 	<div class="section-header section-header-white">
			<h6>Classifica Segnalazioni</h6></div> <form class="row" >';
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Utente</label>
                <input type="text"  Value="'.$row['EMAIL'].'" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Numero Segnalazioni</label>
                <input type="text"  Value="'.$row['NUMERO_SEGNALAZIONI'].'" readonly class="form-control"/>
     </div><hr>...</hr>';
}
echo'</form></div></div>';

$res = $object -> getClassificaVoto();
echo'<div class="book-taxi-section">  <div class="container"> 	<div class="section-header section-header-white">
			<h6>Classifica Voti Utente</h6></div> <form class="row" >';
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Utente</label>
                <input type="text"  Value="'.$row['UTENTE'].'" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Voto Medio</label>
                <input type="text"  Value="'.$row['MEDIA_VOTO'].'" readonly class="form-control"/>
     </div><hr>...</hr>';
}
echo'</form></div></div>';


$res = $object -> getClassificaVeicoli();
echo'<div class="book-taxi-section">  <div class="container"> 	<div class="section-header section-header-white">
			<h6>Classifica Prenotazione Modelli </h6></div> <form class="row" >';
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Modello Automobile</label>
                <input type="text"  Value="'.$row['MODELLO'].'" readonly class="form-control"/>
     </div>';
    echo ' <div class="form-group col-lg-4 col-md-6">
                <label>Numero Prenotazioni</label>
                <input type="text"  Value="'.$row['NUMERO_PRENOTAZIONI'].'" readonly class="form-control"/>
     </div>';
    echo'<hr>...</hr>';
}
echo'</form></div></div>';

?>
<?php include('statistiche.html');?>
<?php include('footer.html');?>