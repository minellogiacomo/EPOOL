<?php 
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ;

?>
<?php include('header.html');?>
<?php include('menuUser.html');?>
<?php include('homeUser.html');?>
<?php include('footer.html');?>