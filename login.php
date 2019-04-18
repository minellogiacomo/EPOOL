<?php ob_start(); ?>
<?php
include_once('user.php');

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $object = new User();
    $risultato = $object->Login($email, $password);
    if ($risultato == true) {
        if (isset($_SESSION)) {
            session_unset();
        }
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        $risultato = $object->getInfoUserType($email);
        $_SESSION["type"] = $risultato;
        header("Location: homeUser.php");
    } else {
        echo "<script type='text/javascript'>alert('Credenziali errate');</script>";
        //echo "Credenziali errate";
        echo " msgdb : $risultato";
    }
}
?>

<?php include 'login.html'; ?>
