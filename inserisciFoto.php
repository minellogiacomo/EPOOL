<?php
if (!isset($_SESSION)) {
    session_start();
};

if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])) {
    header("location: index.php");
}

?>
<?php include_once('user.php'); ?>
<?php
$object = new User();


if (isset($_POST["inserisciFoto"])) {
    $file = $_FILES['file'];
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'svg');
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileCode = uniqid('', true);
                $fileNameNew = $fileCode . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $fileNameNew;
                $res = $object->insertFoto($_SESSION["email"], $fileDestination);

                move_uploaded_file($fileTmpName, $fileDestination);
                //header("Location: ");
            } else {
                echo "File troppo grande!";
            }
        } else {
            echo "Errore nel caricamento del file!";
        }
    } else {
        echo "Non puoi inserire file di questo formato!";
    }
}
?>
<?php include('inserisciFoto.html'); ?>
