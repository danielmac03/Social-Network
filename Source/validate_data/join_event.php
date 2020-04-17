<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';

if ($_GET['id']){

    $event = getEvents($db, mysqli_real_escape_string($db, $_GET['id']));
    $event = mysqli_fetch_assoc($event);

    if($_SESSION['user_identify']['id'] != $event['user_host']){

        $users = explode(" ", $event['users']);

        if(count($users) < $event['max_users']) {

            for ($i = 0; $i <= (count($users)-1); $i++) {

                if ($users[$i] != $_SESSION['user_identify']['id']){

                    $users = implode(" ", $users);
                    
                    if(empty($users)){
                        $users = $_SESSION['user_identify']['id'];
                    } else {
                        $users = " " . $_SESSION['user_identify']['id'];
                    }

                    $sql = "UPDATE events SET users = $users WHERE id =" . $event['id'];
                    mysqli_query($db, $sql);

                    break;
                }
            }

        } else {
            $_SESSION['errors']['general'] = "The event is full";
        }

    } else {
        $_SESSION['errors']['general'] = "You cannot join your same event";
    }

} else {
    $_SESSION['errors']['general'] = "An error has occurred with the data";
}

header('Location: ../pages/events.php');

?>