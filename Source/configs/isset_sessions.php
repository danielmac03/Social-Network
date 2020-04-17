<?php

session_start();

if ($_SESSION['user_identify']['id'] == false){

    $_SESSION['errors']['general'] = "You must start session before";
    header('Location: ../../index.php');
    die();
    
}

?>