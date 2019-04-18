<?php
if (!isset($_SESSION)) {
    session_start();
};
if (!isset($_SESSION["email"]) or !isset($_SESSION["password"]) or $_SESSION["type"] == 1) {
    header("location: index.php");
}
?>
<?php include_once('car.php'); ?>
<?php include 'header.html'; ?>
<?php include 'menu.html'; ?>
<?php include 'slider.html'; ?>
<?php
if (isset($_POST['submit'])) {
    $km = $_POST['km'];
    $tipo = $_POST['tipo'];
    $numero = $_POST['nTappe'];
    $object = new Car();
    $res = $object->insertTragitto($_SESSION["email"], $km, $tipo);
    if (!empty($res)) {
        $Note = $_POST['Note'];
        $Automobile = $_POST['Auto'];
        $IndirizzoPartenza = $_POST['IndirizzoPartenza'];
        $IndirizzoArrivo = $_POST['IndirizzoArrivo'];
        $Email = $_SESSION["email"];
        $objecttmp = new Car();
        $response = $objecttmp->insertPrenotazioneAziendale($res, $Note, $Automobile, $Email, $IndirizzoPartenza,
            $IndirizzoArrivo);
        for ($i = 0; $i < $numero; $i++) {
            $id = $res;
            $citta = $_POST['partenza' . ($i + 1)];
            $via = $_POST['via' . ($i + 1)];
            $orario = $_POST['orario' . ($i + 1)];
            $res = $object->insertTappa($id, $citta, $via, $orario);

        }
        echo "<script type='text/javascript'>alert('Operazione Eseguita');</script>";
        // header("Location: homeBusiness.php");
        echo "<script type='text/javascript'>document.location.href='homeBusiness.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Errorrrate');</script>";
        echo "<script type='text/javascript'>document.location.href='homeBusiness.php';</script>";
    }
}
?>
<?php include('inserireTragitto.html'); ?>
<?php include('footer.html'); ?>