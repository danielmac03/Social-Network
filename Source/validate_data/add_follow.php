<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

if ($_SESSION['user_identify']) {

    $user_send = (int)mysqli_real_escape_string($db, $_GET['id_send']);
    $user_receive = (int)mysqli_real_escape_string($db, $_GET['id_receive']);

    if($_GET['private_account'] == 1) {

        if (isset($user_receive) && isset($user_send)){

            $sql = "INSERT INTO friends VALUE (null, $user_send, $user_receive, 0, 0, NOW())";
            mysqli_query($db, $sql);

            $_SESSION['completed'] = "The invitation has been sent";
        }

    } else {
        $sql = "INSERT INTO friends VALUE (null, $user_send, $user_receive, 2, 0, NOW())";
        mysqli_query($db, $sql);

        $_SESSION['completed'] = "The invitation has been sent";
    }
}

header("Location: ../../index.php");

?>