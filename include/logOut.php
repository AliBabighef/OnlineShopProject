<?php
ob_start();
session_start();
    if(isset($_SESSION['userEcommerce'])){
        session_unset();

        session_destroy();

        header('location: ../BI3_O_CHRI/logIn.php');

        exit();
    }
ob_end_flush()
?>