<?php include('header.html');?>
<?php include('menuUser.html');?>
<?php include('menuBusiness.html');?>
<?php include('stati.php');?>
<?php
$object = new Stati();
$res = $object -> getClassificaSegnalazioni();
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo '<div>';
    echo $row['EMAIL'];
    echo $row['NUMERO_SEGNALAZIONI'];
    echo '</div>';
}

$res = $object -> getClassificaVoto();
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo '<div>';
    echo $row['UTENTE'];
    echo $row['MEDIA_VOTO'];
    echo '</div>';
}

$res = $object -> getClassificaVeicoli();
while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo '<div>';
    echo $row['MODELLO'];
    echo $row['NUMERO_PRENOTAZIONI'];
    echo '</div>';
}

?>
<?php include('statistiche.html');?>
<?php include('footer.html');?>