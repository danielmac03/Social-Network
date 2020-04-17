<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';


$user_send = (int)mysqli_real_escape_string($db, (int)$_GET['id_send']);
$user_receive = (int)mysqli_real_escape_string($db,(int)$_GET['id_receive']);

if (isset($user_receive) && isset($user_send)) {

    if ($user_send == $_SESSION['user_identify']['id']) {

        $sql = "DELETE FROM friends WHERE user_send = $user_send AND user_receive = $user_receive";
        mysqli_query($db, $sql);

        $_SESSION['completed'] = "The invitation has been sent";

    }

} else {
    $_SESSION['errors']['general'] = "There was an error sending the data";
}

header("Location: ../../index.php");

?>