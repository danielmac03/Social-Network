<?php
session_start();

if ($_SESSION['user_identify'] != false){
    session_destroy();
}

header("Location: ../index.php");

?>